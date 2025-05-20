<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\BookmarkService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'doc:bookmark'
)]
class BookmarkCommand extends Command
{
    private BookmarkService $bookmarkService;

    private LocationService $locationService;

    public function __construct(BookmarkService $bookmarkService, LocationService $locationService)
    {
        $this->bookmarkService = $bookmarkService;
        $this->locationService = $locationService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, 'Location id'),
            ])
            ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Delete the created bookmark?', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = (int) $input->getArgument('locationId');
        $location = $this->locationService->loadLocation($locationId);

        $this->bookmarkService->createBookmark($location);

        $output->writeln('Added bookmark to ' . $location->getContentInfo()->name);

        $bookmarkList = $this->bookmarkService->loadBookmarks();

        $output->writeln('Total bookmarks: ' . $bookmarkList->totalCount);

        foreach ($bookmarkList->items as $bookmark) {
            $output->writeln($bookmark->getContentInfo()->name);
        }

        if ($input->getOption('delete')) {
            $this->bookmarkService->deleteBookmark($location);
            $output->writeln('Deleted bookmark from ' . $location->getContentInfo()->name);
        }

        return self::SUCCESS;
    }
}
