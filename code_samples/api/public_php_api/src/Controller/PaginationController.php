<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class PaginationController extends Controller
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function showContentAction(Request $request, $locationId)
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\ParentLocationId($locationId);

        $pager = new Pagerfanta(
            new ContentSearchAdapter($query, $this->searchService)
        );
        $pager->setMaxPerPage(3);
        $pager->setCurrentPage($request->get('page', 1));

        return $this->render(
            '@ibexadesign/full/custom_pagination.html.twig',
            [
                'totalItemCount' => $pager->getNbResults(),
                'pagerItems' => $pager,
            ]
        );
    }
}
