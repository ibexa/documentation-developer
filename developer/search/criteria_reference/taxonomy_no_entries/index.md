# TaxonomyNoEntries Criterion

TaxonomyNoEntries Search Criterion

The [`Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomyNoEntries`](../../../../../../ibexa/taxonomy/src/contracts/Search/Query/Criterion/TaxonomyNoEntries.php) Search Criterion searches for content that has no entries assigned from the specified [taxonomy](../../../content_management/taxonomy/taxonomy/index.md).

Use it when you need to find content items to which no taxonomy entries have been assigned (for example, articles without tags). It's available for all supported search engines and in [repository filtering](../../search_api/index.md#repository-filtering).

## Arguments

- `taxonomy` - `string` representing the identifier of the taxonomy (for example, `tags` or `categories`)

## Example

### PHP

The following example searches for articles that have no entries assigned in the `tags` taxonomy:

```php
<?php

declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomyNoEntries;

$query = new Query();
$query->query = new LogicalAnd(
    [
        new TaxonomyNoEntries('tags'),
        new ContentTypeIdentifier('article'),
    ]
);

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$results = $searchService->findContent($query);
```

The criteria limit the results to content that matches all of the conditions listed below:

- content has no entries assigned in the `tags` taxonomy
- content type is `article`
