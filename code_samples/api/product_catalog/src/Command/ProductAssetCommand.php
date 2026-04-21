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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:assets'
)]
final class ProductAssetCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly ProductServiceInterface $productService,
        private readonly AssetServiceInterface $assetService
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

        return self::SUCCESS;
    }
}
