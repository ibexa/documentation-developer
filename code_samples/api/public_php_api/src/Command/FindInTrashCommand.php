<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\TrashService;

class FindInTrashCommand extends Command
{
    private $trashService;

    public function __construct(TrashService $trashService)
    {
        $this->trashService = $trashService;
        parent::__construct('doc:find_in_trash');
    }

    protected function configure()
    {
        $this
            ->setDescription('Lists content in Trash belonging to the provided Content Type.')
            ->setDefinition([
                new InputArgument('contentTypeId', InputArgument::REQUIRED, 'Content Type ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentTypeId = $input->getArgument('contentTypeId');

        $query = new Query();

        $query->filter = new Query\Criterion\ContentTypeId($contentTypeId);
        $results = $this->trashService->findTrashItems($query);
        foreach ($results->items as $trashedLocation) {
            $output->writeln($trashedLocation->getContentInfo()->name);
        }

        return self::SUCCESS;
    }
}
