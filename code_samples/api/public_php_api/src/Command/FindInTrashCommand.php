<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_in_trash',
    description: 'Lists content in Trash belonging to the provided content type.'
)]
class FindInTrashCommand
{
    public function __construct(private readonly TrashService $trashService)
    {
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('contentTypeId', InputArgument::REQUIRED, 'Content type ID'),
            ]);
    }

    public function __invoke(OutputInterface $output): int
    {
        $contentTypeId = (int) $contentTypeId;

        $query = new Query();

        $query->filter = new Query\Criterion\ContentTypeId($contentTypeId);
        $results = $this->trashService->findTrashItems($query);
        foreach ($results->items as $trashedLocation) {
            $output->writeln($trashedLocation->getContentInfo()->name);
        }

        return Command::SUCCESS;
    }
}
