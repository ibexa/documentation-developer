<?php

namespace App\Controller;

use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Ibexa\AdminUi\Form\Factory\FormFactory;

class AllContentListController extends Controller
{
    private $searchService;

    private $formFactory;

    public function __construct(SearchService $searchService, FormFactory $formFactory)
    {
        $this->searchService = $searchService;
        $this->formFactory = $formFactory;
    }

    public function listAction($page = 1)
    {
        $query = new LocationQuery();

        $query->query = new Criterion\Visibility(Criterion\Visibility::VISIBLE);

        $paginator = new Pagerfanta(
            new LocationSearchAdapter($query, $this->searchService)
        );
        $paginator->setMaxPerPage(8);
        $paginator->setCurrentPage($page);
        $editForm = $this->formFactory->contentEdit();

        return $this->render('list/all_content_list.html.twig', [
            'totalCount' => $paginator->getNbResults(),
            'articles' => $paginator,
            'form_edit' => $editForm->createView()
        ]);
    }
}
