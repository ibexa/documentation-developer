#!/usr/bin/env python3
"""
Documentation Review Audit Tool
================================

Scores all documentation pages by review priority using three signals:
  1. Git staleness    – how long since the file was last meaningfully modified
  2. Incoming links   – highly-linked pages are most important to keep accurate
  3. Stale patterns   – old version strings, legacy product names found in content

Usage:
    python3 tools/doc_audit/audit.py
    python3 tools/doc_audit/audit.py --batch 30
    python3 tools/doc_audit/audit.py --section api
    python3 tools/doc_audit/audit.py --output my_queue.csv
"""

import argparse
import csv
import re
import subprocess
import sys
from datetime import date
from pathlib import Path


# ─────────────────────────────────────────────────────────────────────────────
# CONFIGURATION — edit these values to tune the review prioritization
# ─────────────────────────────────────────────────────────────────────────────

# Signal weights (must sum to 1.0 for scores to stay in the 0–1 range before
# the section multiplier is applied).
WEIGHT_STALENESS = 1   # git age: older = higher priority
WEIGHT_LINKS     = 0   # incoming links: more-linked = more important to be correct
WEIGHT_PATTERNS  = 0   # stale text patterns found in the file's content

# Per-section priority multipliers applied on top of the weighted score.
# 1.0 = neutral  |  2.0 = double priority  |  0.5 = half priority
# The section name is the top-level directory directly under docs/.
SECTION_WEIGHTS = {
    "getting_started":                2.0,
    "tutorials":                      2.0,
    "api":                            1.8,
    "content_management":             1.5,
    "commerce":                       1.5,
    "pim":                            1.5,
    "permissions":                    1.3,
    "search":                         1.3,
    "templating":                     1.2,
    "administration":                 1.2,
    "users":                          1.0,
    "customer_management":            1.0,
    "infrastructure_and_maintenance": 1.0,
    "multisite":                      1.0,
    "ibexa_products":                 1.0,
    "ibexa_cloud":                    1.0,
    "discounts":                      1.0,
    "ai_actions":                     1.0,
    "cdp":                            0.8,
    "ibexa_engage":                   0.8,
    "personalization":                0.8,
    "product_guides":                 0.7,
    "resources":                      0.5,
    "release_notes":                  0.2,   # intentionally historical
    "update_and_migration":           0.2,   # version-specific by nature
}

# Text patterns that suggest a page may contain outdated content.
# Uses Python regex syntax. Add patterns as new versions are released.
STALE_PATTERNS = [
    r"eZ Platform",
    r"eZ Publish",
    r"\bez_platform\b",
    r"\bezpublish\b",
    r"\bv3\.\d",
    r"\bv4\.\d",
    r"version 3\.\d",
    r"version 4\.\d",
]

# Top-level directories (directly under docs/) to exclude entirely from scoring.
# These are intentionally historical, include-only, or non-content files.
SKIP_DIRS = [
    "snippets",
    "release_notes",
    "update_and_migration",
    "css",
    "js",
    "fonts",
    "images",
]

# Files with `month_change: false` in frontmatter are explicitly marked as
# "intentionally stable". They are not skipped, but their scores are multiplied
# down so they rarely appear in the top batch. Set to False to disable.
DEPRIORITIZE_MONTH_CHANGE_FALSE = False
MONTH_CHANGE_FALSE_MULTIPLIER   = 0.3

# ── Staleness signal quality ──────────────────────────────────────────────────

# Commits listed in this file are skipped when computing last-meaningful-change
# dates. The same file is used by `git blame` locally and on GitHub.
# Path is relative to the repository root.
BLAME_IGNORE_REVS_FILE = ".git-blame-ignore-revs"

# Commits that modified more than this many files are treated as bulk
# stylistic/housekeeping changes and skipped automatically, even if they aren't
# listed in BLAME_IGNORE_REVS_FILE.
# WARNING: Set to 0 (disabled) unless you are sure large-batch content PRs
# (e.g. adding 50+ new reference pages at once) are already in the ignore file.
# False positives here assign a misleading 2017 creation-date fallback.
BULK_COMMIT_THRESHOLD = 0

# Number of top-priority files shown in the terminal summary.
BATCH_SIZE = 20

# ─────────────────────────────────────────────────────────────────────────────
# END CONFIGURATION
# ─────────────────────────────────────────────────────────────────────────────


