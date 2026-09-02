"""
Markdown conversion logic for the llmstxt plugin.

This module is the single place holding all content transformations used to
produce the Markdown version of the documentation:

- ``preprocess(soup, output)`` — HTML-level transforms invoked by the
  mkdocs-llmstxt plugin (configured in ``plugins.yml``) before the HTML is
  converted to Markdown.
- Markdown post-processing helpers (``renumber_ordered_lists``,
  ``inject_edition_badges``, ``editions_from_frontmatter``) applied by
  ``hooks.py`` to the Markdown the plugin generated.

This package (``llms_txt``) is installed as a dependency by other Ibexa doc
sites, which each keep a thin root-level ``llmstxt_preprocess.py`` shim
(loaded by the mkdocs-llmstxt plugin via ``spec_from_file_location``, since
its ``preprocess:`` config option requires a real file path) that re-exports
``preprocess`` from here. Keep this module stateless (constants and pure
functions only).
"""

import html as html_module
import re
from urllib.parse import urljoin, urlparse

from bs4 import BeautifulSoup as Soup, NavigableString

PILL_CLASS_TO_EDITION = {
    "pill--lts-update": "LTS Update",
    "pill--experience": "Experience",
    "pill--headless": "Headless",
    "pill--new-feature": "New feature",
    "pill--first-release": "First release",
}

FRONTMATTER_EDITION_DISPLAY = {
    "lts-update": "LTS Update",
    "experience": "Experience",
    "headless": "Headless",
}


def preprocess(soup: Soup, output: str) -> None:
    """
    Preprocess HTML to improve markdown conversion.

    Runs with autoclean disabled so we can control the order:
    1. Expand tabbed sets with labels before autoclean removes tabbed-labels.
    2. Run autoclean-equivalent cleanup.
    3. Replace inline edition badge spans with readable text.
    4. Remove release notes filter UI.
    5. Convert card macros to markdown lists.

    Note: frontmatter edition injection is handled in hooks.py on_page_content,
    where page.file.src_path is available directly.
    """
    _process_tabbed_sets(soup)
    _autoclean(soup)
    _process_inline_pills(soup)
    _process_release_note_tags(soup)
    _process_release_note_dates(soup)
    _process_release_notes_filters(soup)
    _process_cards(soup)
    _process_info_tiles(soup)
    _process_tables(soup)
    _process_admonitions(soup)


# ---------------------------------------------------------------------------
# Tables
# ---------------------------------------------------------------------------

def _process_tables(soup: Soup) -> None:
    """Replace ✔ (U+2714) with 'Yes' in table cells for readability."""
    CHECK = "✔"
    for cell in soup.find_all(["td", "th"]):
        for text_node in cell.find_all(string=lambda s: CHECK in s):
            text_node.replace_with(NavigableString(text_node.replace(CHECK, "Yes")))


# ---------------------------------------------------------------------------
# Tabbed sets
# ---------------------------------------------------------------------------

def _process_tabbed_sets(soup: Soup) -> None:
    """Prepend each tab label as bold text before its content block."""
    for tabbed_set in soup.find_all("div", class_="tabbed-set"):
        labels_div = tabbed_set.find("div", class_="tabbed-labels")
        content_div = tabbed_set.find("div", class_="tabbed-content")

        if not labels_div or not content_div:
            tabbed_set.unwrap()
            continue

        labels = [label.get_text(strip=True) for label in labels_div.find_all("label")]
        blocks = content_div.find_all("div", class_="tabbed-block", recursive=False)

        wrapper = soup.new_tag("div")
        for i, block in enumerate(blocks):
            if i < len(labels):
                label_tag = soup.new_tag("p")
                strong = soup.new_tag("strong")
                strong.string = labels[i]
                label_tag.append(strong)
                wrapper.append(label_tag)
            for child in list(block.children):
                wrapper.append(child.extract())

        tabbed_set.replace_with(wrapper)


