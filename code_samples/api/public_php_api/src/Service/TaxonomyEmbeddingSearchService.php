<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Taxonomy;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult;
use Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding;

final class TaxonomyEmbeddingSearchService
{
    public function __construct(private readonly SearchService $searchService)
    {
    }

    /**
     * @param float[] $vector
     *
     * @return SearchResult<Content>
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
