<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\RegionServiceInterface;
use Ibexa\Contracts\ProductCatalog\VatServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:vat'
)]
final class VatCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private VatServiceInterface $vatService;

    private RegionServiceInterface $regionService;

    public function __construct(
        UserService $userService,
        PermissionResolver $permissionResolver,
        VatServiceInterface $vatService,
        RegionServiceInterface $regionService
    ) {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->vatService = $vatService;
        $this->regionService = $regionService;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productCode', InputArgument::REQUIRED, 'Product code'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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

        return self::SUCCESS;
    }
}
