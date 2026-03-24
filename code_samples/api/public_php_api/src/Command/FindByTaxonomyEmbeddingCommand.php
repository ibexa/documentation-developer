<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchHit;
use Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface;
use Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ibexa:taxonomy:find-by-embedding',
    description: 'Finds content using a taxonomy embedding query.'
)]
final class FindByTaxonomyEmbeddingCommand extends Command
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly EmbeddingProviderResolverInterface $embeddingProviderResolver,
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $embeddingProvider = $this->embeddingProviderResolver->resolve();
        $embedding = $embeddingProvider->getEmbedding('example_content');

        $query = EmbeddingQueryBuilder::create()
            ->withEmbedding(new TaxonomyEmbedding($embedding))
            ->setFilter(new ContentTypeIdentifier('article'))
            ->setLimit(10)
            ->setOffset(0)
            ->setPerformCount(true)
            ->build();

        $result = $this->searchService->findContent($query);

        $io->success(sprintf('Found %d items.', $result->totalCount));

        foreach ($result->searchHits as $searchHit) {
            assert($searchHit instanceof SearchHit);

            /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
            $content = $searchHit->valueObject;
            $contentInfo = $content->versionInfo->contentInfo;

            $io->writeln(sprintf(
                '%d: %s',
                $contentInfo->id,
                $contentInfo->name
            ));
        }

        return self::SUCCESS;
    }
}
