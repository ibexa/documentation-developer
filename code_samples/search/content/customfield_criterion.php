<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;

$query = new Query();

// Example Solr query: find content items with "content_name_s" starting with "Ibexa"
$query->query = new Query\Criterion\CustomField('content_name_s', Operator::EQ, '/Ibexa.*/');

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$searchService->findContent($query);
