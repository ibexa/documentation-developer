<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:browse_locations',
    description: 'Lists all descendants of the Location'
)]
class BrowseLocationsCommand
{
    public function __construct(private readonly LocationService $locationService)
    {
    }

    private function browseLocation(Location $location, OutputInterface $output, int $depth = 0): void
    {
        $output->writeln($location->contentInfo->name);

        $children = $this->locationService->loadLocationChildren($location);
        foreach ($children->locations as $child) {
            $this->browseLocation($child, $output, $depth + 1);
        }
    }

    public function __invoke(
        #[Argument(description: 'Location ID to browse from')] int $locationId,
        OutputInterface $output
    ): int {
        $location = $this->locationService->loadLocation($locationId);
        $this->browseLocation($location, $output);

        return Command::SUCCESS;
    }
}