# ---------------------------------------------------------------------------
# Autoclean equivalent (mirrors mkdocs-llmstxt autoclean, minus tabbed-labels)
# ---------------------------------------------------------------------------

def _autoclean(soup: Soup) -> None:
    """Replicate the plugin's autoclean so we can run it after tab processing."""

    # Unwrap links that wrap an image (e.g. lightbox links) so the image
    # itself decides its fate below.
    for link in soup.find_all("a"):
        img = link.find("img")
        if img:
            link.replace_with(img.extract())

    # Keep images that have alt text so markdownify emits ![alt](src)
    # (URLs are made absolute later by absolutize_image_urls); drop the rest,
    # since an image without a description tells an AI agent nothing.
    # Done in its own pass: mutating the tree from inside a find_all() predicate
    # makes the traversal skip the elements that follow the mutated one.
    for img in soup.find_all("img"):
        alt = (img.get("alt") or "").strip()
        if not alt:
            img.decompose()

    def _should_remove(tag) -> bool:
        if tag.name == "svg":
            return True
        classes = tag.get("class") or ()
        if tag.name == "a" and "headerlink" in classes:
            return True
        if "twemoji" in classes:
            return True
        # tabbed-labels are already consumed by _process_tabbed_sets, but
        # handle any stragglers defensively.
        if "tabbed-labels" in classes:
            return True
        return False

    for element in soup.find_all(_should_remove):
        element.decompose()

    for element in soup.find_all("autoref"):
        element.replace_with(NavigableString(element.get_text()))

    # Insert ", " between adjacent <code> elements in table cells.
    # html.parser silently drops </br> (invalid void-closing tag), so adjacent
    # <code> blocks have no separator and markdownify concatenates their backticks.
    for td in soup.find_all(["td", "th"]):
        children = list(td.children)
        for i in range(len(children) - 1):
            curr = children[i]
            nxt = children[i + 1]
            if getattr(curr, "name", None) == "code" and getattr(nxt, "name", None) == "code":
                curr.insert_after(NavigableString(", "))

    for element in soup.find_all("div", attrs={"class": "doc-md-description"}):
        element.replace_with(NavigableString(element.get_text().strip()))

    for element in soup.find_all("span", attrs={"class": "doc-labels"}):
        element.decompose()

    # Flatten line-numbered code blocks to a plain <pre>, keeping the
    # language-* class (emitted thanks to pygments_lang_class) on the <pre>,
    # where markdownify's code_language_callback looks for it.
    for element in soup.find_all("table", attrs={"class": "highlighttable"}):
        code_elem = element.find("code")
        if code_elem:
            classes = code_elem.get("class") or ()
            language = next((c for c in classes if c.startswith("language-")), "")
            attr = f' class="{language}"' if language else ""
            element.replace_with(
                Soup(f"<pre{attr}>{html_module.escape(code_elem.get_text())}</pre>", "html.parser")
            )

# ---------------------------------------------------------------------------
# Inline edition badge spans (from snippet includes)
# ---------------------------------------------------------------------------

def _pill_edition(node) -> str:
    """Return the edition name of an inline pill span, or '' if not one."""
    if getattr(node, "name", None) != "span":
        return ""
    classes = node.get("class") or []
    if "pill--inline" not in classes:
        return ""
    for pill_cls, edition_name in PILL_CLASS_TO_EDITION.items():
        if pill_cls in classes:
            return edition_name
    return ""


