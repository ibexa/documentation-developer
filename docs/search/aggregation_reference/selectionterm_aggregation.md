---
description: SelectionTermAggregation
---

# SelectionTermAggregation

The field-based SelectionTermAggregation aggregates search results by the value of the Selection field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\SelectionTermAggregation('selection', 'article', 'select');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
