from llmstxt_preprocess import absolutize_image_urls

BASE = "https://doc.ibexa.co/en/latest/"


def test_relative_src_resolved_against_page_dir():
    content = "![CDP panel](img/cdp.png)"
    assert absolutize_image_urls(content, BASE, "cdp/cdp") == (
        "![CDP panel](https://doc.ibexa.co/en/latest/cdp/cdp/img/cdp.png)"
    )


def test_parent_relative_src():
    content = "![Diagram](../../img/flow.png)"
    assert absolutize_image_urls(content, BASE, "cdp/cdp") == (
        "![Diagram](https://doc.ibexa.co/en/latest/img/flow.png)"
    )


def test_root_page_uses_base_url():
    content = "![Logo](img/logo.png)"
    assert absolutize_image_urls(content, BASE, ".") == (
        "![Logo](https://doc.ibexa.co/en/latest/img/logo.png)"
    )


def test_already_absolute_url_untouched():
    content = "![External](https://example.com/x.png)"
    assert absolutize_image_urls(content, BASE, "cdp/cdp") == content


def test_site_absolute_path_untouched():
    # Matches the plugin's behavior for link hrefs starting with "/".
    content = "![Rooted](/assets/x.png)"
    assert absolutize_image_urls(content, BASE, "cdp/cdp") == content


def test_title_preserved():
    content = '![Alt](img/x.png "A title")'
    assert absolutize_image_urls(content, BASE, "a/b") == (
        '![Alt](https://doc.ibexa.co/en/latest/a/b/img/x.png "A title")'
    )


def test_multiple_images_and_surrounding_text():
    content = "Before ![One](a.png) middle ![Two](b.png) after"
    result = absolutize_image_urls(content, BASE, "dir")
    assert "![One](https://doc.ibexa.co/en/latest/dir/a.png)" in result
    assert "![Two](https://doc.ibexa.co/en/latest/dir/b.png)" in result


def test_regular_links_untouched():
    content = "[A link](img/x.png) and text"
    assert absolutize_image_urls(content, BASE, "dir") == content
