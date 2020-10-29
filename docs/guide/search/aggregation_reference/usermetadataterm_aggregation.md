# UserMetadataTermAggregation

The [UserMetadataTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/UserMetadataTermAggregation.php) aggregates search results by the User Content item's metadata.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
query->aggregations[] = new Aggregation\UserMetadataTermAggregation('user_metadata');
```
