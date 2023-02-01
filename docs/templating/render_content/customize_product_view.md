---
description: Customize templates for rendering products from the catalog.
edition: commerce
---

# Customize product view

The built-in storefront offers a set of templates covering all functionalities of a shop,
divided into smaller components.

To customize your shop, you can override either whole templates, or specific components.

The built-in templates belong to the `storefront` [theme](design_engine.md).

To override any of them, copy its directory structure in your template directory.

[[% include 'snippets/catalog_permissions_note.md' %]]

## Template customization example

As an example, to modify the template used to display the product price,
you need to override [`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/storefront/component/price/price.html.twig`](https://github.com/ibexa/storefront/blob/v4.4.0/src/bundle/Resources/views/themes/storefront/storefront/component/price/price.html.twig) template.

To do it, create your own template in `templates/themes/storefront/storefront/component/price/price.html.twig` file:

``` html+twig hl_lines="10-12"
{% trans_default_domain 'storefront' %}

{% set price = product.price %}

{% if price is not null %}
    <div class="ibexa-store-price">
        {{ 'ibexa_storefront.product_card.price.title'|trans({ '%price%': price })|desc('your price %price%') }}
    </div>
{% else %}
    <div class="ibexa-store-price">
        {{ 'ibexa_storefront.product_card.price.unavailable'|trans()|desc('price currently unavailable') }}
    </div>
{% endif %}
```

This template adds a label when a product does not have a price specified.

## Available templates

All the storefront templates are located in `vendor/ibexa/storefront/src/bundle/Resources/view/themes/storefront`.

The most important templates related to product rendering are:

|Template|Component|
|---|---|
|`storefront/catalog.html.twig`|main catalog and category view|
|`storefront/component/product_view.html.twig`|full-screen view of a single product|

### Single product view

|Template|Component|
|---|---|
|`storefront/component/product_assets.html.twig`|image asset preview and thumbnail list|
|`storefront/component/product_attributes.html.twig`|listing of product attributes|

### Product list

|Template|Component|
|---|---|
|`storefront/component/product_grid.html.twig`|grid for presenting products in the catalog|
|`storefront/component/product_search_filters.html.twig`|panel with search filters|
|`storefront/component/product_search_query.html.twig`|search box|
|`storefront/component/product_search_sort.html.twig`|sorting drop-down|

!!! tip

    For templates related to general storefront layout, cart and checkout, see [Customize storefront layout](customize_storefront_layout.md#available-templates).
