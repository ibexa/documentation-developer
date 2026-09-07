---
description: SectionName Sort Clause
---

# SectionName Sort Clause

The `SectionName` Sort Clause sorts search results by the Section name of the content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\SectionName()];
```
