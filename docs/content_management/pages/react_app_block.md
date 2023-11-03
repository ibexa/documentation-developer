---
description: Create a block that allows an editor to embed a preconfigured React component into a page.
---

# React App block

React App block allows an editor to embed a preconfigured React application into a page.
It's configured in YAML files, under the `ibexa_fieldtype_page` key.
Page block configuration isn't SiteAccess-aware.

Another element of React App Block is `\Ibexa\FieldTypePage\FieldType\Page\Block\Event\Listener\ReactBlock` Listener 
which adds component and props variables.

It's common to all the blocks.

[[% include 'snippets/page_block_cache_clear.md' %]]

## React App Block configuration

React App blocks are regular [Page blocks](page_blocks.md) and can be configured on field definition level as any other block.
File has exactly the same structure as regular YAML [block configuration](create_custom_page_block.md#configure-block), except:

- additional `component` attribute which binds Page Builder block with React App
- `views` attribute is removed

Each configured React app block has an identifier and the following settings:

| Setting      | Description                                                                                                                                                   |
|--------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `name`       | Name of the block used in the Page Builder interface.                                                                                                         |
| `category`   | Category in the Page Builder elements menu that the block is shown in.                                                                                        |
| `thumbnail`  | Thumbnail used in the Page Builder elements menu.                                                                                                             |
| `component`  | React App Component name used in `assets/page-builder/react/blocks` directory.                                                                                |
| `visible`    | (Optional) Toggles the block's visibility in the Page Builder elements menu. Remove the block from the layout before you publish another version of the page. |
| `attributes` | (Optional) List of [block attributes](page_block_attributes.md).                                                                                              |

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

Apps that are registered this way must be configured and referenced in the 
semantic configuration to be registered as blocks.

Parameters passed as props must be converted so that they can be used as the configured type in the app.

## Create React App block

In the following example, you learn how to create `Calculator` React App block.

### Configure React App Block

First, install the react.
Run `yarn add react` command.

Next, create a .jsx file which describes your component.
You can place it in any location.

In the following example, create `Calculator.jsx` file in `assets/page-builder/components/` directory:

``` js
[[= include_file('code_samples/page/react_app_block/assets/page-builder/components/Calculator.jsx') =]]
```

Then, create a `Calculator.js` file in `assets/page-builder/react/blocks` directory.

Files in this directory create a map of Components which then are imported to `react.blocks.js` file.
As a result, the components are rendered on the page. 

``` js
[[= include_file('code_samples/page/react_app_block/assets/page-builder/react/blocks/Calculator.js') =]]
```

Now, you should see new `Calculator` block in the Page Builder blocks list:

![Calculator](calculator.png "Calculator - React App Block")

Then, make sure that your [Page layout template](template_configuration.md#page-layout) (like `templates/themes/standard/pagelayout.html.twig`) has the following Twig code in its `{% block javascripts %}`:

``` twig
{% if encore_entry_exists('react-blocks-js') %}
    {{ encore_entry_script_tags('react-blocks-js') }}
{% endif %}
```