# ── Helpers ───────────────────────────────────────────────────────────────────

def find_repo_root() -> Path:
    """Walk upward from this script to find the git repository root."""
    for candidate in [Path(__file__).resolve().parent,
                      Path(__file__).resolve().parent.parent,
                      Path(__file__).resolve().parent.parent.parent]:
        if (candidate / ".git").exists():
            return candidate
    result = subprocess.run(
        ["git", "rev-parse", "--show-toplevel"],
        capture_output=True, text=True, check=True,
    )
    return Path(result.stdout.strip())


def load_ignored_revs(repo_root: Path) -> set[str]:
    """
    Load commit hashes to skip from .git-blame-ignore-revs.
    Returns a set of full SHA strings (comments and blank lines are ignored).
    """
    ignore_file = repo_root / BLAME_IGNORE_REVS_FILE
    if not ignore_file.exists():
        return set()
    hashes: set[str] = set()
    for line in ignore_file.read_text(encoding="utf-8").splitlines():
        line = line.strip()
        if line and not line.startswith("#"):
            hashes.add(line)
    return hashes


def collect_markdown_files(docs_dir: Path) -> list[Path]:
    """Return all .md files under docs_dir subdirectories, excluding SKIP_DIRS.
    Files directly in docs/ root (like index.md, search_results.md) are skipped
    as they are not section pages.
    """
    files = []
    for path in sorted(docs_dir.rglob("*.md")):
        rel_parts = path.relative_to(docs_dir).parts
        # Skip files directly in docs/ root (no subdirectory)
        if len(rel_parts) < 2:
            continue
        top_dir = rel_parts[0]
        if top_dir not in SKIP_DIRS:
            files.append(path)
    return files


# ── Staleness ─────────────────────────────────────────────────────────────────

def build_staleness_map(
    repo_root: Path,
    md_files: list[Path],
    ignored_revs: set[str],
) -> dict[Path, date]:
    """
    Run one git-log pass over the entire docs/ history to find each file's
    last *meaningful* modification date.

    Commits are skipped if:
    - their full SHA is listed in `ignored_revs` (.git-blame-ignore-revs), OR
    - they touched more than BULK_COMMIT_THRESHOLD files (auto bulk detection).

    Returns {absolute_path: last_modified_date}.
    """
    print("  ↳ Running git log to extract file modification dates …", flush=True)
    result = subprocess.run(
        [
            "git", "log",
            "--format=COMMIT:%H %ad",   # full hash + date so we can match ignored_revs
            "--date=short",
            "--name-only",
            "--diff-filter=ACRMT",
            "--no-merges",
            "--", "docs/",
        ],
        capture_output=True,
        text=True,
        cwd=str(repo_root),
    )

    staleness_map: dict[Path, date] = {}
    current_date: date | None = None
    current_skip = False          # True when the current commit should be ignored
    current_file_count = 0        # files touched by the current commit

    # Two-pass approach: first collect each commit's file list to count them,
    # then record dates. We do this in a single pass by buffering each commit.
    commits: list[tuple[str, date, list[str]]] = []  # (hash, date, [files])

    cur_hash: str = ""
    cur_date: date | None = None
    cur_files: list[str] = []

    for line in result.stdout.splitlines():
        line = line.strip()
        if line.startswith("COMMIT:"):
            # Save previous commit
            if cur_hash:
                commits.append((cur_hash, cur_date, cur_files))
            parts = line[7:].split(" ", 1)
            cur_hash = parts[0]
            try:
                cur_date = date.fromisoformat(parts[1]) if len(parts) > 1 else None
            except ValueError:
                cur_date = None
            cur_files = []
        elif line.endswith(".md"):
            cur_files.append(line)
        elif not line:
            pass  # blank separator between commits

    # Flush last commit
    if cur_hash:
        commits.append((cur_hash, cur_date, cur_files))

    # Now build staleness map, skipping bulk/ignored commits
    skipped_ignored = 0
    skipped_bulk = 0
    for commit_hash, commit_date, files in commits:
        if commit_hash in ignored_revs:
            skipped_ignored += 1
            continue
        if BULK_COMMIT_THRESHOLD > 0 and len(files) > BULK_COMMIT_THRESHOLD:
            skipped_bulk += 1
            continue
        if commit_date is None:
            continue
        for file_path in files:
            abs_path = (repo_root / file_path).resolve()
            if abs_path not in staleness_map:
                staleness_map[abs_path] = commit_date

    if skipped_ignored or skipped_bulk:
        parts_msg = []
        if skipped_ignored:
            parts_msg.append(f"{skipped_ignored} in .git-blame-ignore-revs")
        if skipped_bulk:
            parts_msg.append(f"{skipped_bulk} bulk (>{BULK_COMMIT_THRESHOLD} files)")
        print(f"  ↳ Skipped {', '.join(parts_msg)}", flush=True)

    # ── Second pass: find creation dates for files that only appear in skipped commits ──
    # We run git log again WITHOUT any filters, looking only at file additions (A)
    # so that new-feature batch PRs don't get a misleading 2017 fallback.
    files_needing_creation_date = [f for f in md_files if f not in staleness_map]
    if files_needing_creation_date:
        print(f"  ↳ Finding creation dates for {len(files_needing_creation_date)} files not covered by filtered log …", flush=True)
        result2 = subprocess.run(
            [
                "git", "log",
                "--format=COMMIT:%ad",
                "--date=short",
                "--name-only",
                "--diff-filter=A",   # additions only
                "--no-merges",
                "--", "docs/",
            ],
            capture_output=True,
            text=True,
            cwd=str(repo_root),
        )
        creation_date: date | None = None
        for line in result2.stdout.splitlines():
            line = line.strip()
            if line.startswith("COMMIT:"):
                try:
                    creation_date = date.fromisoformat(line[7:])
                except ValueError:
                    creation_date = None
            elif line.endswith(".md") and creation_date is not None:
                abs_path = (repo_root / line).resolve()
                if abs_path not in staleness_map:
                    staleness_map[abs_path] = creation_date

    # Ultimate fallback for files with no git history at all
    fallback = date(2017, 1, 1)
    for f in md_files:
        if f not in staleness_map:
            staleness_map[f] = fallback

    return staleness_map


