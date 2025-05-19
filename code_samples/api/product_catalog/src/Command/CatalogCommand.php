<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CatalogServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Catalog\CatalogCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Catalog\CatalogUpdateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\ProductCatalog\Local\Repository\Values\Catalog\Status;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:catalog'
)]
final class CatalogCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private ProductServiceInterface $productService;

    private CatalogServiceInterface $catalogService;

    public function __construct(
        UserService $userService,
        PermissionResolver $permissionResolver,
        ProductServiceInterface $productService,
        CatalogServiceInterface $catalogService
    ) {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->productService = $productService;
        $this->catalogService = $catalogService;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('catalogIdentifier', InputArgument::REQUIRED, 'Catalog identifier'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $catalogIdentifier = $input->getArgument('catalogIdentifier');

        // Create catalog
        $catalogCriterion = new Criterion\LogicalAnd(
            [
                new Criterion\ProductType(['desk']),
                new Criterion\ProductAvailability(true),
            ]
        );

        $catalogCreateStruct = new CatalogCreateStruct(
            $catalogIdentifier,
            $catalogCriterion,
            ['eng-GB' => 'Desk promo'],
            ['eng-GB' => 'Desk promo description'],
        );

        $this->catalogService->createCatalog($catalogCreateStruct);

        // Get catalog
        $catalog = $this->catalogService->getCatalogByIdentifier($catalogIdentifier);
        $output->writeln($catalog->getName());

        // Get products in catalog
        $productQuery = new ProductQuery(null, $catalog->getQuery());
        $products = $this->productService->findProducts($productQuery);

        foreach ($products as $product) {
            $output->writeln($product->getName());
        }

        // Update catalog
        $catalogUpdateStruct = new CatalogUpdateStruct($catalog->getId());
        $catalogUpdateStruct->setTransition(Status::PUBLISH_TRANSITION);

        $this->catalogService->updateCatalog($catalog, $catalogUpdateStruct);

        return self::SUCCESS;
    }
}
