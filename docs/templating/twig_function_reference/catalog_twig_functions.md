---
description: Catalog Twig functions enable getting and rendering certain catalog information and listing filter templates.
---

# Catalog Twig functions

With the catalog Twig functions you can get catalog location, render catalog status and list filter templates.

### `ibexa_get_filter_preview_templates`

The `ibexa_get_filter_preview_templates()` function gets a list of filter preview Twig templates 
(configured in `ibexa.repositories.product_catalog.filter_preview_templates`). 
Thjen it sorts the list by priority and renders the filter templates.

``` html+twig
        {% for template in ibexa_get_filter_preview_templates() %}
            {% if block(block_name, template) is defined %}
                {{ block(block_name, template) }}

                {% set block_found = true %}
            {% endif %}
        {% endfor %}
```

### `ibexa_get_product_catalog_root`

The `ibexa_get_product_catalog_root()` function gets an ID of a location of the product catalog (configured in `ibexa_product_catalog.engines.default.type.options.root_location_remote_id`).


``` html+twig
{% set product_catalog_root_id = ibexa_get_product_catalog_root() %}

{% set product_catalog_root = location(product_catalog_root_id) %}

    /// Perform operations on the product catalog 
```

### `ibexa_render_catalog_status`

The `ibexa_render_catalog_status` filter renders the status of the catalog, translated into the current language.

#### Examples

``` html+twig
{% set status_code = content.contentInfo.status %}
{% set status_label = status_code|ibexa_render_catalog_status %}

<span>{{ status_label }}</span>
```
