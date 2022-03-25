# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by their availability.

## Arguments

- `available` - bool representing whether the product is available.

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductAvailability(true);
```
