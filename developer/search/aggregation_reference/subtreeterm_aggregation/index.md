# SubtreeTermAggregation

SubtreeTermAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Location\SubtreeTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Location/SubtreeTermAggregation.php) aggregates search results by the location's subtree path.

## Arguments

- `name` - name of the Aggregation object
- `pathString` - string representing the pathstring to aggregate results by

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\Location\SubtreeTermAggregation('pathstring', '/1/2/');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
