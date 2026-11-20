# FloatRangeAggregation

FloatRangeAggregation

The field-based [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\FloatRangeAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/FloatRangeAggregation.php) aggregates search results by the value of the Float field.

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
$query->aggregations[] = new Aggregation\Field\FloatRangeAggregation(
    'float',
    'product',
    'weight',
    [
    Range::ofFloat(null, 0.25),
    Range::ofFloat(0.25, 0.75),
    Range::ofFloat(0.75, null),
]
);
```
