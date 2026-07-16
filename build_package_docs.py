"""
Build the Composer-package Markdown docs from the MkDocs build outputs.

The package bundles two documentation sets, each produced by its own MkDocs
build with the llmstxt plugin:

- ``developer/`` — ibexa/documentation-developer (this repository, built into
  ``site/``)
- ``user/`` — ibexa/documentation-user (checked out and built next to it, into
  ``user-docs/site/``)

Each set gets its own ``llms.txt`` table of contents at its root. The website
outputs keep absolute https://doc.ibexa.co URLs; the Composer package must work
offline inside vendor/ibexa/documentation-developer, so links are rewritten:

- Page links (``https://doc.ibexa.co/en/latest/<path>/[#anchor]`` for the
  developer docs, ``https://doc.ibexa.co/projects/userguide/en/latest/…`` for
  the user docs) become relative links to the corresponding
  ``<set>/<path>/index.md`` file — including cross-set links between the two
  documentations. URLs matching a mkdocs-redirects entry are resolved through
  the redirect first. URLs with no local page (other doc.ibexa.co projects,
  images, the separately hosted API reference HTML) are left untouched.
- PHP API class links (``…/php_api_reference/classes/<Slug>.html``) become
  relative links to the class source file in the *installed project's*
  vendor/ directory, using the FQCN→path map produced by
  ``tools/llm_package/dump_class_paths.php``. The link text is upgraded to the
  backticked FQCN (when it was just the short class name) so the class stays
  greppable even if the target package isn't installed in the user's project.
  Unmapped classes keep their absolute URL.

Run after both ``mkdocs build``s:

    php tools/llm_package/dump_class_paths.php site user-docs/site class_paths.json
    python build_package_docs.py --version 5.0

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
from typing import NamedTuple

import yaml

# Number of path segments from the package root up to vendor/
# (vendor/ibexa/documentation-developer/ -> vendor/).
_PACKAGE_DEPTH_IN_VENDOR = 2

# [text](url) or ![alt](url); group 1 distinguishes images. URLs never contain
# whitespace or parentheses in the generated Markdown.
_MD_LINK_RE = re.compile(r"(!?)\[([^\]]*)\]\(([^()\s]+)\)")

_API_CLASS_URL_RE = re.compile(r"php_api_reference/classes/([A-Za-z0-9-]+)\.html$")

# Same fence detection as llmstxt_preprocess.renumber_ordered_lists.
_FENCE_OPEN_RE = re.compile(r"^(\s*)(`{3,}|~{3,})")


class DocSet(NamedTuple):
    """One documentation set shipped in the package."""

    root: str  # top-level package directory, e.g. 'developer'
    base_urls: tuple  # URL prefixes owned by this set, e.g. ('https://doc.ibexa.co/en/latest/',)
    pages: frozenset  # page paths relative to the set root, e.g. 'search/search/index.md'
    redirects: dict  # URL path -> URL path, from mkdocs-redirects


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


def _page_file(url_path, pages, redirects):
    """Map a site-relative URL path to its Markdown file, or None.

    ``url_path`` is the part after the set's base URL without the anchor. Only
    page URLs (directory URLs or explicit .md paths) are considered; anything
    else (images, API reference HTML, files) returns None.
    """
    if url_path.endswith(".md"):
        candidate = url_path
    elif url_path == "" or url_path.endswith("/"):
        candidate = url_path + "index.md"
    else:
        return None

    if candidate in pages:
        return candidate

    redirect_target = redirects.get(url_path)
    if redirect_target is not None:
        candidate = redirect_target + "index.md"
        if candidate in pages:
            return candidate
    return None


def _split_anchor(url):
    if "#" in url:
        base, anchor = url.split("#", 1)
        return base, "#" + anchor
    return url, ""


def _rewrite_api_link(text, url, anchor, page_path, class_paths):
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
    # vendor/ibexa/documentation-developer/<page_path>.
    ups = len(PurePosixPath(page_path).parent.parts) + _PACKAGE_DEPTH_IN_VENDOR
    # HTML anchors (#method_…) have no equivalent in the source file; drop them.
    return f"[{text}]({'../' * ups}{vendor_path})"


def rewrite_links(line, page_path, docsets, class_paths):
    """Rewrite all links on one (non-code) Markdown line.

    ``page_path`` is the page's package-relative path (e.g.
    'developer/search/search/index.md'). ``docsets`` are all sets in the
    package — links to any of their base URLs are localized, so cross-set
    links (developer docs → user docs and back) become relative too. Links to
    other doc versions or other doc.ibexa.co projects stay absolute.
    """

    def _replace(match):
        bang, text, url = match.groups()
        if bang:
            return match.group(0)

        bare_url, anchor = _split_anchor(url)
        owner = next(
            (
                (docset, base)
                for docset in docsets
                for base in docset.base_urls
                if bare_url.startswith(base)
            ),
            None,
        )
        if owner is None:
            return match.group(0)
        docset, base = owner

        if _API_CLASS_URL_RE.search(bare_url):
            return _rewrite_api_link(text, bare_url, anchor, page_path, class_paths)

        target = _page_file(bare_url[len(base):], docset.pages, docset.redirects)
        if target is None:
            return match.group(0)
        relative = posixpath.relpath(f"{docset.root}/{target}", posixpath.dirname(page_path))
        return f"[{text}]({relative}{anchor})"

    return _MD_LINK_RE.sub(_replace, line)


def rewrite_page(content, page_path, docsets, class_paths):
    """Rewrite a page's links, leaving fenced code blocks untouched."""
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

        result.append(rewrite_links(line, page_path, docsets, class_paths))

    return "\n".join(result)


