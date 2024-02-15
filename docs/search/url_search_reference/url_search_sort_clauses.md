---
description: URL Sort Clauses
page_type: reference
---

# URL Sort Clauses

URL Sort Clauses are the sorting options for URLs.
They are only supported by [URL Search (`URLService::findUrls`)](url_api.md).

All URL Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `\Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause::SORT_ASC` (default) or `\Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause::SORT_DESC`

| Sort Clause | Sorting based on |
|-----|-----|
|[Id](id_url_sort_clause.md)|URL ID|
|[URL](url_url_sort_clause.md)|URL address|
