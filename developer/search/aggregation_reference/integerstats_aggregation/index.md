# IntegerStatsAggregation

IntegerStatsAggregation

The field-based [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\IntegerStatsAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/IntegerStatsAggregation.php) aggregates search results by the value of the Integer field and provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation
- `contentTypeIdentifier` - string representing the content type identifier
- `fieldDefinitionIdentifier` - string representing the Field Definition identifier

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\IntegerStatsAggregation('integer', 'product', 'amount');
```
