<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product_type'
)]
final readonly class ProductTypeCommand
{
    public function __construct(
        private UserService $userService,
        private PermissionResolver $permissionResolver,
        private ProductTypeServiceInterface $productTypeService
    ) {
    }

    public function __invoke(
        OutputInterface $output,
        #[Argument(description: 'Product type identifier')] string $productTypeIdentifier
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $productType = $this->productTypeService->getProductType($productTypeIdentifier);

        $output->writeln($productType->getName());

        $productTypes = $this->productTypeService->findProductTypes();

        foreach ($productTypes as $productType) {
            $output->writeln($productType->getName() . ' with identifier ' . $productType->getIdentifier());
        }

        return Command::SUCCESS;
    }
}
