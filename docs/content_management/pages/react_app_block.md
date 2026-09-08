---
description: Create a block that allows an editor to embed a preconfigured React component into a page.
---

# React App block

React App block allows an editor to embed a preconfigured React application into a page.
It's configured in YAML files, under the `ibexa_fieldtype_page` key.
Page block configuration isn't SiteAccess-aware.

[[% include 'snippets/page_block_cache_clear.md' %]]

## React App Block configuration

React App blocks are regular [Page blocks](page_blocks.md) and can be configured on field definition level as any other block.
Their configuration has exactly the same structure as regular [block configuration](page_blocks.md#block-configuration), except:

- additional `component` attribute which binds Page Builder block with React App
- `views` attribute is removed

Each configured React app block has an identifier and the following settings:

| Setting      | Description                                                                                                                                                   |
|--------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `name`       | Name of the block used in the Page Builder interface. Also accepts a [`help` key](page_blocks.md#block-name-and-help-text) that adds a helper text under the **Name** field in the block configuration form. |
| `category`   | Category in the Page Builder **Page blocks** toolbox that the block is shown in.                                                                                        |
| `thumbnail`  | Thumbnail used in the Page Builder **Page blocks** toolbox.                                                                                                             |
| `component`  | Name of the React app component that this block is bound to.                                                                                                  |
| `visible`    | (Optional) Toggles the block's visibility in the Page Builder **Page blocks** toolbox. Remove the block from the layout before you publish another version of the page. |
| <nobr>`attributes`</nobr> | (Optional) List of [block attributes](page_block_attributes.md).                                                                                              |

For example:

``` yaml
[[= include_file('code_samples/page/react_app_block/config/packages/react_blocks.yaml') =]]
```

Each entry below `react_blocks` adds one block to the Page Builder with the defined name, category and thumbnail.
Both name and attributes support a short syntax and a long one for specifics.

`Attributes` defined without sub-keys use the key as the identifier and name, and the value as the type:

``` yaml
attributes:
  b: integer
```

Sub-keys can be used to specify any of the usual [attributes configuration](page_block_attributes.md) key:

``` yaml
attributes:
  a:
    name: Attribute A
    type: string
    options:
      ...
```
