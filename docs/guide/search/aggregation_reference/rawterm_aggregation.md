# RawTermAggregation

The [RawTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/RawTermAggregation.php) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\RawTermAggregation('content_per_content_type', 'content_type_id_id');
```
