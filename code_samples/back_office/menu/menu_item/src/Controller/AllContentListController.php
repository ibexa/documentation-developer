<?php

namespace App\Controller;

use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Ibexa\AdminUi\Form\Factory\FormFactory;

class AllContentListController extends Controller
{
    private $searchService;

    private $contentTypeService;

    private $formFactory;

    public function __construct(SearchService $searchService, ContentTypeService $contentTypeService, FormFactory $formFactory)
    {
        $this->searchService = $searchService;
        $this->contentTypeService = $contentTypeService;
        $this->formFactory = $formFactory;
    }

    public function listAction($contentTypeIdentifier = false, $page = 1)
    {
        $query = new LocationQuery();

        $criterions = [
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
        ];

        if ($contentTypeIdentifier) {
            $criterions[] = new Criterion\ContentTypeIdentifier($contentTypeIdentifier);
        }

        $query->query = new Criterion\LogicalAnd($criterions);

        $paginator = new Pagerfanta(
            new LocationSearchAdapter($query, $this->searchService)
        );
        $paginator->setMaxPerPage(8);
        $paginator->setCurrentPage($page);
        $editForm = $this->formFactory->contentEdit();

        $contentTypes = [];
        $contentTypeGroups = $this->contentTypeService->loadContentTypeGroups();
        foreach ($contentTypeGroups as $group) {
            $contentTypes[$group->identifier] = $this->contentTypeService->loadContentTypes($group);
        }

        return $this->render('list/all_content_list.html.twig', [
            'totalCount' => $paginator->getNbResults(),
            'articles' => $paginator,
            'form_edit' => $editForm->createView(),
            'contentTypes' => $contentTypes,
        ]);
    }
}
