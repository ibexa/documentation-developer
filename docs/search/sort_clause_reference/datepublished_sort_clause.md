# DatePublished Sort Clause

The [`DatePublished` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/DatePublished.php)
sorts search results by the date and time of the first publication of a Content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\DatePublished()];
```
