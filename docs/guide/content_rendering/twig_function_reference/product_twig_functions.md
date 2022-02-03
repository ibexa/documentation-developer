# Product Twig functions

Twig functions for rendering product Fields include `ibexa_commerce_render_field()`,
for rendering all Fields of a catalog element,
and three specific Twig functions for rendering price, stock, and specification Fields.

- [`ibexa_commerce_render_field()`](#ibexa_commerce_render_field) renders a Field of a product's Catalog element.
- [`ibexa_commerce_render_price()`](#ibexa_commerce_render_price) renders the price Field of a product.
- [`ibexa_commerce_render_stock()`](#ibexa_commerce_render_stock) renders the stock Field of a product.
- [`ibexa_commerce_render_specification_matrix()`](#ibexa_commerce_render_specification_matrix) renders the specification Field of a product.

You can also get the product objects by using the following Twig functions:

- [`ibexa_commerce_product()`](#ibexa_commerce_product) returns the product object, based on the provided parameters.
- [`ibexa_commerce_variant_product_by_sku()`](#ibexa_commerce_variant_product_by_sku) returns the `VariantProductNode` for a product, based on its SKU.

## Product field rendering

### `ibexa_commerce_render_field()`

`ibexa_commerce_render_field()` renders a Field of a product's Catalog element.

!!! note

    The function differs from [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field):
    you provide it with a Field from the `catalogElement` object,
    not a Field identifier from the Content Type definition.
    
| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`Ibexa\Bundle\Commerce\Eshop\Catalog\CatalogElement`|Catalog element of the product.|
|`fieldIdentifier`|`string`|Field of the Catalog element.|

``` html+twig
{{ ibexa_commerce_render_field(catalogElement, 'subtitle') }}
```

### `ibexa_commerce_render_price()`

`ibexa_commerce_render_price()` renders the price Field of a product.

| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`Ibexa\Bundle\Commerce\Eshop\Catalog\CatalogElement`|Catalog element of the product.|
|`field`|`Ibexa\Bundle\Commerce\Eshop\Content\Fields\PriceField`|Field of the Catalog element.|
|`params`|`array`||

``` html+twig
{{ ibexa_commerce_render_price(catalogElement, catalogElement.price) }}
```

### `ibexa_commerce_render_stock()`

`ibexa_commerce_render_stock()` renders the stock Field of a product.

| Argument | Type | Description |
|-----|-----|-----|
|`field`|`Ibexa\Bundle\Commerce\Eshop\Content\Fields\StockField`|Field of the Catalog element.|
|`params`|`array`||

``` html+twig
{{ ibexa_commerce_render_stock(catalogElement.stock) }}
```

### `ibexa_commerce_render_specification_matrix()`

`ibexa_commerce_render_specification_matrix()` renders the specification Field of a product Content item.

| Argument | Type | Description |
|-----|-----|-----|
|`catalogElement`|`Ibexa\Bundle\Commerce\Eshop\Catalog\CatalogElement`|Catalog element of the product.|
|`params`|`array`||

``` html+twig
{{ ibexa_commerce_render_specification_matrix(catalogElement) }}
```

## Product objects

### `ibexa_commerce_product()`

`ibexa_commerce_product()` returns the product object identified by the passed arguments.

| Argument | Type | Description |
|-----|-----|-----|
|`params`|`array`|Array of parameters of the product to return.|

``` html+twig
{% set product = ibexa_commerce_product({'sku': 1234 }) %}
```
