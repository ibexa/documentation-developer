<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchTestCommand extends Command
{
    protected static $defaultName = 'doc:test:search';

    private SearchService $searchService;

    public function __construct(
        SearchService $searchService
    ) {
        parent::__construct(self::$defaultName);
        $this->searchService = $searchService;
    }

    protected function configure(): void
    {
        $this->setDescription('Search test.')
            ->addArgument('text', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Searched text.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = implode(' ', $input->getArgument('text'));

        $query = new Query(['query' => new Criterion\LogicalAnd([
            new Criterion\FullText($text),
            new Criterion\LanguageCode(['eng-GB'], false),
        ])]);

        $results = $this->searchService->findContent($query, ['languages' => ['eng-GB', 'fre-FR', 'ger-DE']]);
        foreach ($results->searchHits as $searchHit) {
            /** @var \Ibexa\Core\Repository\Values\Content\Content $content */
            $content = $searchHit->valueObject;
            dump($content->getName('eng-GB'));
        }

        return Command::SUCCESS;
    }
}
