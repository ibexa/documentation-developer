# Page Twig functions

Page field and page block Twig functions provide access to configuration.

Editions: Experience

## `ibexa_append_cacheable_query_params()`

Get the query parameters of a page block as [configured in `cacheable_query_params`](../../../content_management/pages/page_blocks/index.md#block-configuration). If the block type has no configured query parameters, an empty array is returned.

```twig
{{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
    'locationId': locationId,
    'blockId': block.id,
    'versionNo': versionInfo.versionNo,
    'languageCode': field.languageCode
}, ibexa_append_cacheable_query_params(block))) }}
```

## `ibexa_page_layout()`

Get the layout template of a landing page.

```twig
{% include ibexa_page_layout(page) with {'zones': page.zones} %}
```

It can be used to render a [page field](../../../content_management/field_types/field_type_reference/pagefield/index.md). For an example, you can look at how the default `vendor/ibexa/fieldtype-page/src/bundle/Resources/views/fields/ibexa_landing_page.html.twig` uses it.
