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
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product'
)]
final class ProductCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private ProductTypeServiceInterface $productTypeService;

    private ProductServiceInterface $productService;

    private LocalProductServiceInterface $localProductService;

    private ProductAvailabilityServiceInterface $productAvailabilityService;

    public function __construct(
        UserService $userService,
        PermissionResolver $permissionResolver,
        ProductTypeServiceInterface $productTypeService,
        ProductServiceInterface $productService,
        LocalProductServiceInterface $localProductService,
        ProductAvailabilityServiceInterface $productAvailabilityService
    ) {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->productService = $productService;
        $this->productTypeService = $productTypeService;
        $this->localProductService = $localProductService;
        $this->productAvailabilityService = $productAvailabilityService;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productCode', InputArgument::REQUIRED, 'Product code'),
                new InputArgument('productType', InputArgument::REQUIRED, 'Product type'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $productCode = $input->getArgument('productCode');
        $productType = $input->getArgument('productType');

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

        return self::SUCCESS;
    }
}
