---
description: Customize the templates used to render products embedded in RichText fields.
month_change: true
---

# Customize product embed templates

When a product is [embedded in a RichText field](products.md#embed-products-in-content), it is rendered using a Twig template.
You can override the default templates to customize the appearance of embedded products.

## Embed types

Six embed types exist in the system, each with its own template:

| Embed type | Description |
| --- | --- |
| `product` | Block-level embed when the product is found and the user has access. |
| `product_inline` | Inline embed when the product is found and the user has access. |
| `product_denied` | Block-level embed when the user has no access to view the product data. |
| `product_inline_denied` | Inline embed when the user has no access to view the product data. |
| `product_not_found` | Block-level embed when the product code cannot be found. |
| `product_inline_not_found` | Inline embed when the product code cannot be found. |

## Template variables

The following variables are available in the embed templates:

| Variable | Available in | Description |
|---|---|---|
| `product` | `product`, `product_inline` | A [`ProductInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html) object. |
| <nobr>`productCode`</nobr> | `product_denied`, `product_inline_denied`, `product_not_found`, `product_inline_not_found` | The product code string, used to identify the product that could not be loaded. |
| <nobr>`embedParams`</nobr> | All block types | Optional parameters set by the online editor, for example `align` or `class` properties |

## Override a template

The default templates are located in `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/standard/product_catalog/richtext/embed/`.

To override a template, create a file with the same name in your [theme directory](design_engine.md).
For example, to override the block embed template for the `standard` theme, create  a file in `templates/themes/standard/product_catalog/richtext/embed/product.html.twig`

A minimal product embed template looks as follows:

```html+twig
<div class="my-product-embed{% if embedParams.align is defined %} align-{{ embedParams.align }}{% endif %}{% if embedParams.class is defined %} {{ embedParams.class }}{% endif %}">
    <span class="my-product-embed__name">{{ product.name }}</span>
</div>
```

And a minimal inline embed template (`product_inline.html.twig`):

```html+twig
<span class="my-product-embed-inline{% if embedParams.class is defined %} {{ embedParams.class }}{% endif %}">{{ product.name }}</span>
```

## Configure template paths

In addition to overriding the templates with [Design engine](design_engine.md), you can explicitly set the template path for any embed type in your [SiteAccess configuration](multisite_configuration.md):

```yaml
ibexa:
    system:
        <siteaccess>:
            fieldtypes:
                ibexa_richtext:
                    embed:
                        product:
                            template: '@ibexadesign/product_catalog/richtext/embed/product.html.twig'
                        product_inline:
                            template: '@ibexadesign/product_catalog/richtext/embed/product_inline.html.twig'
                        product_denied:
                            template: '@ibexadesign/product_catalog/richtext/embed/product_denied.html.twig'
                        product_inline_denied:
                            template: '@ibexadesign/product_catalog/richtext/embed/product_inline_denied.html.twig'
                        product_not_found:
                            template: '@ibexadesign/product_catalog/richtext/embed/product_not_found.html.twig'
                        product_inline_not_found:
                            template: '@ibexadesign/product_catalog/richtext/embed/product_inline_not_found.html.twig'
```

Replace `<siteaccess>` with the name of your SiteAccess or SiteAccess group (for example, `default`).