# ── Link Graph ────────────────────────────────────────────────────────────────

_LINK_RE = re.compile(r'\[(?:[^\]]*)\]\(([^)]+)\)')

# Matches the content inside [[= cards([ CONTENT ], ...) =]] blocks.
_CARDS_BLOCK_RE = re.compile(r'\[\[=\s*cards\(\s*\[(.*?)\]', re.DOTALL)
# Within a cards block, extracts quoted strings with no whitespace (= file paths).
# Titles and descriptions always contain spaces; paths never do.
_CARDS_PATH_RE  = re.compile(r'"([^\s"]+)"')


def _resolve_link(source: Path, raw_link: str, docs_dir: Path) -> Path | None:
    """
    Resolve a markdown link relative to its source file.
    Returns the canonical absolute path inside docs/, or None.
    """
    target = raw_link.split("#")[0].split("?")[0].strip()
    if not target:
        return None
    if target.startswith(("http://", "https://", "//", "mailto:", "/")):
        return None
    if not target.endswith(".md"):
        return None
    resolved = (source.parent / target).resolve()
    try:
        resolved.relative_to(docs_dir)
        return resolved
    except ValueError:
        return None


def _build_basename_index(md_files: list[Path]) -> dict[str, Path]:
    """
    Build a {filename: absolute_path} index for autolinks-style resolution.
    The mkdocs-autolinks plugin allows bare filenames (e.g. "importing_data.md")
    to resolve globally — we replicate that here as a fallback.
    Duplicate filenames are noted but only the first occurrence is kept
    (ambiguous links are rare and the count will still be directionally correct).
    """
    index: dict[str, Path] = {}
    for f in md_files:
        name = f.name
        if name not in index:
            index[name] = f
    return index


def _resolve_cards_path(raw_path: str, docs_dir: Path) -> Path | None:
    """
    Resolve a path extracted from a [[= cards([...]) =]] macro.
    Cards paths are docs-root-relative (e.g. "ai_actions/configure_ai_actions").
    Returns the canonical absolute path inside docs/, or None.
    """
    path = raw_path.split("#")[0].strip()   # strip anchor
    if not path:
        return None
    if path.startswith(("http://", "https://")):
        return None
    if path.endswith(".html"):
        return None
    # Append .md if no extension
    if "." not in path.rsplit("/", 1)[-1]:
        path = path + ".md"
    resolved = (docs_dir / path).resolve()
    try:
        resolved.relative_to(docs_dir)
        return resolved
    except ValueError:
        return None


