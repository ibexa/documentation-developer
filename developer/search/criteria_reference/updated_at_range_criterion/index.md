# UpdatedAtRange Criterion

UpdatedAtRange Search Criterion

The `UpdatedAtRange` Search Criterion searches for products based on the date range when they were last updated.

## Arguments

- `min` - the start of the date range (inclusive), provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST
- `max` - the end of the date range (inclusive), provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST

At least one of `min` or `max` must be provided.

## Example

### PHP

```php
<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAtRange;

$criteria = new UpdatedAtRange(
    new DateTimeImmutable('2020-07-10T00:00:00+00:00'),
    new DateTimeImmutable('2023-07-12T00:00:00+00:00'),
);

/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$productQuery = new ProductQuery();
$productQuery->setQuery($criteria);
$results = $productService->findProducts($productQuery);
```

### REST API

**XML**

```xml
<ProductQuery>
    <Filter>
        <UpdatedAtRangeCriterion>
            <min>2023-06-12</min>
            <max>2023-06-20</max>
        </UpdatedAtRangeCriterion>
    </Filter>
</ProductQuery>
```

**JSON**

```json
{
  "ProductQuery": {
    "Filter": {
      "UpdatedAtRangeCriterion": {
        "min": "2023-06-12",
        "max": "2023-06-20"
      }
    }
  }
}
```
