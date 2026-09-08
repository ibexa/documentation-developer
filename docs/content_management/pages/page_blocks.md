---
description: Use blocks to customize the content of a Page with dynamic content.
---

# Page blocks

Page blocks are configured in YAML files, under the `ibexa_fieldtype_page` key.
Keep in mind that Page block configuration isn't SiteAccess-aware.

[[= product_name =]] ships with a number of page blocks.
For a list of all page blocks that are available out-of-the-box, see [Page block reference]([[= user_doc =]]/content_management/block_reference/).

[[% include 'snippets/page_block_cache_clear.md' %]]

## Block configuration

Each configured block has an identifier and the following settings:

| Setting                               | Description                                                                                                                                                             |
|---------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `name`                                | Name of the block used in the Page Builder interface. Translatable using the `ibexa_page_fieldtype` translation domain. Also accepts a [`help` key](#block-name-and-help-text) that adds a helper text under the **Name** field in the block configuration form. |
| `category`                            | Category in the Page Builder **Page blocks** toolbox that the block is shown in. Translatable using the `ibexa_page_fieldtype` translation domain.                      |
| `thumbnail`                           | Thumbnail used in the Page Builder **Page blocks** toolbox.                                                                                                             |
| `views`                               | Available [templates for the block](#block-templates).                                                                                                                  |
| `visible`                             | (Optional) Toggles the block's visibility in the Page Builder **Page blocks** toolbox. Remove the block from the layout before you publish another version of the page. |
| `attributes`                          | (Optional) List of [block attributes](page_block_attributes.md).                                                                                                        |
| <nobr>`cacheable_query_params`</nobr> | (Optional) List of query parameters the block's ESI HTTP cache varies on.<br>For example, if the block is paginated using `?page=ℕ` from the page URL, add `page` to this list. |

For example:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 6) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 7, 12) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 16, 17) =]]# ...
```

### Block name and help text

The `name` setting accepts either a single translation key, a hard coded string of text that won't be translated, or an object with `text` and `help` property keys.
Both `text` and `help` are translatable using the `ibexa_page_fieldtype` translation domain.

Scalar form:

``` yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name: my_block.name.key
```

Structured form with a helper text:

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name:
                text: my_block.name.key
                help: my_block.name.help.key
```

- `text` - corresponds to the block name.
- `help` - is an optional translation key whose translation is rendered as a helper text under the **Name** field in the block configuration form.

![Help text](help_text.png)

The same format is available for [React App blocks](react_app_block.md).

### Overwriting existing blocks

You can overwrite the following properties in the existing blocks:

- `name`
- `category`
- `thumbnail`
- `views`

## Block templates

Page blocks can have multiple templates.
This allows you to create different styles for each block and let the editor choose them when adding the block from the UI.
They names are translatable using the `ibexa_page_builder_block_config` translation domain.

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 3) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 7, 16) =]]
```

`priority` defines the order of block views on the block configuration screen.
The highest number shows first on the list.

!!! tip

    Default views have a `priority` of -255.
    It's good practice to keep the value between -255 and 255.
