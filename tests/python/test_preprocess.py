import mdformat
from bs4 import BeautifulSoup
from mkdocs_llmstxt._internal.plugin import _converter

import llmstxt_preprocess
from llmstxt_preprocess import renumber_ordered_lists


def to_markdown(html: str) -> str:
    """Replicate the mkdocs-llmstxt conversion pipeline for a HTML snippet.

    Uses the plugin's own MarkdownConverter instance so options (bullets,
    heading style, code language callback) always match what ships.
    """
    soup = BeautifulSoup(html, "html.parser")
    llmstxt_preprocess.preprocess(soup, "")
    return mdformat.text(
        _converter.convert_soup(soup),
        options={"wrap": "no"},
        extensions=("tables",),
    )


def preprocessed(html: str) -> BeautifulSoup:
    soup = BeautifulSoup(html, "html.parser")
    llmstxt_preprocess.preprocess(soup, "")
    return soup


def test_checkmark_only_cell_becomes_yes():
    html = "<table><tr><th>Feature</th><th>Included</th></tr><tr><td>Search</td><td>✔</td></tr></table>"
    result = to_markdown(html)
    assert "✔" not in result
    assert "| Yes" in result


def test_checkmark_mixed_with_other_nodes():
    html = "<table><tr><th>H</th></tr><tr><td>✔ <code>option</code></td></tr></table>"
    result = to_markdown(html)
    assert "Yes `option`" in result


def test_release_note_date_gets_prefix():
    html = '<h2>Connector v5.0.7</h2><div class="release-note__date">2026-04-20</div>'
    assert "Release date: 2026-04-20" in to_markdown(html)


def test_release_note_tags_appended_to_heading():
    html = (
        '<h2>Connector v5.0.7<a class="headerlink" href="#c">&para;</a></h2>'
        '<div class="release-note__tags">'
        '<div class="pill pill--headless"></div>'
        '<div class="pill pill--experience"></div>'
        "</div>"
    )
    assert "## Connector v5.0.7 (Headless, Experience)" in to_markdown(html)


def test_admonition_becomes_blockquote():
    html = (
        '<div class="admonition caution">'
        '<p class="admonition-title">Recommended versions</p>'
        "<p>Body text.</p>"
        "</div>"
    )
    result = to_markdown(html)
    assert "> **Caution: Recommended versions**" in result
    assert "> Body text." in result


def test_tabbed_set_labels_become_bold_text():
    html = (
        '<div class="tabbed-set">'
        '<div class="tabbed-labels"><label>Tab A</label><label>Tab B</label></div>'
        '<div class="tabbed-content">'
        '<div class="tabbed-block"><p>Content A</p></div>'
        '<div class="tabbed-block"><p>Content B</p></div>'
        "</div></div>"
    )
    result = to_markdown(html)
    assert "**Tab A**\n\nContent A\n\n**Tab B**\n\nContent B" in result


def test_cards_become_link_list():
    html = (
        '<div class="cards two-in-row"><div class="card-wrapper">'
        '<a class="card" href="https://example.com/page/">'
        '<p class="title">Page title</p><p class="description">Page description</p>'
        "</a></div></div>"
    )
    assert "- [Page title](https://example.com/page/): Page description" in to_markdown(html)


def test_inline_pill_becomes_parenthetical():
    html = '<p>Feature<span class="pill--inline pill--experience"></span> is available.</p>'
    assert "Feature (Experience) is available." in to_markdown(html)


def test_adjacent_inline_pills_merged():
    # Structure from update_from_5.0: pills separated by a space in a heading.
    html = (
        '<h3 id="db">Database update '
        '<span class="pill pill--inline pill--experience"></span> '
        '<span class="pill pill--inline pill--commerce"></span>'
        '<a class="headerlink" href="#db">&para;</a></h3>'
    )
    result = to_markdown(html)
    assert "### Database update (Experience, Commerce)" in result
    assert ") (" not in result


