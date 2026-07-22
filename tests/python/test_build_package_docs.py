from build_package_docs import (
    DocSet,
    check_relative_doc_links,
    rewrite_llms_txt,
    rewrite_page,
    strip_llms_txt_pointer,
)

DEVELOPER = DocSet(
    root="developer",
    base_urls=("https://doc.ibexa.co/en/latest/", "https://doc.ibexa.co/en/5.0/"),
    pages=frozenset(
        {
            "index.md",
            "search/search/index.md",
            "search/search_api/index.md",
            "administration/back_office/back_office_menus/add_menu_item/index.md",
            "administration/back_office/back_office_menus/back_office_menus/index.md",
            "content_management/images/images/index.md",
        }
    ),
    redirects={"guide/images/": "content_management/images/images/"},
)

USER = DocSet(
    root="user",
    base_urls=(
        "https://doc.ibexa.co/projects/userguide/en/latest/",
        "https://doc.ibexa.co/projects/userguide/en/5.0/",
    ),
    pages=frozenset(
        {
            "index.md",
            "image_management/edit_images/index.md",
            "getting_started/get_started/index.md",
        }
    ),
    redirects={"getting_started/": "getting_started/get_started/"},
)

DOCSETS = (DEVELOPER, USER)

CLASS_PATHS = {
    "Ibexa\\Contracts\\AdminUi\\Tab\\AbstractTab": "ibexa/admin-ui/src/contracts/Tab/AbstractTab.php",
    "Ibexa\\Contracts\\Core\\Repository\\SearchService": "ibexa/core/src/contracts/Repository/SearchService.php",
}


def rewrite(content, page_path="developer/search/search/index.md"):
    return rewrite_page(content, page_path, DOCSETS, CLASS_PATHS)


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

    def test_link_from_set_root_page(self):
        assert (
            rewrite("[search](https://doc.ibexa.co/en/latest/search/search/)",
                    page_path="developer/index.md")
            == "[search](search/search/index.md)"
        )

    def test_redirected_url_resolves_through_redirect_map(self):
        assert (
            rewrite("[images](https://doc.ibexa.co/en/latest/guide/images/)")
            == "[images](../../content_management/images/images/index.md)"
        )

    def test_own_version_is_rewritten_like_latest(self):
        assert (
            rewrite("[Search API](https://doc.ibexa.co/en/5.0/search/search_api/)")
            == "[Search API](../search_api/index.md)"
        )

    def test_unknown_page_stays_absolute(self):
        content = "[gone](https://doc.ibexa.co/en/latest/no/such/page/)"
        assert rewrite(content) == content

    def test_other_versions_stay_absolute(self):
        content = "[4.6 docs](https://doc.ibexa.co/en/4.6/search/search/)"
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


class TestCrossSetLinks:
    def test_developer_page_links_to_user_doc(self):
        content = "[edit images](https://doc.ibexa.co/projects/userguide/en/latest/image_management/edit_images/)"
        assert rewrite(content) == "[edit images](../../../user/image_management/edit_images/index.md)"

    def test_user_page_links_to_developer_doc(self):
        content = "[Search API](https://doc.ibexa.co/en/latest/search/search_api/)"
        assert (
            rewrite(content, page_path="user/getting_started/get_started/index.md")
            == "[Search API](../../../developer/search/search_api/index.md)"
        )

    def test_user_internal_link_with_version_and_redirect(self):
        content = "[start](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/)"
        assert (
            rewrite(content, page_path="user/image_management/edit_images/index.md")
            == "[start](../../getting_started/get_started/index.md)"
        )

    def test_developer_link_to_user_doc_with_matching_version(self):
        content = "[edit images](https://doc.ibexa.co/projects/userguide/en/5.0/image_management/edit_images/)"
        assert rewrite(content) == "[edit images](../../../user/image_management/edit_images/index.md)"

    def test_developer_link_to_user_doc_with_other_version_stays_absolute(self):
        content = "[old](https://doc.ibexa.co/projects/userguide/en/4.6/image_management/edit_images/)"
        assert rewrite(content) == content

    def test_user_link_to_developer_doc_with_matching_version(self):
        content = "[Search API](https://doc.ibexa.co/en/5.0/search/search_api/)"
        assert (
            rewrite(content, page_path="user/index.md")
            == "[Search API](../developer/search/search_api/index.md)"
        )

    def test_user_link_to_developer_doc_with_other_version_stays_absolute(self):
        content = "[old](https://doc.ibexa.co/en/4.6/search/search_api/)"
        assert rewrite(content, page_path="user/index.md") == content

    def test_unknown_user_page_stays_absolute(self):
        content = "[gone](https://doc.ibexa.co/projects/userguide/en/latest/no/such/)"
        assert rewrite(content) == content

    def test_other_projects_stay_absolute(self):
        content = "[connect](https://doc.ibexa.co/projects/connect/en/latest/)"
        assert rewrite(content) == content


