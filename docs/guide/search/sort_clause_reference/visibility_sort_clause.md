# Visibility Sort Clause

The [`Location\Visibility` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Location/Visibility.php)
sorts search results by whether the Location is visible or not.

Locations that are not visible are ranked as higher values (e.g. with ascending order they will be returned last).

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Visibility()];
```
