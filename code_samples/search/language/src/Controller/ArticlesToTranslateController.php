<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticlesToTranslateController extends AbstractController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function listView(Request $request): Response
    {
        $languageCode = $request->get('language');

        $query = new Query();
        $query->query = new Criterion\LogicalAnd([
            new Criterion\ContentTypeIdentifier('article'),
            new Criterion\LogicalNot(
                new Criterion\LanguageCode($languageCode, false)
            ),
        ]);

        $results = $this->searchService->findContent($query);
        $articles = [];
        foreach ($results->searchHits as $searchHit) {
            $articles[] = $searchHit->valueObject;
        }

        return $this->render('@ibexadesign/list/articles_to_translate.html.twig', [
            'articles' => $articles,
        ]);
    }
}
