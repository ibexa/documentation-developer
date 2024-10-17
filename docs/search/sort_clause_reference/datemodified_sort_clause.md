---
description: DateModified Sort Clause
---

# DateModified Sort Clause

The [`DateModified` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-DateModified.html) sorts search results by the date and time of the last modification of a content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\DateModified()];
```
