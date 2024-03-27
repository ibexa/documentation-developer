# Id Sort Clause

The [`SortClause\Id` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-SortClause-Id.html)
sorts search results by the ID of the URL.

## Arguments

- `sortDirection` (optional) - the direction of the sorting, either `\Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause::SORT_ASC` (default) or `\Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause::SORT_DESC`

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;
use Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause;

// ...

$query = new URLQuery();
$query->sortClauses = [new SortClause\Id()];
```
