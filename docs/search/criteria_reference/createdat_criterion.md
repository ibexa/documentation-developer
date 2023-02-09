# CreatedAt Criterion

The `CreatedAt` Search Criterion searches for products based on the date when they were created.

## Arguments

- `createdAt` - indicating the date that should be matched, provided as a `DateTimeInterface` object
- `operator` - Operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CreatedAt(
    '2022-07-11T00:00:00+02:00'
    Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator::GTE,
);

$productQuery = new ProductQuery(null, $criteria);
```
