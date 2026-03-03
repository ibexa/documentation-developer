<?php declare(strict_types=1);

namespace App\Service;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult;
use Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding;

final class TaxonomyEmbeddingSearchService
{
    public function __construct(
        private readonly SearchService $searchService,
    ) {
    }

    /**
     * @param float[] $vector
     */
    public function searchByEmbedding(array $vector): SearchResult
    {
        $query = EmbeddingQueryBuilder::create()
            ->withEmbedding(new TaxonomyEmbedding($vector))
            ->setLimit(10)
            ->setOffset(0)
            ->build();

        return $this->searchService->findContent($query);
    }
}