def rewrite_llms_txt(content, docset):
    """Point a set's llms.txt links at its packaged pages.

    llms.txt sits at the set's root, so targets are simply the page paths
    relative to that root.
    """

    def _replace(match):
        bang, text, url = match.groups()
        if bang:
            return match.group(0)
        bare_url, anchor = _split_anchor(url)
        for base in docset.base_urls:
            if bare_url.startswith(base):
                target = _page_file(bare_url[len(base):], docset.pages, docset.redirects)
                if target is not None:
                    return f"[{text}]({target}{anchor})"
                break
        return match.group(0)

    return _MD_LINK_RE.sub(_replace, content)


def check_relative_doc_links(pages):
    """Verify every relative .md link in the rewritten pages resolves.

    ``pages`` maps package-relative page paths -> content. Returns a list of
    error strings. Vendor class links (.php) can't be checked against the docs
    tree and are skipped.
    """
    errors = []
    for page_path, content in pages.items():
        for match in _MD_LINK_RE.finditer(content):
            url, _ = _split_anchor(match.group(3))
            if "://" in url or url.startswith("#") or not url.endswith(".md"):
                continue
            resolved = posixpath.normpath(posixpath.join(posixpath.dirname(page_path), url))
            if resolved.startswith("..") or resolved not in pages:
                errors.append(f"{page_path}: broken relative link {match.group(3)}")
    return errors


def _version_bases(url_prefix, version):
    """Base URLs owned by a doc set: en/latest plus the branch's own version."""
    bases = [f"{url_prefix}en/latest/"]
    if version:
        bases.append(f"{url_prefix}en/{version}/")
    return tuple(bases)


def _load_docset(root, site_dir, plugins_path, base_urls):
    site = Path(site_dir)
    if not site.is_dir():
        sys.exit(f"Site directory not found: {site_dir} (run mkdocs build first)")
    pages = frozenset(path.relative_to(site).as_posix() for path in site.rglob("*.md"))
    return DocSet(root, base_urls, pages, load_redirect_maps(plugins_path)), site


def build(dev_site, dev_plugins, user_site, user_plugins, class_map_path, version=None):
    developer, dev_dir = _load_docset(
        "developer", dev_site, dev_plugins, _version_bases("https://doc.ibexa.co/", version)
    )
    user, user_dir = _load_docset(
        "user",
        user_site,
        user_plugins,
        _version_bases("https://doc.ibexa.co/projects/userguide/", version),
    )
    docsets = ((developer, dev_dir), (user, user_dir))
    class_paths = json.loads(Path(class_map_path).read_text(encoding="utf-8"))

    rewritten = {}
    llms = {}
    for docset, site in docsets:
        for page_rel in sorted(docset.pages):
            page_path = f"{docset.root}/{page_rel}"
            rewritten[page_path] = rewrite_page(
                (site / page_rel).read_text(encoding="utf-8"),
                page_path,
                (developer, user),
                class_paths,
            )
        llms[docset.root] = rewrite_llms_txt(
            (site / "llms.txt").read_text(encoding="utf-8"), docset
        )

    errors = check_relative_doc_links(rewritten)
    if errors:
        for error in errors:
            print(error, file=sys.stderr)
        sys.exit(f"{len(errors)} broken relative links, not writing output")

    for docset, _ in docsets:
        out = Path(docset.root)
        if out.exists():
            shutil.rmtree(out)
        out.mkdir()
        (out / "llms.txt").write_text(llms[docset.root], encoding="utf-8")

    for page_path, content in rewritten.items():
        target = Path(page_path)
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_text(content, encoding="utf-8")

    all_bases = developer.base_urls + user.base_urls
    remaining = sum(content.count(base) for content in rewritten.values() for base in all_bases)
    print(f"Wrote {len(rewritten)} pages to developer/ and user/ (each with its llms.txt)")
    print(f"{remaining} links intentionally left absolute (no local page)")


def main():
    parser = argparse.ArgumentParser(description=__doc__.split("\n", 2)[1])
    parser.add_argument("--site", default="site", help="Developer docs MkDocs build output")
    parser.add_argument("--plugins", default="plugins.yml",
                        help="Developer docs plugins.yml with redirect_maps")
    parser.add_argument("--user-site", default="user-docs/site",
                        help="User docs MkDocs build output")
    parser.add_argument("--user-plugins", default="user-docs/plugins.yml",
                        help="User docs plugins.yml with redirect_maps")
    parser.add_argument("--class-map", default="class_paths.json",
                        help="FQCN→vendor path map from dump_class_paths.php")
    parser.add_argument("--version", default=None,
                        help="This branch's documentation version (e.g. 5.0): links pinned to "
                             "it (en/5.0/…) are rewritten like en/latest ones")
    args = parser.parse_args()
    build(args.site, args.plugins, args.user_site, args.user_plugins, args.class_map, args.version)


if __name__ == "__main__":
    main()
