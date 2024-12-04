---
description: ContentTypeGroupTermAggregation
---

# ContentTypeGroupTermAggregation

The [ContentTypeGroupTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-ContentTypeGroupTermAggregation.html) aggregates search results by the content item's content type group.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeGroupTermAggregation('content_type_group');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
