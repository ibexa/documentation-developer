"""
Build the Composer-package Markdown docs from the MkDocs build output.

The website output (site/) keeps absolute https://doc.ibexa.co URLs; the
Composer package must work offline inside vendor/ibexa/documentation-developer,
so this script copies every generated Markdown page into doc/ (plus llms.txt to
the repo root) while rewriting links:

- Internal page links (``https://doc.ibexa.co/en/latest/<path>/[#anchor]``)
  become relative links to the corresponding ``doc/<path>/index.md`` file.
  URLs matching a mkdocs-redirects entry are resolved through the redirect
  first. URLs with no local page (other doc.ibexa.co projects, images, the
  separately hosted API reference HTML) are left untouched.
- PHP API class links (``…/php_api_reference/classes/<Slug>.html``) become
  relative links to the class source file in the *installed project's*
  vendor/ directory, using the FQCN→path map produced by
  ``tools/llm_package/dump_class_paths.php``. The link text is upgraded to the
  backticked FQCN (when it was just the short class name) so the class stays
  greppable even if the target package isn't installed in the user's project.
  Unmapped classes keep their absolute URL.

Run after ``mkdocs build``:

    php tools/llm_package/dump_class_paths.php site class_paths.json
    python build_package_docs.py

Like llmstxt_preprocess.py, all transformations are pure functions so they can
be unit-tested (tests/python/test_build_package_docs.py).
"""

import argparse
import json
import posixpath
import re
import shutil
import sys
from pathlib import Path, PurePosixPath

import yaml

BASE_URL = "https://doc.ibexa.co/en/latest/"

# Number of path segments from the package root up to vendor/
# (vendor/ibexa/documentation-developer/ -> vendor/).
_PACKAGE_DEPTH_IN_VENDOR = 2

# [text](url) or ![alt](url); group 1 distinguishes images. URLs never contain
# whitespace or parentheses in the generated Markdown.
_MD_LINK_RE = re.compile(r"(!?)\[([^\]]*)\]\(([^()\s]+)\)")

_API_CLASS_URL_RE = re.compile(r"php_api_reference/classes/([A-Za-z0-9-]+)\.html$")

# Same fence detection as llmstxt_preprocess.renumber_ordered_lists.
_FENCE_OPEN_RE = re.compile(r"^(\s*)(`{3,}|~{3,})")


def load_redirect_maps(plugins_path):
    """Read mkdocs-redirects ``redirect_maps`` from plugins.yml as URL paths.

    Entries map docs-relative source files to target files
    ('guide/images.md' -> 'content_management/images/images.md'); with
    use_directory_urls both sides publish as directory URLs, so the returned
    dict maps 'guide/images/' -> 'content_management/images/images/'.
    """
    with open(plugins_path, encoding="utf-8") as f:
        data = yaml.safe_load(f)

    for plugin in data.get("plugins", []):
        if isinstance(plugin, dict) and "redirects" in plugin:
            redirect_maps = (plugin["redirects"] or {}).get("redirect_maps") or {}
            return {
                _md_to_url_path(src): _md_to_url_path(target)
                for src, target in redirect_maps.items()
            }
    return {}


def _md_to_url_path(md_path):
    """'guide/images.md' -> 'guide/images/' (mkdocs directory URL)."""
    path = md_path[: -len(".md")] if md_path.endswith(".md") else md_path
    if path.endswith("/index"):
        path = path[: -len("index")]
    return path.rstrip("/") + "/" if path else ""


def _page_file(url_path, existing_pages, redirects):
    """Map a site-relative URL path to its Markdown file, or None.

    ``url_path`` is the part after BASE_URL without the anchor. Only page URLs
    (directory URLs or explicit .md paths) are considered; anything else
    (images, API reference HTML, files) returns None.
    """
    if url_path.endswith(".md"):
        candidate = url_path
    elif url_path == "" or url_path.endswith("/"):
        candidate = url_path + "index.md"
    else:
        return None

    if candidate in existing_pages:
        return candidate

    redirect_target = redirects.get(url_path)
    if redirect_target is not None:
        candidate = redirect_target + "index.md"
        if candidate in existing_pages:
            return candidate
    return None


def _split_anchor(url):
    if "#" in url:
        base, anchor = url.split("#", 1)
        return base, "#" + anchor
    return url, ""


def _rewrite_api_link(text, url, anchor, page_rel, class_paths):
    """Rewrite one PHP API class link; returns the full markdown link."""
    slug = _API_CLASS_URL_RE.search(url).group(1)
    fqcn = slug.replace("-", "\\")
    short_name = fqcn.rsplit("\\", 1)[-1]

    # Upgrade bare class-name link text to the greppable FQCN; keep richer
    # texts (e.g. `publishVersion()`) as authored.
    if text.strip("`").strip() in (short_name, fqcn):
        text = f"`{fqcn}`"

    vendor_path = class_paths.get(fqcn)
    if vendor_path is None:
        return f"[{text}]({url}{anchor})"

    # Steps up from the page's directory to vendor/: the page lives at
    # vendor/ibexa/documentation-developer/doc/<page_rel>.
    ups = len(PurePosixPath("doc", page_rel).parent.parts) + _PACKAGE_DEPTH_IN_VENDOR
    # HTML anchors (#method_…) have no equivalent in the source file; drop them.
    return f"[{text}]({'../' * ups}{vendor_path})"


