# ContentTranslatedName Sort Clause

The [`ContentTranslatedName` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/SortClause/ContentTranslatedName.php)
sorts search results by the Content items' translated names.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

The `ContentTranslatedName` Sort Clause is not available in [Repository filtering](../../../api/public_php_api_search.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentTranslatedName()];
```
