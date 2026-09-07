"""Conversion invariants for the Cohesivo SaaS conversion.

TEMPORARY. This module and its baseline (``invariants-baseline.yaml``) exist
only to track the SaaS conversion and are deleted by conversion ticket 20.

Four end-state invariants are asserted against the whole documentation tree:

1. ``edition_frontmatter``      no page carries ``edition:``/``editions:`` frontmatter
2. ``deleted_product_variables``no page references a product-name variable slated for deletion
3. ``php_code_sample``          no page contains a PHP code sample
4. ``stale_delete_marker``      no page carries the internal ``delete: true`` marker

Pages that violate an invariant today are recorded in ``invariants-baseline.yaml``
so the suite is green on landing. Each conversion ticket proves what it removed
by shrinking that file.

Regenerate the baseline with:

    PYTHONPATH=tools python -m pytest tests/python/test_conversion_invariants.py \\
        --update-invariant-baseline
"""

import re
import warnings
from pathlib import Path

import pytest
import yaml

BASELINE_PATH = Path(__file__).resolve().parent / "invariants-baseline.yaml"

BASELINE_HEADER = """\
# Accepted violations of the SaaS conversion invariants asserted by
# tests/python/test_conversion_invariants.py.
#
# Auto-generated. Do not edit by hand except to DELETE entries a conversion
# ticket has just fixed. Regenerate with:
#
#   PYTHONPATH=tools python -m pytest \\
#       tests/python/test_conversion_invariants.py --update-invariant-baseline
#
# Entries are docs/-relative page paths, sorted. Removing an entry while its
# violation persists fails the test; a new violation on a page that is not
# listed fails the test naming that page. An entry whose violation is gone
# (usually because the page was deleted) is reported as a warning, not a
# failure, so that conversion tickets landing in parallel do not turn this
# file into a merge-conflict magnet.
#
# TEMPORARY. This file and the test that reads it exist only for the Cohesivo
# SaaS conversion and are deleted by conversion ticket 20, which requires every
# list below to be empty.
"""

# --- Invariant 1: edition frontmatter -------------------------------------
# Both the singular and the plural key: only `edition:` occurs today, but
# tools/llms_txt/llmstxt_preprocess.py::editions_from_frontmatter merges both
# and theme/main.html tests both, so a re-introduction of the plural form must
# fail as well.
EDITION_KEYS = ("edition", "editions")

# --- Invariant 2: product-name variables slated for deletion ---------------
DELETED_PRODUCT_VARS = (
    "product_name_headless",
    "product_name_exp",
    "product_name_com",
    "product_name_cloud",
    "product_name_content",
    "product_name_oss",
)
# mkdocs-macros variable delimiters are `[[=` / `=]]` (see plugins.yml). The
# whitespace tolerance mirrors main.py::resolve_variables. Anchoring on the
# closing delimiter keeps `product_name` and `product_name_base` out.
DELETED_PRODUCT_VAR_RE = re.compile(
    r"\[\[=\s*(?:" + "|".join(DELETED_PRODUCT_VARS) + r")\s*=\]\]"
)
# Belt and braces: the same identifiers used in a block or comment tag, e.g.
# `[[% if product_name_exp %]]`. Zero occurrences today.
DELETED_PRODUCT_VAR_TAG_RE = re.compile(
    r"\[\[[%#][^\]]*?\b(?:" + "|".join(DELETED_PRODUCT_VARS) + r")\b"
)

# --- Invariant 3: PHP code samples ----------------------------------------
# House style opens PHP fences as "``` php" -- with a space -- optionally
# followed by attributes (`hl_lines="4"`, `{skip-validation}`). There is not a
# single literal "```php" in docs/, so a fence regex without the `[ \t]*` below
# reports zero violations and looks like the invariant already holds.
# The trailing `(?:[ \t]|$)` is what keeps `phpt`-style languages out.
PHP_FENCE_RE = re.compile(
    r"^[ \t]*(?:`{3,}|~{3,})[ \t]*php(?:[ \t]|$)", re.MULTILINE
)
# A PHP file pulled in from code_samples/ instead of being inlined. Every page
# using this today also carries a PHP fence, but keep the signal: it catches a
# page that switches to a `text`-fenced or unfenced include.
PHP_INCLUDE_RE = re.compile(r"include_(?:file|code)\(\s*['\"][^'\"]*\.php['\"]")

# --- Invariant 4: stale internal deletion marker --------------------------
DELETE_MARKER_KEY = "delete"

FRONTMATTER_RE = re.compile(r"\A---[ \t]*\r?\n(.*?)\r?\n(?:---|\.\.\.)[ \t]*\r?\n", re.DOTALL)
FRONTMATTER_KEY_RE = re.compile(r"^([A-Za-z_][\w-]*)[ \t]*:", re.MULTILINE)

INVARIANTS = (
    "edition_frontmatter",
    "deleted_product_variables",
    "php_code_sample",
    "stale_delete_marker",
)

INVARIANT_DESCRIPTIONS = {
    "edition_frontmatter": "carry edition frontmatter (`edition:` or `editions:`)",
    "deleted_product_variables": (
        "reference a product-name variable slated for deletion "
        f"({', '.join(DELETED_PRODUCT_VARS)})"
    ),
    "php_code_sample": "contain a PHP code sample (fenced block or .php include macro)",
    "stale_delete_marker": "carry the stale internal `delete:` marker",
}


