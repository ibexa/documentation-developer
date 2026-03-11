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
