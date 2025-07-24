<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\AssetServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:assets'
)]
final readonly class ProductAssetCommand
{
    public function __construct(
        private UserService $userService,
        private PermissionResolver $permissionResolver,
        private ProductServiceInterface $productService,
        private AssetServiceInterface $assetService
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

        $productCode = $productCode;
        $product = $this->productService->getProduct($productCode);

        $singleAsset = $this->assetService->getAsset($product, '1');
        $output->writeln($singleAsset->getName());

        $assetCollection = $this->assetService->findAssets($product);

        foreach ($assetCollection as $asset) {
            $output->writeln($asset->getIdentifier() . ': ' . $asset->getName());
            $tags = $asset->getTags();
            foreach ($tags as $tag) {
                $output->writeln($tag);
            }
        }

        return Command::SUCCESS;
    }
}
