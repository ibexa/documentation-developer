---
description: Use blocks to customize the content of a Page with dynamic content.
---

# Page blocks

Page blocks are configured in YAML files, under the `ibexa_fieldtype_page` key.

!!! caution

    Page block configuration is not SiteAccess-aware.

!!! tip

    For information on how to create and configure new layouts for the Page,
    see [Page layouts](render_page.md#render-a-layout).

## Block configuration

Each configured block has an identifier and the following settings:

|Setting|Description|
|---|---|
| `name` | Name of the block used in the Page Builder interface. |
| `category` | Category in the Page Builder elements menu that the block is shown in. |
| `thumbnail` | Thumbnail used in the Page Builder elements menu. |
| `views` | Available [templates for the block](#block-templates). |
| `visible` | (Optional) Toggles the block's visibility in the Page Builder elements menu. Remove the block from the layout before you publish another version of the page. |
| `configuration_template` | (Optional) Template for the block settings modal. |
| `attributes` | (Optional) List of [block attributes](page_block_attributes.md). |

For example:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 12) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 16, 17) =]]# ...
```

!!! tip

    For a full example of block configuration, see [Create custom Page block](create_custom_page_block.md).

### Overwriting existing blocks

You can overwrite the following properties in the existing blocks:

- `name`
- `category`
- `thumbnail`
- `views`

## Block templates

Page blocks can have multiple templates.
This allows you to create different styles for each block and let the editor choose them when adding the block from the UI.

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 3) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 7, 16) =]]
```

`priority` defines the order of block views on the block configuration screen.
The highest number shows first on the list.

!!! tip

    Default views have a `priority` of -255.
    It is good practice to keep the value between -255 and 255.

### Block modal template

The template for the configuration modal of built-in Page blocks is contained in
`vendor/ibexa/page-builder/src/bundle/Resources/views/page_builder/block/config.html.twig`.

You can override it by using the `configuration_template` setting:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 7) =]]
```

The template can extend the default `config.html.twig` and modify its blocks.
Blocks `basic_tab_content` and `design_tab_content` correspond to the **Basic** and **Design** tabs in the modal.

The following example wraps all form fields for block attributes in an ordered list:

``` html+twig
[[= include_file('code_samples/page/custom_page_block/templates/themes/standard/blocks/event/config.html.twig') =]]
```

## Block events

To add functionalities to your block that go beyond the available attributes,
you can use an event listener.

You can listen to events related to block definition and block rendering.

The following events are available:

- `BlockDefinitionEvents::getBlockDefinitionEventName` - dispatched when block definition is created
- `BlockDefinitionEvents::getBlockAttributeDefinitionEventName` - dispatched when block attribute definition is created
- `BlockRenderEvents::getBlockPreRenderEventName` - dispatched before a block is rendered
- `BlockRenderEvents::getBlockPostRenderEventName` - dispatched after a block is rendered

For example, to modify a block by adding a new parameter to it, you can create the following listener:

``` php
[[= include_file('code_samples/page/page_listener/src/Block/Listener/MyBlockListener.php') =]]
```

Before the block is rendered, the listener adds `my_parameter` to it with value `parameter_value`.
You can use this parameter, for example, in block template:

``` html+twig
[[= include_file('code_samples/page/page_listener/templates/my_block.html.twig') =]]
```

#### Exposing content relations from blocks

Page blocks, for example Embed block or Collection block, can embed other Content items.
Publishing a Page with such blocks creates Relations to those Content items.

When creating a custom block with embeds, you can ensure such Relations are created using the block Relation collection event.

The event is dispatched on content publication.
You can hook your event listener to the `BlockRelationEvents::getCollectBlockRelationsEventName` event.

To expose relations, pass an array containing Content IDs to the `Ibexa\FieldTypePage\Event\CollectBlockRelationsEvent::setRelations()` method.
If embedded Content changes, old Relations are removed automatically.

Providing Relations also invalidates HTTP cache for your block response in one of the related Content items changes.
