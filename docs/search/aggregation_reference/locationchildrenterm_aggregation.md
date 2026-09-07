---
description: LocationChildrenTermAggregation
---

# LocationChildrenTermAggregation

The LocationChildrenTermAggregation aggregates search results by the number of children of a location.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new LocationQuery();
$query->aggregations[] = new Aggregation\Location\LocationChildrenTermAggregation('location_children');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
