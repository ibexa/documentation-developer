# SubtreeTermAggregation

The [SubtreeTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Location-SubtreeTermAggregation.html) aggregates search results by the Location's subtree path.

## Arguments

- `name` - name of the Aggregation object
- `pathString` - string representing the pathstring to aggregate results by

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Location\SubtreeTermAggregation('pathstring', '/1/2/');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
