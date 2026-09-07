---
description: Depth Sort Clause
---

# Depth Sort Clause

The `Location\Depth` Sort Clause sorts search results by the depth of the location in the content tree.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Depth()];
```