def build_link_graph(md_files: list[Path], docs_dir: Path) -> dict[Path, int]:
    """
    Parse all internal links and return {file: in_degree} count.
    Captures both standard markdown links [text](path.md) and
    [[= cards(["path/to/page", ...]) =]] macro links.

    Uses a two-step resolution strategy for markdown links:
    1. Standard relative resolution (source-file-relative path)
    2. Autolinks fallback: bare filename lookup across all docs files,
       mirroring the behaviour of the mkdocs-autolinks plugin.
    """
    print("  ↳ Parsing internal links to build link graph …", flush=True)
    in_degree: dict[Path, int] = {f: 0 for f in md_files}
    file_set = set(md_files)
    basename_index = _build_basename_index(md_files)
    md_links_total = 0
    autolinks_total = 0
    cards_links_total = 0

    for source in md_files:
        try:
            content = source.read_text(encoding="utf-8", errors="replace")
        except OSError:
            continue

        # Standard markdown links
        for match in _LINK_RE.finditer(content):
            raw = match.group(1)
            target = _resolve_link(source, raw, docs_dir)

            if target and target in file_set:
                in_degree[target] = in_degree.get(target, 0) + 1
                md_links_total += 1
            else:
                # Autolinks fallback: bare filename (no path separator) not found
                # via relative resolution — look it up globally by basename,
                # mirroring the mkdocs-autolinks plugin behaviour.
                bare = raw.split("#")[0].split("?")[0].strip()
                if bare.endswith(".md") and "/" not in bare:
                    fallback = basename_index.get(bare)
                    if fallback and fallback in file_set:
                        in_degree[fallback] = in_degree.get(fallback, 0) + 1
                        autolinks_total += 1

        # Cards macro links
        for block_match in _CARDS_BLOCK_RE.finditer(content):
            block = block_match.group(1)
            for path_match in _CARDS_PATH_RE.finditer(block):
                target = _resolve_cards_path(path_match.group(1), docs_dir)
                if target and target in file_set:
                    in_degree[target] = in_degree.get(target, 0) + 1
                    cards_links_total += 1

    linked_count = sum(1 for v in in_degree.values() if v > 0)
    total = md_links_total + autolinks_total + cards_links_total
    print(f"  ↳ {md_links_total} relative + {autolinks_total} autolinks + {cards_links_total} cards "
          f"= {total} internal links across {linked_count} linked files", flush=True)
    return in_degree


# ── Pattern Scanner ───────────────────────────────────────────────────────────

_COMPILED_PATTERNS = [re.compile(p) for p in STALE_PATTERNS]


def scan_stale_patterns(file_path: Path) -> list[str]:
    """Return the list of STALE_PATTERNS found in the file's content."""
    try:
        content = file_path.read_text(encoding="utf-8", errors="replace")
    except OSError:
        return []
    return [raw for raw, compiled in zip(STALE_PATTERNS, _COMPILED_PATTERNS)
            if compiled.search(content)]


# ── Frontmatter Reader ────────────────────────────────────────────────────────

_FM_BLOCK_RE = re.compile(r'^---\s*\n(.*?)\n---', re.DOTALL)
_FM_KV_RE    = re.compile(r'^(\w+)\s*:\s*(.+)$', re.MULTILINE)


def read_frontmatter(file_path: Path) -> dict[str, str]:
    """Parse the YAML frontmatter block and return a flat key→value dict."""
    try:
        content = file_path.read_text(encoding="utf-8", errors="replace")
    except OSError:
        return {}
    m = _FM_BLOCK_RE.match(content)
    if not m:
        return {}
    return {k.strip(): v.strip() for k, v in _FM_KV_RE.findall(m.group(1))}


# ── Scoring ───────────────────────────────────────────────────────────────────

