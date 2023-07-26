# ContentTranslatedName Sort Clause

The [`ContentTranslatedName` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/ContentTranslatedName.php)
sorts search results by the Content items' translated names.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `ContentTranslatedName` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentTranslatedName()];
```
