---
description: SectionId Criterion
---

# SectionId Criterion

The [`SectionId` URL Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-SectionId.html) matches URLs based on the ID of the related content Section.

## Arguments

- `sectionIds` - array of ints representing the IDs of the related content Sections

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\SectionId([1, 3]);
```
