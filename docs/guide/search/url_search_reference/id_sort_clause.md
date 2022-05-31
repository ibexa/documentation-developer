# Id Sort Clause

The [`SortClause\Id` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/SortClause/Id.php)
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
