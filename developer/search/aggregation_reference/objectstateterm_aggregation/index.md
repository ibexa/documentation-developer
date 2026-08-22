# ObjectStateTermAggregation

ObjectStateTermAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\ObjectStateTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/ObjectStateTermAggregation.php) aggregates search results by the content item's object state.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the object state group to aggregate results by

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\ObjectStateTermAggregation('object_state', 'ibexa_lock');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
