# UserMetadataTermAggregation

The [UserMetadataTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-UserMetadataTermAggregation.html) aggregates search results by the User Content item's metadata.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\UserMetadataTermAggregation('user_metadata');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
