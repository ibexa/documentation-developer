# TimeRangeAggregation

TimeRangeAggregation

The field-based [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\TimeRangeAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/TimeRangeAggregation.php) aggregates search results by the value of the Date, DateTime, or Time field.

## Arguments

- `name` - name of the Aggregation
- `contentTypeIdentifier` - string representing the content type identifier
- `fieldDefinitionIdentifier` - string representing the Field Definition identifier
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

```php
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
