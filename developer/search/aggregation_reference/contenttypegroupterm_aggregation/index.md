# ContentTypeGroupTermAggregation

ContentTypeGroupTermAggregation

The [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\ContentTypeGroupTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/ContentTypeGroupTermAggregation.php) aggregates search results by the content item's content type group.

## Arguments

- `name` - name of the Aggregation object

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeGroupTermAggregation('content_type_group');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
