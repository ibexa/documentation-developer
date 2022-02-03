<?php

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ParentLocationId;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Ibexa\Bundle\Core\Controller;

class CustomFilterController extends Controller
{
    private $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function showChildrenAction(ContentView $view): ContentView
    {
        $filter = new Filter();
        $filter
            ->withCriterion(new ParentLocationId($view->getLocation()->id));

        $view->setParameters(
            [
                'items' => $this->contentService->find($filter),
            ]
        );

        return $view;
    }
}
