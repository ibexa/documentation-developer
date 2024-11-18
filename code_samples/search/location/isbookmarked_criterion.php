<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\IsBookmarked;

$query = new LocationQuery();
$query->filter = new IsBookmarked();
/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$results = $searchService->findLocations($query);