---
description: Price Product Criterion
---

# Price Product Criterion

The `Product` Search Criterion searches for prices based on the product code.

## Arguments

- `product_code` - a string that represents a product code

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Product('ergo_desk')
);
```