def _process_inline_pills(soup: Soup) -> None:
    """Replace inline edition pill spans with readable text.

    Consecutive pills (possibly separated by whitespace) are merged into a
    single parenthetical, e.g. ' (Headless, Experience)' instead of
    ' (Headless) (Experience)'.
    """
    for span in soup.find_all("span", class_="pill--inline"):
        if span.parent is None:  # already consumed as part of a previous run
            continue
        edition = _pill_edition(span)
        if not edition:
            continue

        # Collect the run of pills that follow, skipping whitespace between them.
        editions = [edition]
        consumed = []
        node = span.next_sibling
        pending_whitespace = []
        while node is not None:
            if isinstance(node, NavigableString) and not node.strip():
                pending_whitespace.append(node)
                node = node.next_sibling
                continue
            next_edition = _pill_edition(node)
            if not next_edition:
                break
            editions.append(next_edition)
            consumed += pending_whitespace + [node]
            pending_whitespace = []
            node = node.next_sibling

        for extra_node in consumed:
            extra_node.extract()
        span.replace_with(soup.new_string(f" ({', '.join(editions)})"))


def _process_release_note_tags(soup: Soup) -> None:
    """Append edition labels from release-note__tags divs to their preceding heading.

    Release notes use a <div class="release-note__tags"> block after each <h2>
    containing empty <div class="pill pill--X"> elements rendered via CSS.
    This converts them to a readable parenthetical on the heading, e.g.:
      ## Google Gemini connector v5.0.7 (Headless, Experience, LTS Update, New feature)
    """
    for tags_div in soup.find_all("div", class_="release-note__tags"):
        editions = []
        for pill_div in tags_div.find_all("div"):
            classes = pill_div.get("class", [])
            for pill_cls, name in PILL_CLASS_TO_EDITION.items():
                if pill_cls in classes:
                    editions.append(name)
                    break

        heading = tags_div.find_previous_sibling(["h1", "h2", "h3", "h4"])
        if heading and editions:
            # Insert before the permalink anchor so it's part of the heading text
            anchor = heading.find("a", class_="headerlink")
            label = NavigableString(f" ({', '.join(editions)})")
            if anchor:
                anchor.insert_before(label)
            else:
                heading.append(label)

        tags_div.decompose()


def _process_release_note_dates(soup: Soup) -> None:
    """Prefix release-note dates with 'Release date: ' so the bare date line stays understandable."""
    for date_div in soup.find_all("div", class_="release-note__date"):
        date_text = date_div.get_text(strip=True)
        if date_text:
            date_div.string = f"Release date: {date_text}"


def _process_info_tiles(soup: Soup) -> None:
    """Simplify info-tile links to a single clean link text.

    Info tiles have a 'Details' label div and a separate content div.
    After SVG removal, markdownify produces broken multi-line link text.
    Replace the whole <a> content with just the meaningful text.
    """
    for tile in soup.find_all("a", class_="info-tile"):
        # The label div ("Details") can be discarded
        label = tile.find("div", class_="info-tile__details")
        if label:
            label.decompose()

        # Flatten remaining content to plain text
        text = tile.get_text(separator=" ", strip=True)
        tile.clear()
        tile.append(soup.new_string(text))


# ---------------------------------------------------------------------------
# Admonitions
# ---------------------------------------------------------------------------

def _process_admonitions(soup: Soup) -> None:
    """Convert admonition divs to blockquotes with a bold 'Type: Title' heading.

    Input:  <div class="admonition caution">
                <p class="admonition-title">Recommended versions</p>
                <p>Body text...</p>
            </div>

    Output: <blockquote>
                <p><strong>Caution: Recommended versions</strong></p>
                <p>Body text...</p>
            </blockquote>
    """
    for admonition in soup.find_all("div", class_="admonition"):
        classes = admonition.get("class", [])
        admonition_type = next((c for c in classes if c != "admonition"), None)

        title_elem = admonition.find("p", class_="admonition-title")
        title_text = title_elem.get_text(strip=True) if title_elem else ""

        blockquote = soup.new_tag("blockquote")

        # Bold title paragraph
        title_p = soup.new_tag("p")
        strong = soup.new_tag("strong")
        prefix = f"{admonition_type.capitalize()}: " if admonition_type else ""
        strong.string = f"{prefix}{title_text}"
        title_p.append(strong)
        blockquote.append(title_p)

        # Body: all children except the title
        for child in list(admonition.children):
            if child == title_elem:
                continue
            blockquote.append(child.extract())

        admonition.replace_with(blockquote)


