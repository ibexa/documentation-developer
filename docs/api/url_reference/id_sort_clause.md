# Id Sort Clause

The [`SortClause\Id` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/SortClause/Id.php)
sorts search results by the ID of the URL.

## Arguments

- `sortDirection` (optional) - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new SortClause();
$query->sortClauses = [new SortClause\Id()];
```