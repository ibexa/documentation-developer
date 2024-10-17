---
edition: experience
---

# Page field type

Page field type represents a page with a layout consisting of multiple zones.
Each zone can in turn contain blocks.

Page field type is only used in the page content type that is included in [[= product_name_exp =]].

| Name           | Internal name   | Expected input  |
|----------------|-----------------|-----------------|
| `Landing page` | `ezlandingpage` | `string (JSON)` |

!!! caution "Page Builder"

    If you create content type with both `ezlandingpage` and `ezuser` field types, you aren't redirected to Page Builder after selecting `Edit` or `Create`.
    This is caused by `ezuser` field type which requires separate handling.
    You're redirected to the standard back office edit or create mode.

## Layout and zones

Layout defines how a page is divided into zones.

The placement of zones is defined in a template which is a part of the layout configuration.
You can modify the template to define your own zone layout.

For information on how to create and configure new blocks for the page, see [Page layouts](render_page.md#render-a-layout).

## Blocks

For information on how to create and configure new blocks for the page, see [Create custom Page block](create_custom_page_block.md).

## Rendering pages

Page rendering takes place while editing or viewing.

When rendering a page, its zones are passed to the layout as a `zones` array with a `blocks` array each.
You can access them using twig (for example, `{{ zones[0].id }}` ).

Each div that's a zone should have the `data-ibexa-zone-id` attribute with zone ID as a value for a zone container.

To render a block inside the layout, use the Twig `render_esi()` function to call `Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction`.

The `renderAction` has the following parameters:

|Parameter|Description|
|---------|-----------|
|`locationId`|ID of the Location of the content item which can be accessed by `contentInfo.id`|
|`blockId`|ID of the block which you want to render.|
|`versionNo`|Version number of the content item to render.|
|`languageCode`|Language code of the content item to render.|

Example usage:

``` html+twig
{{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
    'locationId': locationId,
    'blockId': block.id,
    'versionNo': versionInfo.versionNo,
    'languageCode': field.languageCode
})) }}
```

As a whole a sample layout could look as follows:

``` html+twig
<div>
    {# The required attribute for the displayed zone #}
    <div data-ibexa-zone-id="{{ zones[0].id }}">
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}
            {# for each block #}
            {% for block in blocks %}
                {# create a new layer with appropriate ID #}
                <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
                    {# render the block by using the "Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction" controller #}
                    {# location.id is the ID of the Location of the current content item, block.id is the ID of the current block #}
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'locationId': locationId,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    })) }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```
