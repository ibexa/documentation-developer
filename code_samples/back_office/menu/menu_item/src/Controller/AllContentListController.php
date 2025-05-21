<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\AdminUi\Form\Factory\FormFactory;
use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class AllContentListController extends Controller
{
    private SearchService $searchService;

    private FormFactory $formFactory;

    public function __construct(SearchService $searchService, FormFactory $formFactory)
    {
        $this->searchService = $searchService;
        $this->formFactory = $formFactory;
    }

    public function listAction(int $page = 1): Response
    {
        $query = new LocationQuery();

        $query->query = new Criterion\Visibility(Criterion\Visibility::VISIBLE);

        $paginator = new Pagerfanta(
            new LocationSearchAdapter($query, $this->searchService)
        );
        $paginator->setMaxPerPage(8);
        $paginator->setCurrentPage($page);
        $editForm = $this->formFactory->contentEdit();

        return $this->render('@ibexadesign/all_content_list.html.twig', [
            'totalCount' => $paginator->getNbResults(),
            'articles' => $paginator,
            'form_edit' => $editForm,
        ]);
    }
}
