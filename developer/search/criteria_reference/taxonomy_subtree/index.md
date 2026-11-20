# TaxonomySubtree Criterion

TaxonomySubtree Search Criterion

The [`Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomySubtree`](../../../../../../ibexa/taxonomy/src/contracts/Search/Query/Criterion/TaxonomySubtree.php) Search Criterion searches for content assigned to the specified [taxonomy](../../../content_management/taxonomy/taxonomy/index.md) entry or any of its descendants.

## Arguments

- `taxonomyEntryId` - `int` representing the ID of the taxonomy entry that is the root of the subtree

## Example

### PHP

The following example searches for articles assigned to taxonomy entry with ID `42` or any of its child entries:

```php
<?php

declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomySubtree;

$query = new Query();
$query->query = new LogicalAnd(
    [
        new TaxonomySubtree(42),
        new ContentTypeIdentifier('article'),
    ]
);

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$results = $searchService->findContent($query);
```

The criteria limit the results to content that match all of the conditions listed below:

- content is assigned to taxonomy entry `42` or any of its descendants
- content type is `article`
