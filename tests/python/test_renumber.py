from llmstxt_preprocess import renumber_ordered_lists


def test_flat_list():
    assert renumber_ordered_lists("1. one\n1. two\n1. three") == "1. one\n2. two\n3. three"


def test_nested_bullets_do_not_reset_numbering():
    # Regression: https://github.com/ibexa/documentation-developer/pull/3161
    # numbering restarted at 1 after the nested "- " bullets.
    content = "\n".join([
        "1. Sets a variable with the desired Varnish version",
        "1. Copies and customizes `parameters.vcl` file:",
        "   - sets `web` container as the backend host",
        '   - adds "all IPs" CIDR notation to `debuggers` list',
        "   - on Varnish 7, enable logging of access control list matching",
        "1. Sets main `varnish*.vcl` file to use",
        "1. Copies the main VCL file",
        "1. Sets the Varnish version to use",
        "1. Adds the Varnish container",
        "1. Sets Varnish as the HTTP cache server",
        "1. Restarts the DDEV cluster",
    ])
    result = renumber_ordered_lists(content)
    markers = [line.split(".")[0] for line in result.split("\n") if not line.startswith("   ")]
    assert markers == ["1", "2", "3", "4", "5", "6", "7", "8"]
    # Nested bullets are untouched
    assert "   - sets `web` container as the backend host" in result


def test_nested_ordered_lists():
    content = "\n".join([
        "1. a",
        "   1. a1",
        "   1. a2",
        "1. b",
        "   1. b1",
    ])
    expected = "\n".join([
        "1. a",
        "   1. a1",
        "   2. a2",
        "2. b",
        "   1. b1",
    ])
    assert renumber_ordered_lists(content) == expected


def test_loose_list_keeps_numbering_across_blank_lines():
    content = "1. first\n\n1. second\n\n1. third"
    assert renumber_ordered_lists(content) == "1. first\n\n2. second\n\n3. third"


def test_continuation_paragraph_keeps_numbering():
    content = "1. first\n\n   continuation paragraph\n\n1. second"
    assert renumber_ordered_lists(content) == "1. first\n\n   continuation paragraph\n\n2. second"


def test_fence_inside_item_keeps_numbering_and_content():
    content = "\n".join([
        "1. first",
        "",
        "   ```bash",
        "   1. not a marker",
        "   echo hi",
        "   ```",
        "",
        "1. second",
    ])
    result = renumber_ordered_lists(content)
    assert "   1. not a marker" in result
    assert result.endswith("2. second")


def test_top_level_fence_resets_list():
    content = "\n".join([
        "1. first",
        "1. second",
        "",
        "```text",
        "1. fake",
        "```",
        "",
        "1. new list",
    ])
    result = renumber_ordered_lists(content).split("\n")
    assert result[0] == "1. first"
    assert result[1] == "2. second"
    assert result[4] == "1. fake"  # fence content untouched
    assert result[7] == "1. new list"


def test_top_level_paragraph_resets_list():
    content = "1. first\n1. second\n\nA paragraph.\n\n1. new list"
    assert renumber_ordered_lists(content) == "1. first\n2. second\n\nA paragraph.\n\n1. new list"


def test_keeps_start_number_and_is_idempotent():
    # mdformat keeps the first marker (the list's start) and rewrites the
    # rest to "1." — the start must survive renumbering.
    assert renumber_ordered_lists("4. a\n1. b\n1. c") == "4. a\n5. b\n6. c"
    assert renumber_ordered_lists("3. a\n7. b") == "3. a\n4. b"
    content = "1. one\n1. two\n   - bullet\n1. three"
    once = renumber_ordered_lists(content)
    assert renumber_ordered_lists(once) == once
    assert renumber_ordered_lists("4. a\n5. b\n6. c") == "4. a\n5. b\n6. c"


def test_intentional_paragraph_numbers_kept():
    # Sources sometimes use escaped literal numbers ("1\.", "2\.") that end up
    # as separate single-item lists in the converted Markdown — their numbers
    # are intentional and must not be reset to 1.
    content = "\n".join([
        "1. All products available for all users:",
        "",
        "```yaml",
        "catalog: ~",
        "```",
        "",
        "2. To expose a single catalog:",
        "",
        "```yaml",
        "catalog: custom_catalog",
        "```",
        "",
        "3. Specific catalog for the defined customer group",
    ])
    assert renumber_ordered_lists(content) == content


def test_escaped_number_is_not_a_marker():
    content = "1\\. not a list"
    assert renumber_ordered_lists(content) == content


def test_tilde_fence_and_unclosed_fence():
    content = "~~~\n1. fake\n~~~"
    assert renumber_ordered_lists(content) == content
    unclosed = "```\n1. fake\n1. still fake"
    assert renumber_ordered_lists(unclosed) == unclosed
