# RawRangeAggregation

RawRangeAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\RawRangeAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/RawRangeAggregation.php) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field
- `ranges` - array of Range objects that define the borders of the specific range sets

## Limitations

> **Caution: Caution**
>
> To keep your project search engine independent, don't use the `RawRangeAggregation` Aggregation in production code. Valid use cases are: testing, or temporary (one-off) tools.

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$query = new LocationQuery();
$query->aggregations[] = new Aggregation\RawRangeAggregation('priority', 'priority_id', [
    Range::ofInt(1, 10),
    Range::ofInt(10, 100),
]);
```
