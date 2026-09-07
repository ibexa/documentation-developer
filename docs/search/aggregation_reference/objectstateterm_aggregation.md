---
description: ObjectStateTermAggregation
---

# ObjectStateTermAggregation

The ObjectStateTermAggregation aggregates search results by the content item's object state.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the object state group to aggregate results by

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\ObjectStateTermAggregation('object_state', 'ibexa_lock');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
