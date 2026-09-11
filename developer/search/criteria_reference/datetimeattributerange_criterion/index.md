# DateTimeAttributeRange criterion

DateTimeAttributeRange Criterion

The [`DateTimeAttributeRange Search Criterion`](../../../../../../ibexa/product-catalog-date-time-attribute/src/contracts/Search/Criterion/DateTimeAttributeRange.php) searches for products by value of a specified attribute, which must be based on the [date and time attribute](../../../product_catalog/attributes/date_and_time/index.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `min` - lower range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.
- `max` - upper range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value greater than 2025-01-01.

```php
<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange;

$query = new ProductQuery();
$query->setFilter(new DateTimeAttributeRange('event_date', new DateTimeImmutable('2025-01-01')));
/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$results = $productService->findProducts($query);
```
