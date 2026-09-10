# UserMetadataTermAggregation

UserMetadataTermAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\UserMetadataTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/UserMetadataTermAggregation.php) aggregates search results by the User content item's metadata.

## Arguments

- `name` - name of the Aggregation object

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\UserMetadataTermAggregation('user_metadata');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