def rewrite_links(line, page_rel, existing_pages, redirects, class_paths, base_urls=(BASE_URL,)):
    """Rewrite all links on one (non-code) Markdown line.

    ``base_urls`` are the URL prefixes considered "this documentation" —
    en/latest, plus the branch's own version (release notes hardcode
    version-pinned URLs like en/5.0). Links to other versions stay absolute.
    """

    def _replace(match):
        bang, text, url = match.groups()
        if bang:
            return match.group(0)

        bare_url, anchor = _split_anchor(url)
        base = next((b for b in base_urls if bare_url.startswith(b)), None)
        if base is not None:
            if _API_CLASS_URL_RE.search(bare_url):
                return _rewrite_api_link(text, bare_url, anchor, page_rel, class_paths)

            target = _page_file(bare_url[len(base):], existing_pages, redirects)
            if target is not None:
                relative = posixpath.relpath(target, posixpath.dirname(page_rel) or ".")
                return f"[{text}]({relative}{anchor})"

        return match.group(0)

    return _MD_LINK_RE.sub(_replace, line)


def rewrite_page(content, page_rel, existing_pages, redirects, class_paths, base_urls=(BASE_URL,)):
    """Rewrite a page's links, leaving fenced code blocks untouched.

    ``page_rel`` is the page's path relative to doc/ (e.g. 'search/index.md').
    """
    lines = content.split("\n")
    result = []
    fence = None  # (fence_char, fence_length) while inside a fenced code block

    for line in lines:
        if fence is not None:
            stripped = line.strip()
            if stripped and set(stripped) == {fence[0]} and len(stripped) >= fence[1]:
                fence = None
            result.append(line)
            continue

        fence_match = _FENCE_OPEN_RE.match(line)
        if fence_match:
            marker = fence_match.group(2)
            fence = (marker[0], len(marker))
            result.append(line)
            continue

        result.append(
            rewrite_links(line, page_rel, existing_pages, redirects, class_paths, base_urls)
        )

    return "\n".join(result)


def rewrite_llms_txt(content, existing_pages):
    """Point llms.txt links at the packaged doc/ files (llms.txt sits at the package root)."""

    def _replace(match):
        bang, text, url = match.groups()
        if bang or not url.startswith(BASE_URL):
            return match.group(0)
        candidate = url[len(BASE_URL):]
        if candidate in existing_pages:
            return f"[{text}](doc/{candidate})"
        return match.group(0)

    return _MD_LINK_RE.sub(_replace, content)


def check_relative_doc_links(pages):
    """Verify every relative .md link in the rewritten pages resolves.

    ``pages`` maps page_rel -> content. Returns a list of error strings.
    Vendor class links (.php) can't be checked against the docs tree and are
    skipped.
    """
    errors = []
    for page_rel, content in pages.items():
        for match in _MD_LINK_RE.finditer(content):
            url, _ = _split_anchor(match.group(3))
            if "://" in url or url.startswith("#") or not url.endswith(".md"):
                continue
            resolved = posixpath.normpath(posixpath.join(posixpath.dirname(page_rel), url))
            if resolved.startswith("..") or resolved not in pages:
                errors.append(f"{page_rel}: broken relative link {match.group(3)}")
    return errors


def build(site_dir, out_dir, llms_out, plugins_path, class_map_path, version=None):
    site = Path(site_dir)
    if not site.is_dir():
        sys.exit(f"Site directory not found: {site_dir} (run mkdocs build first)")

    base_urls = [BASE_URL]
    if version:
        base_urls.append(f"https://doc.ibexa.co/en/{version}/")

    redirects = load_redirect_maps(plugins_path)
    class_paths = json.loads(Path(class_map_path).read_text(encoding="utf-8"))

    source_pages = {
        path.relative_to(site).as_posix(): path
        for path in sorted(site.rglob("*.md"))
    }
    existing_pages = set(source_pages)

    rewritten = {
        page_rel: rewrite_page(
            path.read_text(encoding="utf-8"),
            page_rel,
            existing_pages,
            redirects,
            class_paths,
            base_urls,
        )
        for page_rel, path in source_pages.items()
    }

    errors = check_relative_doc_links(rewritten)

    llms_source = site / "llms.txt"
    llms_content = rewrite_llms_txt(llms_source.read_text(encoding="utf-8"), existing_pages)

    if errors:
        for error in errors:
            print(error, file=sys.stderr)
        sys.exit(f"{len(errors)} broken relative links, not writing output")

    out = Path(out_dir)
    if out.exists():
        shutil.rmtree(out)
    for page_rel, content in rewritten.items():
        target = out / page_rel
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_text(content, encoding="utf-8")
    Path(llms_out).write_text(llms_content, encoding="utf-8")

    remaining = sum(
        content.count(base) for content in rewritten.values() for base in base_urls
    )
    print(f"Wrote {len(rewritten)} pages to {out_dir}/ and {llms_out}")
    print(f"{remaining} links intentionally left absolute (no local page)")


def main():
    parser = argparse.ArgumentParser(description=__doc__.split("\n", 2)[1])
    parser.add_argument("--site", default="site", help="MkDocs build output directory")
    parser.add_argument("--out", default="doc", help="Package docs output directory")
    parser.add_argument("--llms", default="llms.txt", help="Package llms.txt output path")
    parser.add_argument("--plugins", default="plugins.yml", help="plugins.yml with redirect_maps")
    parser.add_argument("--class-map", default="class_paths.json",
                        help="FQCN→vendor path map from dump_class_paths.php")
    parser.add_argument("--version", default=None,
                        help="This branch's documentation version (e.g. 5.0): links pinned to "
                             "it (en/5.0/…) are rewritten like en/latest ones")
    args = parser.parse_args()
    build(args.site, args.out, args.llms, args.plugins, args.class_map, args.version)


if __name__ == "__main__":
    main()
