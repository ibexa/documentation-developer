<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\Values\Product\ProductVariantCreateStruct;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product_variant'
)]
final class ProductVariantCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private ProductServiceInterface $productService;

    private LocalProductServiceInterface $localProductService;

    public function __construct(
        UserService $userService,
        PermissionResolver $permissionResolver,
        ProductServiceInterface $productService,
        LocalProductServiceInterface $localProductService
    ) {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->productService = $productService;
        $this->localProductService = $localProductService;

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

        $productCode = $input->getArgument('productCode');
        $product = $this->productService->getProduct($productCode);

        // Get variants
        $variantQuery = new ProductVariantQuery(0, 5);

        $variants = $this->productService->findProductVariants($product, $variantQuery)->getVariants();

        foreach ($variants as $variant) {
            $output->writeln($variant->getName());
            $attributes = $variant->getDiscriminatorAttributes();
            foreach ($attributes as $attribute) {
                $output->writeln($attribute->getIdentifier() . ': ' . $attribute->getValue() . ' ');
            }
        }

        // Create a variant
        $variantCreateStructs = [
            new ProductVariantCreateStruct(['color' => 'oak', 'frame_color' => 'white'], 'DESK1'),
            new ProductVariantCreateStruct(['color' => 'white', 'frame_color' => 'black'], 'DESK2'),
        ];

        $this->localProductService->createProductVariants($product, $variantCreateStructs);

        return self::SUCCESS;
    }
}
