from llmstxt_preprocess import editions_from_frontmatter, inject_edition_badges


def test_inserted_after_first_h1():
    content = "# Title\n\nBody text."
    assert inject_edition_badges(content, ["Commerce"]) == "# Title\n\nEditions: Commerce\n\nBody text."


def test_prepended_when_no_h1():
    content = "Body text."
    assert inject_edition_badges(content, ["Commerce"]) == "Editions: Commerce\n\nBody text."


def test_no_editions_leaves_content_unchanged():
    content = "# Title\n\nBody text."
    assert inject_edition_badges(content, []) == content


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
