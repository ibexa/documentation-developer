# URL Sort Clause

The [`SortClause\Url` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/SortClause/URL.php)
sorts search results by the URLs.

## Arguments

- `sortDirection` (optional) - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new SortClause();
$query->sortClauses = [new SortClause\Url()];
```