# DateTimeRangeAggregation

DateTimeRangeAggregation

The field-based [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\DateTimeRangeAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/DateTimeRangeAggregation.php) aggregates search results by the value of the Date, DateTime, or Time field.

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
