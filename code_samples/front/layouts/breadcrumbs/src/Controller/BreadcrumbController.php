<?php declare(strict_types=1);

namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class BreadcrumbController extends Controller
{
    private $locationService;

    private $searchService;

    public function __construct(LocationService $locationService, SearchService $searchService)
    {
        $this->locationService = $locationService;
        $this->searchService = $searchService;
    }

    public function showBreadcrumbsAction($locationId)
    {
        $query = new LocationQuery();
        $query->query = new Criterion\Ancestor([$this->locationService->loadLocation($locationId)->pathString]);

        $results = $this->searchService->findLocations($query);
        $breadcrumbs = [];
        foreach ($results->searchHits as $searchHit) {
            $breadcrumbs[] = $searchHit;
        }

        return $this->render(
            '@ezdesign/parts/breadcrumbs.html.twig',
            [
                'breadcrumbs' => $breadcrumbs,
            ]
        );
    }
}
