from llms_txt.llmstxt_preprocess import (
    expand_macros,
    inject_page_metadata,
)


LLMS_TXT_LINE = "> For the complete documentation index, see [llms.txt](/llms.txt)."


def test_llms_txt_pointer_always_inserted_after_first_h1():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content) == (
        f"# Title\n\n{LLMS_TXT_LINE}\n\nBody text."
    )
    assert inject_page_metadata(content, description="") == (
        f"# Title\n\n{LLMS_TXT_LINE}\n\nBody text."
    )


def test_description_inserted_after_first_h1():
    content = "# Title\n\nBody text."
    assert inject_page_metadata(content, description="Configure the Storefront.") == (
        f"# Title\n\n{LLMS_TXT_LINE}\n\nConfigure the Storefront.\n\nBody text."
    )


def test_prepended_when_no_h1():
    content = "Body text."
    assert inject_page_metadata(content, description="A description.") == (
        f"{LLMS_TXT_LINE}\n\nA description.\n\nBody text."
    )


def test_llms_txt_url_respects_nested_site_path():
    # A userguide-style project published under /projects/userguide/ has its
    # own llms.txt there, not at the domain root.
    content = "# Title\n\nBody text."
    nested_line = "> For the complete documentation index, see [llms.txt](https://doc.ibexa.co/projects/userguide/en/5.0/llms.txt)."
    result = inject_page_metadata(
        content, llms_txt_url="https://doc.ibexa.co/projects/userguide/en/5.0/llms.txt"
    )
    assert result == f"# Title\n\n{nested_line}\n\nBody text."


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
