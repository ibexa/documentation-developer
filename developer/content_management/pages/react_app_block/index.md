# React App block

Create a block that allows an editor to embed a preconfigured React component into a page.

Editions: Experience

React App block allows an editor to embed a preconfigured React application into a page. It's configured in YAML files, under the `ibexa_fieldtype_page` key. Page block configuration isn't SiteAccess-aware.

Another element of React App Block is `\Ibexa\FieldTypePage\FieldType\Page\Block\Event\Listener\ReactBlock` Listener which adds component and props variables.

It's common to all the blocks.

> **Caution: Clear the persistence cache**
>
> Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the page blocks, block attributes, validators or views configuration.
>
> To clear the persistence cache, run `php bin/console cache:pool:clear <cache-pool>` command. The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the [persistence cache configuration](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#what-is-cached), the name of your cache pool might be different.
>
> In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`. In dev mode, the Symfony cache is rebuilt automatically.

## React App Block configuration

React App blocks are regular [Page blocks](../page_blocks/index.md) and can be configured on field definition level as any other block. File has exactly the same structure as regular YAML [block configuration](../create_custom_page_block/index.md#configure-block), except:

- additional `component` attribute which binds Page Builder block with React App
- `views` attribute is removed

Each configured React app block has an identifier and the following settings:

| Setting      | Description                                                                                                                                                                                                                                                     |
| ------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `name`       | Name of the block used in the Page Builder interface. Also accepts a [`help` key](../page_blocks/index.md#block-name-and-help-text) that adds a helper text under the **Name** field in the block configuration form. |
| `category`   | Category in the Page Builder **Page blocks** toolbox that the block is shown in.                                                                                                                                                                                |
| `thumbnail`  | Thumbnail used in the Page Builder **Page blocks** toolbox.                                                                                                                                                                                                     |
| `component`  | React App Component name used in `assets/page-builder/react/blocks` directory.                                                                                                                                                                                  |
| `visible`    | (Optional) Toggles the block's visibility in the Page Builder **Page blocks** toolbox. Remove the block from the layout before you publish another version of the page.                                                                                         |
| `attributes` | (Optional) List of [block attributes](../page_block_attributes/index.md).                                                                                                                                     |

For example:

```yaml
ibexa_fieldtype_page:
    react_blocks:
        calculator:
            name: Calculator
            category: Demo
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#calendar
            component: Calculator
            attributes:
                a:
                    type: integer
                b: integer
```

Each entry below `react_blocks` adds one block to the Page Builder with the defined name, category and thumbnail. Both name and attributes support a short syntax and a long one for specifics.

`Attributes` defined without sub-keys use the key as the identifier and name, and the value as the type:

```yaml
attributes:
  b: integer
```

Sub-keys can be used to specify any of the usual [attributes configuration](../page_block_attributes/index.md) key:

```yaml
attributes:
  a:
    name: Attribute A
    type: string
    options:
      ...
```

Apps that are registered this way must be configured and referenced in the semantic configuration to be registered as blocks.

Parameters passed as props must be converted so that they can be used as the configured type in the app.

## Create React App block

In the following example, you learn how to create the `Calculator` React App block [configured in the previous section's example](#react-app-block-configuration).

### Configure React App Block

First, install React. Run `yarn add react` command.

Next, create a .jsx file which describes your component. You can place it in any location.

In the following example, create `Calculator.jsx` file in `assets/page-builder/components/` directory:

```js
import React from 'react';

export default function (props) {
    // a + b = ...
    console.log("Hello React!");
    return <div>{props.a} + {props.b} = {parseInt(props.a) + parseInt(props.b)}!</div>;
}
```

Then, create a `Calculator.js` file in `assets/page-builder/react/blocks` directory.

Files in this directory create a map of Components which then are imported to `react.blocks.js` file. As a result, the components are rendered on the page.

```js
import Calculator from '/assets/page-builder/components/Calculator';

export default {
    Calculator: Calculator,
};
```

Now, you should see new `Calculator` block in the Page Builder blocks list:

![Calculator](https://doc.ibexa.co/en/5.0/content_management/img/calculator.png "Calculator - React App Block")

Then, make sure that your [Page layout template](../../../templating/templates/template_configuration/index.md#page-layout) (like `templates/themes/standard/pagelayout.html.twig`) has the following Twig code in its `{% block javascripts %}`:

```twig
{% if encore_entry_exists('react-blocks-js') %}
    {{ encore_entry_script_tags('react-blocks-js') }}
{% endif %}
```
