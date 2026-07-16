---
description: ProductAvailabilityTerm
---

# ProductAvailabilityTerm

The ProductAvailabilityTermAggregation aggregates search results by product availability (available/unavailable).

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\ProductAvailabilityTermAggregation;

$query = new ProductQuery();
$query->setAggregations([
    new ProductAvailabilityTermAggregation('product_availability'),
]);
```
