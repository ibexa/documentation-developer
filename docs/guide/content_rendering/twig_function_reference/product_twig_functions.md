---
description: Product Twig functions enable getting products and their attributes in templates.
---

# Product Twig functions

Twig functions for rendering product Fields include `ses_render_field()`,
for rendering all Fields of a catalog element,
and three specific Twig functions for rendering price, stock, and specification Fields.

- [`ses_render_field()`](#ses_render_field) renders a Field of a product's Catalog element.
- [`ses_render_price()`](#ses_render_price) renders the price Field of a product.
- [`ses_render_stock()`](#ses_render_stock) renders the stock Field of a product.
- [`ses_render_specification_matrix()`](#ses_render_specification_matrix) renders the specification Field of a product.

You can also get the product objects by using the following Twig functions:

- [`ses_product()`](#ses_product) returns the product object, based on the provided parameters.
- [`ses_variant_product_by_sku()`](#ses_variant_product_by_sku) returns the `VariantProductNode` for a product, based on its SKU.

## Product field rendering

### `ses_render_field()`

`ses_render_field()` renders a Field of a product's Catalog element.

!!! note

    The function differs from [`ez_render_field()`](field_twig_functions.md#ez_render_field):
    you provide it with a Field from the `catalogElement` object,
    not a Field identifier from the Content Type definition.
    
| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`EshopBundle\Catalog\CatalogElement`|Catalog element of the product.|
|`fieldIdentifier`|`string`|Field of the Catalog element.|

``` html+twig
{{ ses_render_field(catalogElement, 'subtitle') }}
```

### `ses_render_price()`

`ses_render_price()` renders the price Field of a product.

| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`EshopBundle\Catalog\CatalogElement`|Catalog element of the product.|
|`field`|`EshopBundle\Content\Fields\PriceField`|Field of the Catalog element.|
|`params`|`array`||

``` html+twig
{{ ses_render_price(catalogElement, catalogElement.price) }}
```

### `ses_render_stock()`

`ses_render_stock()` renders the stock Field of a product.

| Argument | Type | Description |
|-----|-----|-----|
|`field`|`EshopBundle\Content\Fields\StockField`|Field of the Catalog element.|
|`params`|`array`||

``` html+twig
{{ ses_render_stock(catalogElement.stock) }}
```

### `ses_render_specification_matrix()`

`ses_render_specification_matrix()` renders the specification Field of a product Content item.

| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`EshopBundle\Catalog\CatalogElement`|Catalog element of the product.|
|`params`|`array`||

``` html+twig
{{ ses_render_specification_matrix(catalogElement) }}
```

## Product objects

### `ses_product()`

`ses_product()` returns the product object identified by the passed arguments.

Returns [OrderableProductNode](../../catalog/catalog_api/productnode.md) for products without variants,
or [OrderableVariantNode](../../catalog/product_variants/product_variant_api.md#orderablevariantnode)
for products with variants.

| Argument | Type | Description |
|-----|-----|-----|
|`params`|`array`|Array of parameters of the product to return.|

``` html+twig
{% set product = ses_product({'sku': 1234 }) %}
{% set product_with_variants = ses_product({'sku': 1234, 'variantCode': '1234bb' }) }}
```

### `ses_variant_product_by_sku()`

`ses_variant_product_by_sku()` returns the [VariantProductNode](../../catalog/product_variants/product_variant_api.md#variantproductnode) for a product based on its SKU.

| Argument | Type | Description |
|-----|-----|-----|
|`sky`|`string`|SKU of the product.|

``` html+twig
{% set product = ses_variant_product_by_sku(1234) }}
```
