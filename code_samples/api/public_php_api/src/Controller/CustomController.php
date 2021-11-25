<?php

namespace App\Controller;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Bundle\EzPublishCoreBundle\Controller;

class CustomController extends Controller
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function showContentAction($locationId)
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\ParentLocationId($locationId);

        $results = $this->searchService->findContentInfo($query);
        $items = [];
        foreach ($results->searchHits as $searchHit) {
            $items[] = $searchHit;
        }

        return $this->render('custom.html.twig', [
            'items' => $items,
        ]);
    }
}
