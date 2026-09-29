# UpdatedAt Criterion

UpdatedAt Search Criterion

The `UpdatedAt` Search Criterion searches for products based on the date when they were last updated.

## Arguments

- `date` - indicating the date that should be matched, provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST
- `operator` - Operator constant (EQ, GT, GTE, LT, LTE) in PHP or its value in REST

## Operators

| Operator                                                                                                                                                                      | Value | Description                                                  |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----- | ------------------------------------------------------------ |
| [`Operator::EQ`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/Operator.php)   | `=`   | Matches products updated exactly on the given date (default) |
| [`Operator::GT`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/Operator.php)   | `>`   | Matches products updated after the given date                |
| [`Operator::GTE`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/Operator.php) | `>=`  | Matches products updated on or after the given date          |
| [`Operator::LT`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/Operator.php)   | `<`   | Matches products updated before the given date               |
| [`Operator::LTE`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/Operator.php) | `<=`  | Matches products updated on or before the given date         |

## Example

### PHP

```php
<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAt;

$criteria = new UpdatedAt(
    new DateTimeImmutable('2023-03-01'),
    Operator::GTE,
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
        <UpdatedAtCriterion>
            <updated_at>2023-06-12</updated_at>
            <operator>>=</operator>
        </UpdatedAtCriterion>
    </Filter>
</ProductQuery>
```

**JSON**

```json
{
  "ProductQuery": {
    "Filter": {
      "UpdatedAtCriterion": {
        "updated_at": "2023-06-12",
        "operator": ">="
      }
    }
  }
}
```
