---
description: Create a block that allows an editor to embed a preconfigured React application into a page.
---

# React App block

React App block allows an editor to embed a preconfigured React application into a page.
It is configured in YAML files, under the `ibexa_fieldtype_page` key.
Keep in mind that Page block configuration is not SiteAccess-aware.

Solution is based on `symfony/ux-react` package which allows to render React App with given name and properties
using Twig function.
See [Symfony UX React Documentation](https://symfony.com/bundles/ux-react/current/index.html) for more details.

React App block has additional source of the Page Builder block definitions which is `assets/blocks.json` file.
It is done by decorating `\Ibexa\FieldTypePage\FieldType\Page\Block\Definition\BlockDefinitionFactoryInterface` service.

Another element of React App Block is `\Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents::GLOBAL_BLOCK_RENDER_PRE` subscriber 
which expose `component_name` and `component_props` variables in block template for React App blocks.

[[% include 'snippets/page_block_cache_clear.md' %]]

## React App Block configuration

React App blocks are regular [Page blocks](page_blocks.md). and can be confirgured on field definition level as any other block.
File have exactly the same structure as regular YAML blocks configuration 
(see [Configure block](create_custom_page_block/#configure-block)), except:

- additional `component` property which binds Page Builder block with React App
- `configuration_template` and `views` properties are removed

Each configured React app block has an identifier and the following settings:

|Setting|Description|
|---|---|
| `name` | Name of the block used in the Page Builder interface. |
| `category` | Category in the Page Builder elements menu that the block is shown in. |
| `thumbnail` | Thumbnail used in the Page Builder elements menu. |
| `visible` | (Optional) Toggles the block's visibility in the Page Builder elements menu. Remove the block from the layout before you publish another version of the page. |
| `attributes` | (Optional) List of [block attributes](page_block_attributes.md). |

For example:

``` yaml
ibexa_fieldtype_page:
    react_blocks:
        calculator:
          name: Calculator (React)
          category: Demo
          thumbnail: /bundles/ibexaicons/img/all-icons.svg#date
          component: Calculator
          attributes:
            a:
              type: integer
            b: integer
    }
```

## Create React App block

In the following example you will learn how to create the new `Calculator` React App block.

### Configure React App Block

First, add the following `calculator.jsx` configuration in `/assets/react/controllers/` folder:

``` js
import React from 'react';

export default function (props) {
    // a + b = ...
    console.log("Hello React!");
    return <div>{props.a} * {props.b} = {parseInt(props.a) * parseInt(props.b)}!</div>;
}
```

Next, add `blocks.json` file in the `/assets/styles/` directory:

``` json
{
    "calculator": {
      "name": "Calculator (React)",
      "category": "Demo",
      "thumbnail": "/bundles/ibexaicons/img/all-icons.svg#date",
      "component": "Calculator",
      "attributes": {
        "a": {
          "type": "integer"
        },
        "b": {
          "type": "integer"
        }
      }
    }
  }
```