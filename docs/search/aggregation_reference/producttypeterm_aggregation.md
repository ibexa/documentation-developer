---
description: ProductTypeTerm
---

# ProductTypeTerm

The ProductTypeTermAggregation aggregates search results by the product type.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\ProductTypeTermAggregation;

$query = new ProductQuery();
$query->setAggregations([
    new ProductTypeTermAggregation('product_type'),
]);
```
