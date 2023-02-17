---
description: Catalog Twig functions enable getting and rendering certain catalog information and listing filter templates.
---

# Catalog Twig functions

With the catalog Twig functions you can get catalog location, render catalog status and list filter templates.

### `ibexa_get_product_catalog_root`

The `ibexa_get_product_catalog_root()` function gets a root location of the product catalog (configured in `ibexa_product_catalog.engines.default.type.options.root_location_remote_id`).


``` html+twig
{{ ibexa_url(ibexa_get_product_catalog_root()) }}
```

### `ibexa_render_catalog_status`

The `ibexa_render_catalog_status` filter renders the status of the catalog, translated into the current language.

#### Examples

``` html+twig
{% import "@ibexadesign/product_catalog/catalog_macros.html.twig" as catalog_macros %}
{{ catalog_macros.status_node(catalog.status) }}
```
