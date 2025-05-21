<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:browse_locations', description: 'Lists all descendants of the Location')]
class BrowseLocationsCommand extends Command
{
    private LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, 'Location ID to browse from'),
            ]);
    }

    private function browseLocation(Location $location, OutputInterface $output, int $depth = 0): void
    {
        $output->writeln($location->contentInfo->name);

        $children = $this->locationService->loadLocationChildren($location);
        foreach ($children->locations as $child) {
            $this->browseLocation($child, $output, $depth + 1);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = (int) $input->getArgument('locationId');

        $location = $this->locationService->loadLocation($locationId);
        $this->browseLocation($location, $output);

        return self::SUCCESS;
    }
}
