<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\BookmarkService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:bookmark'
)]
class BookmarkCommand
{
    public function __construct(private readonly BookmarkService $bookmarkService, private readonly LocationService $locationService)
    {
    }

    public function __invoke(
        #[Argument(description: 'Location id')] int $locationId,
        #[Option(shortcut: 'd', description: 'Delete the created bookmark?')] bool $delete,
        OutputInterface $output
    ): int {
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
