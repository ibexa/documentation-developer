---
description: IsContainer Search Criterion
month_change: false
---

# IsContainer Criterion

The [`IsContainer` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-IsContainer.html) searches for content items based on whether they are containers (i.e., can contain other content items).

## Arguments

- `value` – boolean (optional, default: `true`). If `true`, searches for content that is a container. If `false`, searches for content that is not a container.

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\IsContainer(); // Finds containers
$query->query = new Criterion\IsContainer(false); // Finds non-containers
```
