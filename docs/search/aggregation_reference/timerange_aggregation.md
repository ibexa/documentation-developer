---
description: TimeRangeAggregation
---

# TimeRangeAggregation

The field-based [TimeRangeAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-TimeRangeAggregation.html) aggregates search results by the value of the Date, DateTime, or Time field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$timestamp = mktime(14, 0, 0);
if ($timestamp === false) {
    throw new RuntimeException('Failed to create timestamp with mktime.');
}

$query = new Query();
$query->aggregations[] = new Aggregation\Field\TimeRangeAggregation(
    'date',
    'event',
    'event_time',
    [
    Range::ofInt(null, $timestamp),
    Range::ofInt($timestamp, null),
]
);
```
