<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product_type'
)]
final class ProductTypeCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private ProductTypeServiceInterface $productTypeService;

    public function __construct(UserService $userService, PermissionResolver $permissionResolver, ProductTypeServiceInterface $productTypeService)
    {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->productTypeService = $productTypeService;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productTypeIdentifier', InputArgument::REQUIRED, 'Product type identifier'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $productTypeIdentifier = $input->getArgument('productTypeIdentifier');

        $productType = $this->productTypeService->getProductType($productTypeIdentifier);

        $output->writeln($productType->getName());

        $productTypes = $this->productTypeService->findProductTypes();

        foreach ($productTypes as $productType) {
            $output->writeln($productType->getName() . ' with identifier ' . $productType->getIdentifier());
        }

        return self::SUCCESS;
    }
}
