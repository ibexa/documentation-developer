# DatePublished Sort Clause

The [`DatePublished` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-DatePublished.html)
sorts search results by the date and time of the first publication of a Content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\DatePublished()];
```
