---
description: Prepare templates for rendering products from the catalog.
---

# Render a product

To customize the template for a product, first, you need to prepare a content view configuration.

[[% include 'snippets/catalog_permissions_note.md' %]]

To match all products, you can use the [`ProductBased\IsProduct`](view_matcher_reference.md#productbasedisproduct) view matcher.

``` yaml
[[= include_file('code_samples/front/shop/render_product/config/packages/views.yaml') =]]
```

This matching applies to Content items that are also products.

This enables you to access both content properties and product properties in the template.
You can use the `ibexa_get_product` Twig filter to get the product object from a Content item:

``` html+twig
[[= include_file('code_samples/front/shop/render_product/templates/full/product.html.twig', 0, 4) =]]
```

## Attributes

You can access all attributes of a product with `product.attributes`:

``` html+twig
[[= include_file('code_samples/front/shop/render_product/templates/full/product.html.twig', 19, 24) =]]
```

The [`ibexa_format_product_attribute`](product_twig_functions.md#ibexaformatproductattribute) filter formats the attributes, including number formatting.
For example, it renders human-readable labels instead of identifiers and applies correct decimal digit separators for the locale.

## Price

You can access the product's price information from the product object:

``` html+twig
[[= include_file('code_samples/front/shop/render_product/templates/full/product.html.twig', 9, 10) =]]
```

## Add to basket [[% include 'snippets/commerce_badge.md' %]]

The `ibexa.commerce.basket.add` route enables you to create an "Add to basket" button.
To make the button fully functional, you must first configure all necessary information for the product, otherwise the product will not be added to basket.
See [Enable purchasing products](enable_purchasing_products.md) for more information.

``` html+twig
[[= include_file('code_samples/front/shop/render_product/templates/full/product.html.twig', 11, 17) =]]
```