def score_files(
    md_files: list[Path],
    staleness_map: dict[Path, date],
    link_graph: dict[Path, int],
    docs_dir: Path,
) -> list[dict]:
    today = date.today()

    all_days  = [max((today - staleness_map.get(f, today)).days, 0) for f in md_files]
    all_links = [link_graph.get(f, 0) for f in md_files]
    max_days  = max(all_days)  if all_days  else 1
    max_links = max(all_links) if all_links else 1

    rows = []
    for f in md_files:
        rel           = f.relative_to(docs_dir)
        section       = rel.parts[0] if rel.parts else "unknown"
        last_modified = staleness_map.get(f, date(2017, 1, 1))
        days_stale    = max((today - last_modified).days, 0)
        incoming      = link_graph.get(f, 0)
        stale_hits    = scan_stale_patterns(f)
        fm            = read_frontmatter(f)

        month_change = fm.get("month_change", "")
        edition      = fm.get("edition", "")

        staleness_norm = days_stale / max_days
        links_norm     = incoming   / max_links
        patterns_hit   = 1.0 if stale_hits else 0.0

        s_contrib = staleness_norm * WEIGHT_STALENESS
        l_contrib = links_norm     * WEIGHT_LINKS
        p_contrib = patterns_hit   * WEIGHT_PATTERNS
        raw_score = s_contrib + l_contrib + p_contrib

        section_mult   = SECTION_WEIGHTS.get(section, 1.0)
        priority_score = raw_score * section_mult

        mc_mult = 1.0
        if DEPRIORITIZE_MONTH_CHANGE_FALSE and month_change.lower() == "false":
            mc_mult = MONTH_CHANGE_FALSE_MULTIPLIER
            priority_score *= mc_mult

        rows.append({
            "file":               str(rel),
            "section":            section,
            "last_modified":      last_modified.isoformat(),
            "days_stale":         days_stale,
            "incoming_links":     incoming,
            "stale_patterns":     "; ".join(stale_hits),
            "month_change":       month_change,
            "edition":            edition,
            # partial weighted contributions — these three sum to raw_score
            "score_staleness":    round(s_contrib, 4),
            "score_links":        round(l_contrib, 4),
            "score_patterns":     round(p_contrib, 4),
            "raw_score":          round(raw_score, 4),
            "section_multiplier": section_mult,
            "mc_multiplier":      mc_mult,
            "priority_score":     round(priority_score, 4),
        })

    rows.sort(key=lambda r: r["priority_score"], reverse=True)
    return rows


# ── CLI + Main ────────────────────────────────────────────────────────────────

def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Prioritize documentation pages for review.",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog=__doc__,
    )
    parser.add_argument(
        "--batch", type=int, default=BATCH_SIZE,
        help=f"Top N files to display in the terminal (default: {BATCH_SIZE})",
    )
    parser.add_argument(
        "--output", default="tools/doc_audit/review_queue.csv",
        help="CSV output path, relative to repo root (default: tools/doc_audit/review_queue.csv)",
    )
    parser.add_argument(
        "--section",
        help="Restrict output to one top-level section, e.g. 'api' or 'getting_started'",
    )
    return parser.parse_args()


