<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\BookmarkService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:bookmark'
)]
class BookmarkCommand
{
    public function __construct(private readonly BookmarkService $bookmarkService, private readonly LocationService $locationService)
    {
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, 'Location id'),
            ])
            ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Delete the created bookmark?', null);
    }

    public function __invoke(#[\Symfony\Component\Console\Attribute\Option]
    $delete, OutputInterface $output): int
    {
        $locationId = (int) $locationId;
        $location = $this->locationService->loadLocation($locationId);

        $this->bookmarkService->createBookmark($location);

        $output->writeln('Added bookmark to ' . $location->getContentInfo()->name);

        $bookmarkList = $this->bookmarkService->loadBookmarks();

        $output->writeln('Total bookmarks: ' . $bookmarkList->totalCount);

        foreach ($bookmarkList->items as $bookmark) {
            $output->writeln($bookmark->getContentInfo()->name);
        }

        if ($delete) {
            $this->bookmarkService->deleteBookmark($location);
            $output->writeln('Deleted bookmark from ' . $location->getContentInfo()->name);
        }

        return Command::SUCCESS;
    }
}
