# CreatedAtRange Criterion

The `CreatedAtRange` Search Criterion searches for products based on the date range when they were created.

## Arguments

- `min` - indicating the beginning of the date range, provided as a `DateTimeInterface` object
- `max` - indicating the end of the date range, provided as a `DateTimeInterface` object

## Example

``` php
$criteria = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CreatedAtRange(
    new \DateTimeImmutable('2020-07-10T00:00:00+00:00'),
    new \DateTimeImmutable('2023-07-12T00:00:00+00:00')
);

$productQuery = new ProductQuery(null, $criteria);
```
