<?php

declare(strict_types=1);

namespace App\Controller;

use App\QueryType\BlogPostsQueryType;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Ibexa\Core\Pagination\Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class BlogController extends AbstractController
{
    public function __construct(
        private readonly TaxonomyServiceInterface $taxonomyService,
        private readonly SearchService $searchService,
        private readonly BlogPostsQueryType $queryType
    ) {}

    public function __invoke(Request $request, ContentView $view, int $page = 1): ContentView
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery $query */
        $query = $this->queryType->getQuery($this->getQueryParams($request, $view));

        $posts = new Pagerfanta(new LocationSearchAdapter($query, $this->searchService));
        $posts->setCurrentPage($page);
        $posts->setMaxPerPage(10);

        $view->addParameters([
           'blog_posts' => $posts,
        ]);

        return $view;
    }

    private function getQueryParams(Request $request, ContentView $view): array
    {
        $parameters = [];
        if ($request->query->has('start')) {
            $parameters['start'] = $request->query->getInt('start');
        }

        if ($request->query->has('end')) {
            $parameters['end'] = $request->query->getInt('end');
        }

        if ($request->query->has('min_rate')) {
            $parameters['min_rate'] = (float) $request->query->get('min_rate');
        }

        $content = $view->getContent();
        if ($content->getContentType()->identifier === 'tag') {
            $parameters['category'] = $this->taxonomyService->loadEntryByContentId($content->id);
        }

        return $parameters;
    }
}
