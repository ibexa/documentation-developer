# DateModified Sort Clause

The [`DateModified` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/DateModified.php)
sorts search results by the date and time of the last modification of a Content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\DateModified()];
```
