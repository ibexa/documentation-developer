---
description: Score Sort Clause
---

# Score Sort Clause

The `Score` Sort Clause orders search results by their score.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `Score` Sort Clause isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Score()];
```
