<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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

    public function __invoke(
        #[Argument(description: 'Content type ID')] int $contentTypeId,
        OutputInterface $output
    ): int {
        $query = new Query();

        $query->filter = new Query\Criterion\ContentTypeId($contentTypeId);
        $results = $this->trashService->findTrashItems($query);
        foreach ($results->items as $trashedLocation) {
            $output->writeln($trashedLocation->getContentInfo()->name);
        }

        return Command::SUCCESS;
    }
}
