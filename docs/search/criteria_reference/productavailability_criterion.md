# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by their availability.

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductAvailability(true);
```
