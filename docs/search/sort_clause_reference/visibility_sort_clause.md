---
description: Visibility Sort Clause
---

# Visibility Sort Clause

The `Location\Visibility` Sort Clause sorts search results by whether the location is visible or not.

Locations that aren't visible are ranked as higher values (for example, with ascending order they're returned last).

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Visibility()];
```
