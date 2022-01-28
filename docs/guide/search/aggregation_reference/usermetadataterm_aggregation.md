# UserMetadataTermAggregation

The [UserMetadataTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/UserMetadataTermAggregation.php) aggregates search results by the User Content item's metadata.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\UserMetadataTermAggregation('user_metadata');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
