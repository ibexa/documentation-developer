# DateMetadataRangeAggregation

DateMetadataRangeAggregation

The [DateMetadataRangeAggregation](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/CountryTermAggregation.php) aggregates search results by the value of the content items' date metadata.

## Arguments

- `name` - name of the Aggregation object
- `type` - string representing the type of the Aggregation (`MODIFIED` or `PUBLISHED`)
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$query = new Query();
$query->aggregations[] = new Aggregation\DateMetadataRangeAggregation(
    'date_metadata',
    Aggregation\DateMetadataRangeAggregation::PUBLISHED,
    [
        Range::ofDateTime(null, new DateTime('2020-06-01')),
        Range::ofDateTime(new DateTime('2020-06-01'), new DateTime('2020-12-31')),
        Range::ofDateTime(new DateTime('2020-12-31'), null),
    ]
);
```