class TestApiLinks:
    URL = "https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Tab-AbstractTab.html"

    def test_resolved_class_links_to_vendor_source_with_fqcn_text(self):
        # From developer/search/search/index.md: 3 dirs inside the package + 2 up to vendor/.
        assert rewrite(f"[`AbstractTab`]({self.URL})") == (
            "[`Ibexa\\Contracts\\AdminUi\\Tab\\AbstractTab`]"
            "(../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractTab.php)"
        )

    def test_depth_follows_page_location(self):
        page = "developer/administration/back_office/back_office_menus/add_menu_item/index.md"
        result = rewrite(f"[`AbstractTab`]({self.URL})", page_path=page)
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

    def test_other_version_api_links_stay_absolute(self):
        content = "[`X`](https://doc.ibexa.co/en/4.6/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Tab-AbstractTab.html)"
        assert rewrite(content) == content


class TestLlmsTxt:
    def test_page_links_are_relative_to_set_root(self):
        content = "- [Search](https://doc.ibexa.co/en/latest/search/search/index.md)"
        assert rewrite_llms_txt(content, DEVELOPER) == "- [Search](search/search/index.md)"

    def test_set_root_page(self):
        content = "- [Home](https://doc.ibexa.co/en/latest/index.md)"
        assert rewrite_llms_txt(content, DEVELOPER) == "- [Home](index.md)"

    def test_user_set_uses_its_own_base(self):
        content = "- [Edit images](https://doc.ibexa.co/projects/userguide/en/latest/image_management/edit_images/index.md)"
        assert rewrite_llms_txt(content, USER) == "- [Edit images](image_management/edit_images/index.md)"

    def test_unknown_page_stays_absolute(self):
        content = "- [Gone](https://doc.ibexa.co/en/latest/no/such/index.md)"
        assert rewrite_llms_txt(content, DEVELOPER) == content


class TestLlmsTxtPointer:
    """Mirrors the shapes inject_page_metadata() (tools/llms_txt/llmstxt_preprocess.py) produces."""

    def test_pointer_is_removed_without_leaving_a_double_blank_line(self):
        content = (
            "# Getting started\n"
            "\n"
            "> For the complete documentation index, see [llms.txt](https://doc.ibexa.co/en/5.0/llms.txt).\n"
            "\n"
            "Body text here.\n"
        )
        assert strip_llms_txt_pointer(content) == "# Getting started\n\nBody text here.\n"

    def test_description_and_editions_lines_are_kept(self):
        content = (
            "# Heading\n"
            "\n"
            "> For the complete documentation index, see [llms.txt](https://doc.ibexa.co/en/5.0/llms.txt).\n"
            "\n"
            "Some page description.\n"
            "\n"
            "Editions: Content, Experience\n"
        )
        assert strip_llms_txt_pointer(content) == (
            "# Heading\n\nSome page description.\n\nEditions: Content, Experience\n"
        )

    def test_nested_project_url_is_also_stripped(self):
        content = (
            "# Edit images\n"
            "\n"
            "> For the complete documentation index, see "
            "[llms.txt](https://doc.ibexa.co/projects/userguide/en/5.0/llms.txt).\n"
            "\n"
            "Body.\n"
        )
        assert strip_llms_txt_pointer(content) == "# Edit images\n\nBody.\n"

    def test_pointer_without_a_heading_is_stripped_cleanly(self):
        content = (
            "> For the complete documentation index, see [llms.txt](https://doc.ibexa.co/en/5.0/llms.txt).\n"
            "\n"
            "Just body text.\n"
        )
        assert strip_llms_txt_pointer(content) == "Just body text.\n"


class TestSelfCheck:
    def test_valid_links_pass(self):
        pages = {
            "developer/a/index.md": "[ok](../b/index.md) [cross](../../user/c/index.md)",
            "developer/b/index.md": "[ok](../a/index.md#anchor)",
            "user/c/index.md": "[cross](../../developer/a/index.md)",
        }
        assert check_relative_doc_links(pages) == []

    def test_broken_link_is_reported(self):
        pages = {"developer/a/index.md": "[broken](../missing/index.md)"}
        errors = check_relative_doc_links(pages)
        assert len(errors) == 1
        assert "developer/a/index.md" in errors[0]

    def test_link_escaping_package_tree_is_reported(self):
        pages = {"developer/a/index.md": "[escape](../../../outside.md)"}
        assert len(check_relative_doc_links(pages)) == 1

    def test_vendor_and_external_links_are_skipped(self):
        pages = {
            "developer/a/index.md": "[php](../../../ibexa/core/src/S.php) [web](https://example.com/x.md)"
        }
        assert check_relative_doc_links(pages) == []
