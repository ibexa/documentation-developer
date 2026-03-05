<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\Values\Product\ProductVariantCreateStruct;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\ProductCriterionAdapter;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
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
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly ProductServiceInterface $productService,
        private readonly LocalProductServiceInterface $localProductService
    ) {
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

        // Get variants filtered by variant codes
        $codeQuery = new ProductVariantQuery();
        $codeQuery->setVariantCodes(['DESK-red', 'DESK-blue']);
        $specificVariants = $this->productService->findProductVariants($product, $codeQuery)->getVariants();

        // Get variants with specific attributes
        $combinedQuery = new ProductVariantQuery();
        $combinedQuery->setAttributesCriterion(
            new ProductCriterionAdapter(
                new Criterion\LogicalAnd([
                    new Criterion\ColorAttribute('color', ['red', 'blue']),
                    new Criterion\IntegerAttribute('size', 42),
                ])
            )
        );
        $filteredVariants = $this->productService->findProductVariants($product, $combinedQuery)->getVariants();

        foreach ($specificVariants as $variant) {
            $output->writeln($variant->getName());
            $attributes = $variant->getDiscriminatorAttributes();
            foreach ($attributes as $attribute) {
                $output->writeln($attribute->getIdentifier() . ': ' . $attribute->getValue() . ' ');
            }
        }

        // Create a variant
        $variantCreateStructs = [
            new ProductVariantCreateStruct(['color' => 'oak', 'frame_color' => 'white'], 'DESK-red'),
            new ProductVariantCreateStruct(['color' => 'white', 'frame_color' => 'black'], 'DESK-blue'),
        ];

        $this->localProductService->createProductVariants($product, $variantCreateStructs);

        // Search variants across all products
        $query = new ProductVariantQuery();
        $query->setVariantCodes(['DESK-red', 'DESK-blue']);
        $variantList = $this->productService->findVariants($query);

        foreach ($variantList->getVariants() as $variant) {
            $output->writeln($variant->getName());
        }

        // Search variants with attribute criterion
        $colorQuery = new ProductVariantQuery();
        $colorQuery->setAttributesCriterion(
            new ProductCriterionAdapter(
                new Criterion\ColorAttribute('color', ['red'])
            )
        );
        $redVariants = $this->productService->findVariants($colorQuery);

        foreach ($redVariants->getVariants() as $variant) {
            $output->writeln($variant->getName());
        }

        return self::SUCCESS;
    }
}
