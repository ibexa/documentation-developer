<?php

namespace App\Controller;

use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;

class AllContentListController extends Controller
{
    private $searchService;

    private $contentTypeService;

    public function __construct(SearchService $searchService, ContentTypeService $contentTypeService)
    {
        $this->searchService = $searchService;
        $this->contentTypeService = $contentTypeService;
    }

    public function listAction($page = 1)
    {
        $query = new LocationQuery();

        $criterions = [
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
        ];

        $query->query = new Criterion\LogicalAnd($criterions);

        $paginator = new Pagerfanta(
            new LocationSearchAdapter($query, $this->searchService)
        );
        $paginator->setMaxPerPage(8);
        $paginator->setCurrentPage($page);

        return $this->render('list/all_content_list.html.twig', [
            'totalCount' => $paginator->getNbResults(),
            'articles' => $paginator,
        ]);
    }
}
