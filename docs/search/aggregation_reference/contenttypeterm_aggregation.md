# ContentTypeTermAggregation

The [ContentTypeTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-ContentTypeTermAggregation.html) aggregates search results by the Content item's Content Type.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeTermAggregation('content_type');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
