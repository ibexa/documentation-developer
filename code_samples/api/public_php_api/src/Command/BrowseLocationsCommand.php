<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BrowseLocationsCommand extends Command
{
    private LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
        parent::__construct('doc:browse_locations');
    }

    protected function configure()
    {
        $this
            ->setDescription('Lists all descendants of the Location')
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, 'Location ID to browse from'),
            ]);
    }

    private function browseLocation(Location $location, OutputInterface $output, $depth = 0)
    {
        $output->writeln($location->contentInfo->name);

        $children = $this->locationService->loadLocationChildren($location);
        foreach ($children->locations as $child) {
            $this->browseLocation($child, $output, $depth + 1);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locationId = $input->getArgument('locationId');

        $location = $this->locationService->loadLocation($locationId);
        $this->browseLocation($location, $output);

        return self::SUCCESS;
    }
}
