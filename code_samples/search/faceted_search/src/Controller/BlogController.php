<?php declare(strict_types=1);

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
    ) {
    }

    public function __invoke(Request $request, ContentView $view): ContentView
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery $query */
        $query = $this->queryType->getQuery($this->getQueryParams($request, $view));

        $posts = new Pagerfanta(new LocationSearchAdapter($query, $this->searchService));
        $posts->setCurrentPage($request->query->getInt('page'));
        $posts->setMaxPerPage(10);

        $view->addParameters([
            'blog_posts' => $posts,
        ]);

        return $view;
    }

    /**
     * Creates query parameters from current request.
     */
    private function getQueryParams(Request $request, ContentView $view): array
    {
        $parameters = [];

        $content = $view->getContent();
        if ($content->getContentType()->identifier === 'tag') {
            $parameters['category'] = $this->taxonomyService->loadEntryByContentId($content->id);
        }

        return $parameters;
    }
}
