<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_in_trash'
)]
class FindInTrashCommand extends Command
{
    private TrashService $trashService;

    public function __construct(TrashService $trashService)
    {
        $this->trashService = $trashService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Lists content in Trash belonging to the provided content type.')
            ->setDefinition([
                new InputArgument('contentTypeId', InputArgument::REQUIRED, 'Content type ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentTypeId = (int) $input->getArgument('contentTypeId');

        $query = new Query();

        $query->filter = new Query\Criterion\ContentTypeId($contentTypeId);
        $results = $this->trashService->findTrashItems($query);
        foreach ($results->items as $trashedLocation) {
            $output->writeln($trashedLocation->getContentInfo()->name);
        }

        return self::SUCCESS;
    }
}
