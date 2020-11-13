# ContentTypeTermAggregation

The [ContentTypeTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/ContentTypeTermAggregation.php) aggregates search results by the Content item's Content Type.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeTermAggregation('content_type');
```
