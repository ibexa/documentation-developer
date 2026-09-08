# Page field type

Editions: Experience

Page field type represents a page with a layout consisting of multiple zones. Each zone can in turn contain blocks.

Page field type is only used in the page content type that is included in Ibexa Experience.

| Name          | Internal name        | Expected input  |
| ------------- | -------------------- | --------------- |
| `LandingPage` | `ibexa_landing_page` | `string` (JSON) |

> **Caution: Page Builder**
>
> If you create content type with both `ibexa_landing_page` and `ibexa_user` field types, you aren't redirected to Page Builder after selecting `Edit` or `Create`. This is caused by `ibexa_user` field type which requires separate handling. You're redirected to the standard back office edit or create mode.

## Layout and zones

Layout defines how a page is divided into zones.

The placement of zones is defined in a template which is a part of the layout configuration. You can modify the template to define your own zone layout.

For information on how to create and configure new blocks for the page, see [Page layouts](../../../../templating/render_content/render_page/index.md#render-a-layout).

## Blocks

For information on how to create and configure new blocks for the page, see [Create custom Page block](../../../pages/create_custom_page_block/index.md).

## Rendering pages

Page rendering takes place while editing or viewing.

When rendering a page, its zones are passed to the layout as a `zones` array with a `blocks` array each. You can access them using twig (for example, `{{ zones[0].id }}` ).

Each div that's a zone should have the `data-ibexa-zone-id` attribute with zone ID as a value for a zone container.

To render a block inside the layout, use the Twig [`render_esi()`](https://symfony.com/doc/7.4/reference/twig_reference.html#render-esi) function to call `Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction`.

The `renderAction` has the following parameters:

| Parameter      | Description                                                                      |
| -------------- | -------------------------------------------------------------------------------- |
| `locationId`   | ID of the location of the content item which can be accessed by `contentInfo.id` |
| `blockId`      | ID of the block which you want to render.                                        |
| `versionNo`    | Version number of the content item to render.                                    |
| `languageCode` | Language code of the content item to render.                                     |

If your block needs to be dependent on query parameters like "page" and you already configured your custom block with a [`cacheable_query_params configuration`](../../../pages/page_blocks/index.md#block-configuration), pass [`ibexa_append_cacheable_query_params(block)`](../../../../templating/twig_function_reference/page_twig_functions/index.md#ibexa_append_cacheable_query_params) as the third argument to the [`controller()` Twig function](https://symfony.com/doc/7.4/reference/twig_reference.html#controller) so that the HTTP cache can vary based on those query parameters.

In a fresh installation, the feature is only used by the back office's [Dashboard blocks](../../../../../user/getting_started/dashboard/dashboard_block_reference/index.md): "My content" and "Review queue".

Example usage:

```html+twig
{{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
    'locationId': locationId,
    'blockId': block.id,
    'versionNo': versionInfo.versionNo,
    'languageCode': field.languageCode
}, ibexa_append_cacheable_query_params(block))) }}
```

As a whole a sample layout could look as follows:

```html+twig
<div>
    {# The required attribute for the displayed zone #}
    <div data-ibexa-zone-id="{{ zones[0].id }}">
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}
            {# for each block #}
            {% for block in blocks %}
                {# create a new layer with appropriate ID #}
                <div class="landing-page__block block_{{ block.type }}" data-ibexa-block-id="{{ block.id }}">
                    {# render the block by using the "Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction" controller #}
                    {# location.id is the ID of the Location of the current content item, block.id is the ID of the current block #}
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'locationId': locationId,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    }, ibexa_append_cacheable_query_params(block))) }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```
