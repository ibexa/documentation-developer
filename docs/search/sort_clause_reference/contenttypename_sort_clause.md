---
description: ContentTypeName Sort Clause
---

# ContentTypeName Sort Clause

The [`ContentTypeName` Sort Clause](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Trash-ContentTypeName.html) sorts the results of searching in Trash by the name of the content item's content type.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\ContentTypeName()];
```