def _process_release_notes_filters(soup: Soup) -> None:
    """Remove interactive release-notes filter UI elements."""
    for container in soup.find_all("div", class_="release-notes-filters"):
        container.decompose()


# ---------------------------------------------------------------------------
# Card macros
# ---------------------------------------------------------------------------

def _process_cards(soup: Soup) -> None:
    """Convert card macro HTML structures into markdown-friendly lists with links."""
    for cards_div in soup.find_all("div", class_=lambda c: c and c.startswith("cards ")):
        card_wrappers = cards_div.find_all("div", class_="card-wrapper")

        if not card_wrappers:
            continue

        ul = soup.new_tag("ul")

        for card_wrapper in card_wrappers:
            link = card_wrapper.find("a", class_="card")
            if not link:
                continue

            href = link.get("href", "")
            if href.startswith("//"):
                href = "https:" + href

            title_elem = link.find("p", class_="title")
            description_elem = link.find("p", class_="description")

            if not title_elem:
                continue

            title = title_elem.get_text(strip=True)
            description = description_elem.get_text(strip=True) if description_elem else ""

            li = soup.new_tag("li")
            link_tag = soup.new_tag("a", href=href)
            link_tag.string = title
            li.append(link_tag)

            if description:
                li.append(soup.new_string(": "))
                li.append(soup.new_string(description))

            ul.append(li)

        cards_div.replace_with(ul)


# ---------------------------------------------------------------------------
# Markdown post-processing (applied by hooks.py to the generated Markdown)
# ---------------------------------------------------------------------------

def editions_from_frontmatter(frontmatter: dict) -> list:
    """Map ``edition``/``editions`` frontmatter values to display names."""

    def _to_list(value):
        if isinstance(value, list):
            return value
        if isinstance(value, str):
            return value.split()
        return []

    all_editions = _to_list(frontmatter.get("edition")) + _to_list(frontmatter.get("editions") or [])
    return [FRONTMATTER_EDITION_DISPLAY.get(e, e) for e in all_editions if e]


_MACRO_RE = re.compile(r"\[\[=\s*(\w+)\s*=\]\]")


def expand_macros(text: str, variables: dict) -> str:
    """Expand simple ``[[= name =]]`` macro variables (mkdocs-macros syntax).

    Only plain scalar variables are substituted; unknown or complex macros are
    left untouched so callers can detect and handle them.
    """

    def _substitute(match: re.Match) -> str:
        value = variables.get(match.group(1))
        return str(value) if isinstance(value, (str, int, float)) else match.group(0)

    return _MACRO_RE.sub(_substitute, text)


def inject_page_metadata(
    content: str, description: str = "", editions: list = (), llms_txt_url: str = "/llms.txt"
) -> str:
    """Insert the llms.txt pointer, page description, and an 'Editions: X, Y' line after the first h1 heading.

    ``llms_txt_url`` must be the absolute URL of *this site's own* llms.txt
    (e.g. via ``urljoin(base_url, "llms.txt")``), not a hardcoded root-relative
    path — sites published under a nested path (e.g. a userguide project under
    ``/projects/userguide/``) have their llms.txt there, not at the domain root.
    """
    metadata_lines = ["", f"> For the complete documentation index, see [llms.txt]({llms_txt_url})."]
    if description:
        metadata_lines += ["", description]
    if editions:
        metadata_lines += ["", "Editions: " + ", ".join(editions)]

    lines = content.split("\n")
    for i, line in enumerate(lines):
        if line.startswith("# "):
            lines[i + 1:i + 1] = metadata_lines
            return "\n".join(lines)

    return "\n".join(metadata_lines).lstrip("\n") + "\n\n" + content


# ![alt](url) or ![alt](url "title")
_IMAGE_RE = re.compile(r'!\[([^\]]*)\]\(([^)\s]+)((?:\s+"[^"]*")?)\)')


