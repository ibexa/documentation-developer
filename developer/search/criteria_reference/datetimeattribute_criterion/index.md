# DateTimeAttribute criterion

DateTimeAttribute Criterion

The [`DateTimeAttribute Search Criterion`](../../../../../../ibexa/product-catalog-date-time-attribute/src/contracts/Search/Criterion/DateTimeAttribute.php) searches for products by value of a specified attribute, based on the [date and time attribute](../../../product_catalog/attributes/date_and_time/index.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `value` - searched value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php))

## Operators

The following operators are supported:

- [FieldValueCriterion::COMPARISON_EQ](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)
- [FieldValueCriterion::COMPARISON_NEQ](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)
- [FieldValueCriterion::COMPARISON_LT](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)
- [FieldValueCriterion::COMPARISON_LTE](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)
- [FieldValueCriterion::COMPARISON_GT](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)
- [FieldValueCriterion::COMPARISON_GTE](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php)

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value equal to 2025-07-06.

```php
<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttribute;

$query = new ProductQuery();
$filter = new DateTimeAttribute('event_date', new DateTimeImmutable('2025-07-06'));
$filter->setOperator(FieldValueCriterion::COMPARISON_EQ);
$query->setFilter($filter);
/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$results = $productService->findProducts($query);
```
