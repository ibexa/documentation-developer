---
description: Path Sort Clause
---

# Path Sort Clause

The `Location\Path` Sort Clause sorts search results by the pathString of the location.

!!! note

    Solr search engine uses dictionary sorting with the `Location/Path` Sort Clause.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Path()];
```