def absolutize_image_urls(content: str, base_url: str, page_dir: str) -> str:
    """Rewrite relative image URLs in Markdown to absolute ones.

    The llmstxt plugin makes link hrefs absolute but not image srcs, so the
    ``![alt](src)`` references generated by markdownify keep their
    page-relative paths, which break in ``llms-full.txt``. This mirrors the
    URL logic the plugin applies to links.

    ``base_url`` is the site base URL (trailing slash), ``page_dir`` the
    page's directory relative to the site root (e.g. ``"cdp/cdp"``).
    """

    def _absolutize(match: re.Match) -> str:
        alt, url, title = match.groups()
        if not url.startswith(("/", "#")) and not urlparse(url).scheme:
            relative_base = urljoin(base_url, page_dir + "/") if page_dir else base_url
            url = urljoin(relative_base, url)
        return f"![{alt}]({url}{title})"

    return _IMAGE_RE.sub(_absolutize, content)


_ORDERED_MARKER_RE = re.compile(r"^(\s*)(\d+)\. (.*)$")
_FENCE_OPEN_RE = re.compile(r"^(\s*)(`{3,}|~{3,})")
# Width of an ordered-list marker ("1. ") — mdformat normalizes markers to
# "1. " and indents item content by exactly this much.
_MARKER_WIDTH = 3


def renumber_ordered_lists(content: str) -> str:
    """Replace repeated '1.' ordered-list markers with sequential numbers.

    The llmstxt plugin runs mdformat on the converted Markdown, which keeps
    the first marker of each ordered list (the list's start number) and
    rewrites all following markers to "1." (its default numbering style).
    This restores sequential numbers while keeping track of nesting:

    - a stack of (marker indent, counter) pairs tracks open ordered lists;
      the counter starts at the list's first marker number, so intentional
      start values (<ol start="N">, or literal "2\\." paragraphs in the
      source) are preserved,
    - blank lines and lines indented to an item's content column (marker
      indent + 3) are item continuation and don't interrupt numbering,
    - a less-indented line closes the lists it's not a continuation of,
    - fenced code blocks are passed through untouched.

    Known limitations (acceptable for LLM-oriented output): markers of items
    >= 10 are one character wider than the 3-space content indent, and lists
    inside blockquotes keep their "1." markers.
    """
    lines = content.split("\n")
    result = []
    stack = []  # [marker_indent, counter] per open ordered list, outermost first
    fence = None  # (fence_char, fence_length) while inside a fenced code block

    def close_lists(indent: int) -> None:
        # A line not indented to the content column of an open list closes it.
        while stack and indent < stack[-1][0] + _MARKER_WIDTH:
            stack.pop()

    for line in lines:
        if fence is not None:
            stripped = line.strip()
            if stripped and set(stripped) == {fence[0]} and len(stripped) >= fence[1]:
                fence = None
            result.append(line)
            continue

        fence_match = _FENCE_OPEN_RE.match(line)
        if fence_match:
            close_lists(len(fence_match.group(1)))
            marker = fence_match.group(2)
            fence = (marker[0], len(marker))
            result.append(line)
            continue

        if not line.strip():
            # Blank lines separate loose-list items and item paragraphs; they
            # never terminate a list on their own in mdformat output.
            result.append(line)
            continue

        marker_match = _ORDERED_MARKER_RE.match(line)
        if marker_match:
            indent = len(marker_match.group(1))
            while stack and stack[-1][0] > indent:
                stack.pop()
            if stack and stack[-1][0] == indent:
                stack[-1][1] += 1
            else:
                # A new list keeps its first marker number as the start.
                stack.append([indent, int(marker_match.group(2))])
            result.append(f"{marker_match.group(1)}{stack[-1][1]}. {marker_match.group(3)}")
            continue

        close_lists(len(line) - len(line.lstrip()))
        result.append(line)

    return "\n".join(result)
