---
description: ContentTranslatedName Sort Clause
---

# ContentTranslatedName Sort Clause

The `ContentTranslatedName` Sort Clause sorts search results by the content items' translated names.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `ContentTranslatedName` Sort Clause isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentTranslatedName()];
```
