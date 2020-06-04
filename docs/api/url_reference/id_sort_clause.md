# Id Sort Clause

The [`SortClause\Id` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/SortClause/Id.php)
sorts search results by the ID of the URL.

## Arguments

- `sortDirection` (optional) - the direction of the sorting, either `\eZ\Publish\API\Repository\Values\URL\Query\SortClause::SORT_ASC` (default) or `\eZ\Publish\API\Repository\Values\URL\Query\SortClause::SORT_DESC`

## Example

``` php
use eZ\Publish\API\Repository\Values\URL\URLQuery;
use eZ\Publish\API\Repository\Values\URL\Query\SortClause;

// ...

$query = new URLQuery();
$query->sortClauses = [new SortClause\Id()];
```
