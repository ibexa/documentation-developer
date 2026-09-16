<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\BookmarkService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:bookmark'
)]
class BookmarkCommand extends Command
{
    public function __construct(
        private readonly BookmarkService $bookmarkService,
        private readonly LocationService $locationService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, 'Location id'),
            ])
            ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Delete the created Favourites entry?', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = (int) $input->getArgument('locationId');
        $location = $this->locationService->loadLocation($locationId);

        $this->bookmarkService->createBookmark($location);

        $output->writeln('Added ' . $location->getContentInfo()->name . ' to Favourites.');

        $bookmarkList = $this->bookmarkService->loadBookmarks();

        $output->writeln('Total favourites: ' . $bookmarkList->totalCount);

        foreach ($bookmarkList->items as $bookmark) {
            $output->writeln($bookmark->getContentInfo()->name);
        }

        if ($input->getOption('delete')) {
            $this->bookmarkService->deleteBookmark($location);
            $output->writeln('Deleted ' . $location->getContentInfo()->name . ' from Favourites.');
        }

        return self::SUCCESS;
    }
}
