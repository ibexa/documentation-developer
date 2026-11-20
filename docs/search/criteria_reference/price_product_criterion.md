---
description: Price Product Search Criterion
---

# Price Product Criterion

The `Product` Search Criterion searches for prices based on product codes.

## Arguments

- `product_code` - a string that represents a product code or an array of codes

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Product;

$query = new PriceQuery(
    new Product('ergo_desk')
);
```
