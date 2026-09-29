# LocationChildrenTermAggregation

LocationChildrenTermAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Location\LocationChildrenTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Location/LocationChildrenTermAggregation.php) aggregates search results by the number of children of a location.

## Arguments

- `name` - name of the Aggregation object

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new LocationQuery();
$query->aggregations[] = new Aggregation\Location\LocationChildrenTermAggregation('location_children');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
