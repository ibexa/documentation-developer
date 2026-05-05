<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */

// For location searches
$locationQuery = new LocationQuery();
$locationQuery->performCount = false;

$locationResult = $searchService->findLocations($locationQuery);

// For content searches
$contentQuery = new Query();
$contentQuery->performCount = false;

$contentResult = $searchService->findContent($contentQuery);
