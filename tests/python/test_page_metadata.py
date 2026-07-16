from llms_txt.llmstxt_preprocess import (
    editions_from_frontmatter,
    expand_macros,
    inject_page_metadata,
)


def test_editions_inserted_after_first_h1():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content, editions=["Commerce"]) == (
        "# Title\n\nEditions: Commerce\n\nBody text."
    )


def test_description_inserted_after_first_h1():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content, description="Configure the Storefront.") == (
        "# Title\n\nConfigure the Storefront.\n\nBody text."
    )


def test_description_comes_before_editions():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content, description="A description.", editions=["Commerce"]) == (
        "# Title\n\nA description.\n\nEditions: Commerce\n\nBody text."
    )


def test_prepended_when_no_h1():
    content = "Body text."
    assert inject_page_metadata(content, description="A description.", editions=["Commerce"]) == (
        "A description.\n\nEditions: Commerce\n\nBody text."
    )


def test_no_metadata_leaves_content_unchanged():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content) == content
    assert inject_page_metadata(content, description="", editions=[]) == content


def test_frontmatter_edition_string():
    assert editions_from_frontmatter({"edition": "commerce experience"}) == ["Commerce", "Experience"]


def test_frontmatter_editions_list():
    assert editions_from_frontmatter({"editions": ["headless", "lts-update"]}) == ["Headless", "LTS Update"]


def test_frontmatter_edition_and_editions_merged():
    result = editions_from_frontmatter({"edition": "commerce", "editions": ["headless"]})
    assert result == ["Commerce", "Headless"]


def test_unknown_edition_passes_through():
    assert editions_from_frontmatter({"edition": "custom"}) == ["custom"]


def test_empty_frontmatter():
    assert editions_from_frontmatter({}) == []


def test_expand_macros_substitutes_scalars():
    variables = {"product_name": "Ibexa DXP", "product_name_cdp": "Ibexa CDP"}
    assert expand_macros("Install [[= product_name_cdp =]] with [[= product_name =]].", variables) == (
        "Install Ibexa CDP with Ibexa DXP."
    )


def test_expand_macros_leaves_unknown_untouched():
    assert expand_macros("Uses [[= unknown_var =]].", {}) == "Uses [[= unknown_var =]]."
    # Complex expressions are not simple variables — left for the caller to detect.
    text = "See [[= include_file('x.md') =]]."
    assert expand_macros(text, {"include_file": "nope"}) == text
