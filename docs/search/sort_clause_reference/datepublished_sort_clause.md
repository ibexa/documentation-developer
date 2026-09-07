---
description: DatePublished Sort Clause
---

# DatePublished Sort Clause

The `DatePublished` Sort Clause sorts search results by the date and time of the first publication of a content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\DatePublished()];
```
