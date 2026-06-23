---
description: DateTimeRangeAggregation
---

# DateTimeRangeAggregation

The field-based [DateTimeRangeAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-DateTimeRangeAggregation.html) aggregates search results by the value of the Date, DateTime, or Time field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\DateTimeRangeAggregation(
    'date',
    'event',
    'event_date',
    [
    Range::ofDateTime(null, new DateTime('2020-06-01')),
    Range::ofDateTime(new DateTime('2020-06-01'), new DateTime('2020-12-31')),
    Range::ofDateTime(new DateTime('2020-12-31'), null),
]
);
```
