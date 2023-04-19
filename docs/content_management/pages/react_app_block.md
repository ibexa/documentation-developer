---
description: Create a block that allows an editor to embed a preconfigured React component into a page.
---

# React App block

React App block allows an editor to embed a preconfigured React application into a page.
It is configured in YAML files, under the `ibexa_fieldtype_page` key.
Page block configuration is not SiteAccess-aware.

Another element of React App Block is `\Ibexa\FieldTypePage\FieldType\Page\Block\Event\Listener\ReactBlock` Listener 
which adds component and props variables.

It is general for all the blocks.

[[% include 'snippets/page_block_cache_clear.md' %]]

## React App Block configuration

React App blocks are regular [Page blocks](page_blocks.md) and can be confirgured on field definition level as any other block.
File has exactly the same structure as regular YAML [block configuration](create_custom_page_block/#configure-block), except:

- additional `component` attribute which binds Page Builder block with React App
- `views` attribute is removed

Each configured React app block has an identifier and the following settings:

|Setting|Description|
|---|---|
| `name` | Name of the block used in the Page Builder interface. It has to be the same as Component name used in `/page-builder/react/blocks` directory.|
| `category` | Category in the Page Builder elements menu that the block is shown in. |
| `thumbnail` | Thumbnail used in the Page Builder elements menu. |
| `visible` | (Optional) Toggles the block's visibility in the Page Builder elements menu. Remove the block from the layout before you publish another version of the page. |
| `attributes` | (Optional) List of [block attributes](page_block_attributes.md). |

For example:

``` yaml
ibexa_fieldtype_page:
    react_blocks:
        calculator:
          name: Calculator
          category: Demo
          thumbnail: /bundles/ibexaicons/img/all-icons.svg#date
          component: Calculator
          attributes:
            a:
              type: integer
            b: integer
    }
```

Each entry below `react_blocks` adds one block to the Page Builder with the defined name, category and thumbnail.
Both name and attributes support a short syntax and a long one for specifics.

`Attributes` defined without sub-keys use the key as the identifier and name, and the value as the type:

```
attributes:
  b: integer
```

Sub-keys can be used to specify any of the usual [attributes configuration](page_block_attributes/#page-block-attributes) key:

```
attributes:
  a:
    name: Attribute A
    type: string
    options:
      ...
```

The `assets/apps.js` file is pre-configured with this path.

Apps that are registered this way must be configured and referenced in the 
semantic configuration to be registered as blocks.

Apps that are used as blocks are defined by default in `react/controllers` direction.

Parameters passed as props must be converted so that they can be used as the configured type in the app.

## Create React App block

In the following example you will learn how to create `Calculator` React App block.

### Configure React App Block

First, create a .jsx file which describes your component.
You can create the file at any location.

In the following example, create `Calculator.jsx` file in `../../../page-builder/components/` directory:

``` js
import React from 'react';

export default function (props) {
    // a + b = ...
    console.log("Hello React!");
    return <div>{props.a} * {props.b} = {parseInt(props.a) * parseInt(props.b)}!</div>;
}
```

Then, create a .js file in `/page-builder/react/blocks` directory.

Files in this directory create a map of Components which then are imported to `react.blocks.js` file.
As a result, the components are rendered on the page. 

``` js
import Calculator from "../../../page-builder/components/Calculator";

export default {
    Calculator: Calculator,
};
```

Now, you should see new `Calculator` block in the Page Builder blocks list:

![Calculator](calculator.png "Calculator - React App Block")