<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\IsBookmarked;

$query = new LocationQuery();
$query->filter = new IsBookmarked();
/** @var SearchService $searchService */
$results = $searchService->findLocations($query);