def main() -> None:
    args = parse_args()

    print("Documentation Review Audit")
    print("=" * 60)

    repo_root = find_repo_root()
    docs_dir  = repo_root / "docs"
    print(f"Repository root : {repo_root}")
    print(f"Docs directory  : {docs_dir}")
    print()

    print("Collecting files …")
    md_files = collect_markdown_files(docs_dir)
    print(f"  Found {len(md_files)} markdown files (after skipping: {', '.join(SKIP_DIRS)})")
    print()

    print("Gathering staleness data …")
    ignored_revs = load_ignored_revs(repo_root)
    if ignored_revs:
        print(f"  Loaded {len(ignored_revs)} ignored revision(s) from {BLAME_IGNORE_REVS_FILE}")
    staleness_map = build_staleness_map(repo_root, md_files, ignored_revs)
    print(f"  Dated {len(staleness_map)} files via git history")
    print()

    print("Building link graph …")
    link_graph = build_link_graph(md_files, docs_dir)
    print()

    print("Scoring files …")
    rows = score_files(md_files, staleness_map, link_graph, docs_dir)
    print(f"  Scored {len(rows)} files")
    print()

    if args.section:
        rows = [r for r in rows if r["section"] == args.section]
        print(f"  Filtered to section '{args.section}': {len(rows)} files")
        print()

    # ── Write CSV ──────────────────────────────────────────────────────────────
    output_path = repo_root / args.output
    output_path.parent.mkdir(parents=True, exist_ok=True)
    fieldnames = [
        "file", "section", "last_modified", "days_stale",
        "incoming_links", "stale_patterns", "month_change", "edition",
        "score_staleness", "score_links", "score_patterns",
        "raw_score", "section_multiplier", "mc_multiplier", "priority_score",
    ]
    with output_path.open("w", newline="", encoding="utf-8") as fh:
        writer = csv.DictWriter(fh, fieldnames=fieldnames)
        writer.writeheader()
        writer.writerows(rows)

    # ── Section average score summary ─────────────────────────────────────────
    # Build stats from the unfiltered rows in the CSV (section filter may have
    # narrowed `rows`, so read back from file which always contains all files).
    from collections import defaultdict
    all_rows_for_sections: list[dict] = []
    with output_path.open(encoding="utf-8") as fh:
        all_rows_for_sections = list(csv.DictReader(fh))

    sec_scores: dict[str, list[float]] = defaultdict(list)
    sec_raw:    dict[str, list[float]] = defaultdict(list)
    sec_oldest: dict[str, str]         = {}
    sec_stale:  dict[str, int]         = defaultdict(int)

    for row in all_rows_for_sections:
        sec = row["section"]
        sec_scores[sec].append(float(row["priority_score"]))
        sec_raw[sec].append(float(row["raw_score"]))
        if row["stale_patterns"]:
            sec_stale[sec] += 1
        if row["last_modified"] < sec_oldest.get(sec, "9999"):
            sec_oldest[sec] = row["last_modified"]

    section_summary = sorted(
        [
            {
                "section":    sec,
                "avg_score":  sum(sec_scores[sec]) / len(sec_scores[sec]),
                "avg_raw":    sum(sec_raw[sec]) / len(sec_raw[sec]),
                "multiplier": SECTION_WEIGHTS.get(sec, 1.0),
                "files":      len(sec_scores[sec]),
                "stale_pct":  round(100 * sec_stale[sec] / len(sec_scores[sec])),
                "oldest":     sec_oldest.get(sec, "?"),
            }
            for sec in sec_scores
        ],
        key=lambda r: r["avg_score"],
        reverse=True,
    )

    sec_sep = "-" * 85
    print("Section averages (all sections, sorted by avg priority score):")
    print(sec_sep)
    print(f"{'section':<30}  {'avg':>6}  {'raw':>6}  {'×sect':>5}  "
          f"{'files':>5}  {'stale%':>6}  {'oldest':<12}")
    print(sec_sep)
    for r in section_summary:
        print(
            f"{r['section']:<30}  "
            f"{r['avg_score']:>6.4f}  "
            f"{r['avg_raw']:>6.4f}  "
            f"{r['multiplier']:>5.1f}  "
            f"{r['files']:>5}  "
            f"{r['stale_pct']:>5}%  "
            f"{r['oldest']:<12}"
        )
    print(sec_sep)
    print()

    # ── Per-file table ─────────────────────────────────────────────────────────
    batch = min(args.batch, len(rows))
    w = WEIGHT_STALENESS
    wl = WEIGHT_LINKS
    wp = WEIGHT_PATTERNS
    print(f"Top {batch} pages to review next:")
    print(f"  Score breakdown: [staleness×{w}] [links×{wl}] [patterns×{wp}]  →  raw ×sect ×mc = final  |  lnk = raw link count")
    sep = "-" * 135
    print(sep)
    hdr = (f"{'#':<4} {'section':<25}  {'file':<55}  "
           f"{'final':>6}  {'stale':>6}  {'links':>6}  {'patt':>6}  "
           f"{'raw':>6}  {'×sect':>5}  {'×mc':>4}  "
           f"{'lnk':>4}  {'last-mod':<12}")
    print(hdr)
    print(sep)
    for i, row in enumerate(rows[:batch], 1):
        mc_flag = f"{row['mc_multiplier']:.1f}" if row["mc_multiplier"] != 1.0 else "  —"
        # Truncate long paths so score columns stay aligned
        short_file = str(row['file'])
        if len(short_file) > 55:
            short_file = short_file[:54] + "…"
        print(
            f"{i:<4} {row['section']:<25}  {short_file:<55}  "
            f"{row['priority_score']:>6.4f}  "
            f"{row['score_staleness']:>6.4f}  "
            f"{row['score_links']:>6.4f}  "
            f"{row['score_patterns']:>6.4f}  "
            f"{row['raw_score']:>6.4f}  "
            f"{row['section_multiplier']:>5.1f}  "
            f"{mc_flag:>4}  "
            f"{row['incoming_links']:>4}  "
            f"{row['last_modified']:<12}"
        )
    print(sep)
    print(f"\nFull review queue ({len(rows)} files) saved to: {output_path}")


if __name__ == "__main__":
    main()