def test_three_adjacent_inline_pills_merged():
    html = (
        "<p>Feature"
        '<span class="pill--inline pill--headless"></span> '
        '<span class="pill--inline pill--experience"></span> '
        '<span class="pill--inline pill--commerce"></span> is available.</p>'
    )
    assert "Feature (Headless, Experience, Commerce) is available." in to_markdown(html)


def test_ol_start_attribute_preserved():
    # <ol start="N"> (a list interrupted by other content) keeps its numbering.
    html = "<ol><li>a</li><li>b</li></ol><p>note</p><ol start='3'><li>c</li><li>d</li></ol>"
    result = renumber_ordered_lists(to_markdown(html))
    assert "1. a\n2. b" in result
    assert "3. c\n4. d" in result


def test_escaped_literal_numbers_keep_their_value():
    # 'N\.' paragraphs in the source render as plain text and must keep N.
    html = "<p>2. To expose a single catalog to all users:</p>"
    assert renumber_ordered_lists(to_markdown(html)).startswith("2. To expose")


def test_info_tile_flattened_to_link_text():
    html = (
        '<a class="info-tile" href="page/">'
        '<div class="info-tile__details">Details</div>'
        "<div>Meaningful text</div>"
        "</a>"
    )
    assert "[Meaningful text](page/)" in to_markdown(html)


def test_image_with_alt_kept_as_markdown_image():
    assert "![Request lifecycle](x.png)" in to_markdown('<img src="x.png" alt="Request lifecycle">')
    # Images without a description tell an AI agent nothing — dropped.
    assert to_markdown('<img src="x.png">').strip() == ""


def test_headerlink_removed():
    html = '<h2>Title<a class="headerlink" href="#t">&para;</a></h2>'
    assert to_markdown(html).strip() == "## Title"


def test_headerlink_after_image_removed():
    html = (
        '<p><img src="cdp.png" alt="Ibexa CDP control panel"></p>'
        '<h2 id="how-it-works">How it works'
        '<a class="headerlink" href="#how-it-works" title="Permanent link">&para;</a></h2>'
    )
    result = to_markdown(html)
    assert "![Ibexa CDP control panel](cdp.png)" in result
    assert "## How it works" in result
    assert "Permanent link" not in result
    assert "¶" not in result


def test_image_wrapping_link_unwrapped():
    # Lightbox-style links around images are unwrapped to a plain image.
    html = '<a href="big.png"><img src="small.png" alt="Thumb"></a><p>Kept</p>'
    result = to_markdown(html)
    assert "![Thumb](small.png)" in result
    assert "[![" not in result
    assert "Kept" in result


def test_line_numbered_code_block_keeps_language():
    # Structure emitted by pymdownx.highlight with linenums + pygments_lang_class.
    html = (
        '<div class="highlight"><table class="highlighttable"><tr>'
        '<td class="linenos"><div class="linenodiv"><pre><span></span><span class="normal">1</span></pre></div></td>'
        '<td class="code"><div><pre><span></span>'
        '<code class="language-bash">apt-get<span class="w"> </span>install<span class="w"> </span>composer\n</code>'
        "</pre></div></td></tr></table></div>"
    )
    result = to_markdown(html)
    assert "```bash\napt-get install composer\n```" in result
    # Line numbers must not leak into the output.
    assert "\n1\n" not in result


def test_line_numbered_code_block_without_language():
    html = (
        '<div class="highlight"><table class="highlighttable"><tr>'
        '<td class="code"><div><pre><span></span><code>plain text\n</code></pre></div></td>'
        "</tr></table></div>"
    )
    result = to_markdown(html)
    assert "```\nplain text\n```" in result


def test_release_notes_filters_removed():
    html = '<div class="release-notes-filters"><button>Filter</button></div><p>Kept</p>'
    result = to_markdown(html)
    assert "Filter" not in result
    assert "Kept" in result
