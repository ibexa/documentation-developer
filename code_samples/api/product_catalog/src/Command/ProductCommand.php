<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductAvailabilityServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Availability\ProductAvailabilityCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Availability\ProductAvailabilityUpdateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product'
)]
final readonly class ProductCommand
{
    public function __construct(
        private UserService $userService,
        private PermissionResolver $permissionResolver,
        private ProductTypeServiceInterface $productTypeService,
        private ProductServiceInterface $productService,
        private LocalProductServiceInterface $localProductService,
        private ProductAvailabilityServiceInterface $productAvailabilityService
    ) {
    }

    public function __invoke(
        OutputInterface $output,
        #[Argument(description: 'Product code')] string $productCode,
        #[Argument(description: 'Product type')] string $productType
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $product = $this->productService->getProduct($productCode);

        $output->writeln('Product with code ' . $product->getCode() . ' is ' . $product->getName());

        $criteria = new Criterion\ProductType([$productType]);
        $sortClauses = [new SortClause\ProductName(ProductQuery::SORT_ASC)];

        $productQuery = new ProductQuery(null, $criteria, $sortClauses);

        $products = $this->productService->findProducts($productQuery);

        foreach ($products as $product) {
            $output->writeln($product->getName() . ' of type ' . $product->getProductType()->getName());
        }

        $productType = $this->productTypeService->getProductType($productType);

        $createStruct = $this->localProductService->newProductCreateStruct($productType, 'eng-GB');
        $createStruct->setCode('NEWPRODUCT');
        $createStruct->setField('name', 'New Product');

        $this->localProductService->createProduct($createStruct);

        $product = $this->productService->getProduct('NEWPRODUCT');

        $productUpdateStruct = $this->localProductService->newProductUpdateStruct($product);
        $productUpdateStruct->setCode('NEWMODIFIEDPRODUCT');

        $this->localProductService->updateProduct($productUpdateStruct);

        $product = $this->productService->getProduct('NEWMODIFIEDPRODUCT');

        $productAvailabilityCreateStruct = new ProductAvailabilityCreateStruct($product, true, true);

        $this->productAvailabilityService->createProductAvailability($productAvailabilityCreateStruct);

        if ($this->productAvailabilityService->hasAvailability($product)) {
            $availability = $this->productAvailabilityService->getAvailability($product);

            $output->write($availability->isAvailable() ? 'Available' : 'Unavailable');
            $output->writeln(' with stock ' . $availability->getStock());

            $availability = $this->productAvailabilityService->getAvailability($product);

            $productAvailabilityUpdateStruct = new ProductAvailabilityUpdateStruct($product, true, false, 80);

            $this->productAvailabilityService->updateProductAvailability($productAvailabilityUpdateStruct);

            $output->write($availability->isAvailable() ? 'Available' : 'Unavailable');
            $output->writeln(' available now with stock ' . $availability->getStock());
        }

        $this->localProductService->deleteProduct($product);

        return Command::SUCCESS;
    }
}
