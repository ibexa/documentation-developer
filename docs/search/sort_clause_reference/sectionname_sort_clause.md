# SectionName Sort Clause

The [`SectionName` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/SectionName.php)
sorts search results by the Section name of the Content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\SectionName()];
```