class StaleBaselineWarning(UserWarning):
    """A baseline entry whose violation no longer exists."""


def frontmatter_keys(text):
    """Return the set of top-level frontmatter keys of a page.

    Frontmatter is parsed rather than grepped so that a `delete:` or
    `edition:` line inside a fenced YAML sample is not mistaken for one.
    """
    match = FRONTMATTER_RE.match(text)
    if not match:
        return set()
    block = match.group(1)
    try:
        data = yaml.safe_load(block)
    except yaml.YAMLError:
        # Fall back to the literal key lines rather than silently reporting no
        # keys at all for a page whose frontmatter PyYAML cannot read.
        return set(FRONTMATTER_KEY_RE.findall(block))
    if not isinstance(data, dict):
        return set()
    return {str(key) for key in data}


def page_violations(text):
    """Return the invariants that the given page content violates."""
    keys = frontmatter_keys(text)
    violated = set()
    if keys.intersection(EDITION_KEYS):
        violated.add("edition_frontmatter")
    if DELETED_PRODUCT_VAR_RE.search(text) or DELETED_PRODUCT_VAR_TAG_RE.search(text):
        violated.add("deleted_product_variables")
    if PHP_FENCE_RE.search(text) or PHP_INCLUDE_RE.search(text):
        violated.add("php_code_sample")
    if DELETE_MARKER_KEY in keys:
        violated.add("stale_delete_marker")
    return violated


def scan_docs(docs_dir):
    """Map each invariant name to the sorted docs/-relative pages violating it."""
    found = {name: set() for name in INVARIANTS}
    for path in docs_dir.rglob("*.md"):
        text = path.read_text(encoding="utf-8")
        relative = path.relative_to(docs_dir).as_posix()
        for name in page_violations(text):
            found[name].add(relative)
    return found


def load_baseline(path=BASELINE_PATH):
    """Read the baseline. A missing file means an empty baseline."""
    if not path.exists():
        return {name: set() for name in INVARIANTS}
    data = yaml.safe_load(path.read_text(encoding="utf-8")) or {}
    return {name: set(data.get(name) or []) for name in INVARIANTS}


def render_baseline(violations):
    lines = [BASELINE_HEADER]
    for name in INVARIANTS:
        pages = sorted(violations[name])
        lines.append("")
        lines.append(f"# {len(pages)} page(s) {INVARIANT_DESCRIPTIONS[name]}.")
        if not pages:
            lines.append(f"{name}: []")
            continue
        lines.append(f"{name}:")
        lines.extend(f"  - {page}" for page in pages)
    return "\n".join(lines) + "\n"


def write_baseline(violations, path=BASELINE_PATH):
    path.write_text(render_baseline(violations), encoding="utf-8")


@pytest.fixture(scope="session")
def violations(docs_dir):
    assert docs_dir.is_dir(), f"documentation tree not found at {docs_dir}"
    return scan_docs(docs_dir)


@pytest.fixture(scope="session")
def baseline(violations, pytestconfig):
    if pytestconfig.getoption("--update-invariant-baseline"):
        write_baseline(violations)
        print(f"\nBaseline written to {BASELINE_PATH}")
        for name in INVARIANTS:
            print(f"  {name}: {len(violations[name])} entries")
    return load_baseline()


def assert_invariant(name, violations, baseline):
    """Fail if a page violates `name` without being accepted in the baseline."""
    unaccepted = sorted(violations[name] - baseline[name])
    assert not unaccepted, (
        f"{len(unaccepted)} page(s) newly {INVARIANT_DESCRIPTIONS[name]} "
        f"and are not accepted in {BASELINE_PATH.name} "
        f"under `{name}`:\n"
        + "\n".join(f"  - {page}" for page in unaccepted)
        + "\n\nFix the page, or -- only if the violation is expected to stay for "
        "now -- regenerate the baseline with "
        "`pytest tests/python/test_conversion_invariants.py "
        "--update-invariant-baseline`."
    )


def test_no_edition_frontmatter(violations, baseline):
    assert_invariant("edition_frontmatter", violations, baseline)


def test_no_deleted_product_variables(violations, baseline):
    assert_invariant("deleted_product_variables", violations, baseline)


def test_no_php_code_samples(violations, baseline):
    assert_invariant("php_code_sample", violations, baseline)


def test_no_stale_delete_markers(violations, baseline):
    assert_invariant("stale_delete_marker", violations, baseline)


def test_stale_baseline_entries_are_reported(violations, baseline):
    """Report -- but do not fail on -- baseline entries that are now obsolete.

    A stale entry means the violation is gone, usually because the page was
    deleted: progress, not a regression. Conversion tickets land in parallel,
    so failing here would make the baseline a merge-conflict magnet. Ticket 20
    removes this module once every list in the baseline is empty.
    """
    stale = {
        name: sorted(baseline[name] - violations[name])
        for name in INVARIANTS
        if baseline[name] - violations[name]
    }
    if stale:
        report = "\n".join(
            f"  {name}:\n" + "\n".join(f"    - {page}" for page in pages)
            for name, pages in stale.items()
        )
        warnings.warn(
            f"{sum(len(p) for p in stale.values())} baseline entry/entries in "
            f"{BASELINE_PATH.name} no longer violate their invariant and can be "
            f"removed:\n{report}",
            StaleBaselineWarning,
            stacklevel=2,
        )
