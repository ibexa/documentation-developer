---
description: ContentId Sort Clause
---

# ContentId Sort Clause

The `ContentId` Sort Clause sorts search results by the content items' IDs.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentId()];
```
