from build_package_docs import (
    check_relative_doc_links,
    rewrite_llms_txt,
    rewrite_page,
)

PAGES = {
    "index.md",
    "search/search/index.md",
    "search/search_api/index.md",
    "administration/back_office/back_office_menus/add_menu_item/index.md",
    "administration/back_office/back_office_menus/back_office_menus/index.md",
    "content_management/images/images/index.md",
}

REDIRECTS = {
    "guide/images/": "content_management/images/images/",
}

CLASS_PATHS = {
    "Ibexa\\Contracts\\AdminUi\\Tab\\AbstractTab": "ibexa/admin-ui/src/contracts/Tab/AbstractTab.php",
    "Ibexa\\Contracts\\Core\\Repository\\SearchService": "ibexa/core/src/contracts/Repository/SearchService.php",
}


BASE_URLS = ("https://doc.ibexa.co/en/latest/", "https://doc.ibexa.co/en/5.0/")


def rewrite(content, page_rel="search/search/index.md"):
    return rewrite_page(content, page_rel, PAGES, REDIRECTS, CLASS_PATHS, BASE_URLS)


class TestInternalLinks:
    def test_page_link_becomes_relative(self):
        assert (
            rewrite("See [Search API](https://doc.ibexa.co/en/latest/search/search_api/).")
            == "See [Search API](../search_api/index.md)."
        )

    def test_anchor_is_kept(self):
        content = "[events](https://doc.ibexa.co/en/latest/administration/back_office/back_office_menus/back_office_menus/#menu-events)"
        assert rewrite(content) == (
            "[events](../../administration/back_office/back_office_menus/back_office_menus/index.md#menu-events)"
        )

    def test_site_root_link(self):
        assert (
            rewrite("[home](https://doc.ibexa.co/en/latest/)")
            == "[home](../../index.md)"
        )

    def test_link_from_root_page(self):
        assert (
            rewrite("[search](https://doc.ibexa.co/en/latest/search/search/)", page_rel="index.md")
            == "[search](search/search/index.md)"
        )

    def test_redirected_url_resolves_through_redirect_map(self):
        assert (
            rewrite("[images](https://doc.ibexa.co/en/latest/guide/images/)")
            == "[images](../../content_management/images/images/index.md)"
        )

    def test_unknown_page_stays_absolute(self):
        content = "[gone](https://doc.ibexa.co/en/latest/no/such/page/)"
        assert rewrite(content) == content

    def test_other_doc_sites_stay_absolute(self):
        content = "[user docs](https://doc.ibexa.co/projects/userguide/en/latest/)"
        assert rewrite(content) == content

    def test_own_version_is_rewritten_like_latest(self):
        assert (
            rewrite("[Search API](https://doc.ibexa.co/en/5.0/search/search_api/)")
            == "[Search API](../search_api/index.md)"
        )

    def test_other_versions_stay_absolute(self):
        content = "[4.6 docs](https://doc.ibexa.co/en/4.6/search/search/)"
        assert rewrite(content) == content

    def test_other_version_api_links_stay_absolute(self):
        content = "[`X`](https://doc.ibexa.co/en/4.6/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Tab-AbstractTab.html)"
        assert rewrite(content) == content

    def test_external_links_stay_absolute(self):
        content = "[Symfony](https://symfony.com/doc/current/index.html)"
        assert rewrite(content) == content

    def test_images_are_not_rewritten(self):
        content = "![Admin panel](https://doc.ibexa.co/en/latest/search/search/)"
        assert rewrite(content) == content

    def test_links_in_fenced_code_blocks_are_untouched(self):
        content = "\n".join(
            [
                "```markdown",
                "[Search](https://doc.ibexa.co/en/latest/search/search_api/)",
                "```",
                "[Search](https://doc.ibexa.co/en/latest/search/search_api/)",
            ]
        )
        assert rewrite(content) == "\n".join(
            [
                "```markdown",
                "[Search](https://doc.ibexa.co/en/latest/search/search_api/)",
                "```",
                "[Search](../search_api/index.md)",
            ]
        )


class TestApiLinks:
    URL = "https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Tab-AbstractTab.html"

    def test_resolved_class_links_to_vendor_source_with_fqcn_text(self):
        # From doc/search/search/index.md: 3 dirs inside the package + 2 up to vendor/.
        assert rewrite(f"[`AbstractTab`]({self.URL})") == (
            "[`Ibexa\\Contracts\\AdminUi\\Tab\\AbstractTab`]"
            "(../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractTab.php)"
        )

    def test_depth_follows_page_location(self):
        page = "administration/back_office/back_office_menus/add_menu_item/index.md"
        result = rewrite(f"[`AbstractTab`]({self.URL})", page_rel=page)
        assert result.endswith("(../../../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractTab.php)")

    def test_method_anchor_is_dropped_and_text_kept(self):
        url = "https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html"
        assert rewrite(f"[`findContent()`]({url}#method_findContent)") == (
            "[`findContent()`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php)"
        )

    def test_unresolved_class_keeps_url_but_gets_fqcn_text(self):
        url = "https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-ConnectClientInterface.html"
        assert rewrite(f"[`ConnectClientInterface`]({url})") == (
            f"[`Ibexa\\Contracts\\Connect\\ConnectClientInterface`]({url})"
        )


class TestLlmsTxt:
    def test_page_links_point_into_doc(self):
        content = "- [Search](https://doc.ibexa.co/en/latest/search/search/index.md)"
        assert rewrite_llms_txt(content, PAGES) == "- [Search](doc/search/search/index.md)"

    def test_root_page(self):
        content = "- [Home](https://doc.ibexa.co/en/latest/index.md)"
        assert rewrite_llms_txt(content, PAGES) == "- [Home](doc/index.md)"

    def test_unknown_page_stays_absolute(self):
        content = "- [Gone](https://doc.ibexa.co/en/latest/no/such/index.md)"
        assert rewrite_llms_txt(content, PAGES) == content


class TestSelfCheck:
    def test_valid_links_pass(self):
        pages = {
            "a/b/index.md": "[ok](../c/index.md)",
            "a/c/index.md": "[ok](../b/index.md#anchor)",
        }
        assert check_relative_doc_links(pages) == []

    def test_broken_link_is_reported(self):
        pages = {"a/b/index.md": "[broken](../missing/index.md)"}
        errors = check_relative_doc_links(pages)
        assert len(errors) == 1
        assert "a/b/index.md" in errors[0]

    def test_link_escaping_doc_tree_is_reported(self):
        pages = {"a/index.md": "[escape](../../outside.md)"}
        assert len(check_relative_doc_links(pages)) == 1

    def test_vendor_and_external_links_are_skipped(self):
        pages = {
            "a/index.md": "[php](../../../ibexa/core/src/S.php) [web](https://example.com/x.md)"
        }
        assert check_relative_doc_links(pages) == []
