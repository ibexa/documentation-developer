---
description: Price Product Criterion
---

# Price Product Criterion

The `Product` Search Criterion searches for prices based on product codes.

## Arguments

- `product_code` - a string that represents a product code or an array of codes

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Product('ergo_desk')
);
```
