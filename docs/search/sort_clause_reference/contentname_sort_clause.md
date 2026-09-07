---
description: ContentName Sort Clause
---

# ContentName Sort Clause

The `ContentName` Sort Clause sorts search results by the content items' names.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentName()];
```
