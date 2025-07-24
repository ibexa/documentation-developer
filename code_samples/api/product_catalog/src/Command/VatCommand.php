<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\RegionServiceInterface;
use Ibexa\Contracts\ProductCatalog\VatServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:vat'
)]
final readonly class VatCommand
{
    public function __construct(
        private UserService $userService,
        private PermissionResolver $permissionResolver,
        private VatServiceInterface $vatService,
        private RegionServiceInterface $regionService
    ) {
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productCode', InputArgument::REQUIRED, 'Product code'),
            ]);
    }

    public function __invoke(OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $region = $this->regionService->getRegion('poland');

        $vatCategories = $this->vatService->getVatCategories($region);

        foreach ($vatCategories as $category) {
            $output->writeln($category->getIdentifier() . ': ' . $category->getVatValue());
        }

        $vatCategory = $this->vatService->getVatCategoryByIdentifier($region, 'reduced');

        $output->writeln((string) $vatCategory->getVatValue());

        return Command::SUCCESS;
    }
}
