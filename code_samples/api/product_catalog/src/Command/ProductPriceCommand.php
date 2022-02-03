<?php

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductPriceServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\Create\Struct\ProductPriceCreateStruct;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Money;

final class ProductPriceCommand extends Command
{
    private $productPriceService;

    private $productService;

    private $currencyService;

    private $userService;

    private $permissionResolver;

    public function __construct(CurrencyServiceInterface $currencyService, ProductServiceInterface $productService,  ProductPriceServiceInterface $productPriceService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->currencyService = $currencyService;
        $this->productPriceService = $productPriceService;
        $this->productService = $productService;

        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct("doc:price");
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productCode', InputArgument::REQUIRED, 'Product code'),
                new InputArgument('currencyCode', InputArgument::REQUIRED, 'Currency code'),
                new InputArgument('newCurrencyCode', InputArgument::REQUIRED, 'New currency code'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $productCode = $input->getArgument('productCode');
        $product = $this->productService->getProduct($productCode);
        $currencyCode = $input->getArgument('currencyCode');
        $currency = $this->currencyService->getCurrencyByCode($currencyCode);

        $productPrice = $this->productPriceService->getPriceByProductAndCurrency($product, $currency);

        $output->writeln("Price for ". $product->getName() . " in " . $currencyCode . " is " . $productPrice);

        $newCurrencyCode = $input->getArgument('newCurrencyCode');
        $newCurrency = $this->currencyService->getCurrencyByCode($newCurrencyCode);

        $money = new Money\Money(50000, new Money\Currency($newCurrencyCode));
        $priceCreateStruct = new ProductPriceCreateStruct($product, $newCurrency, $money, null);

        $this->productPriceService->createProductPrice($priceCreateStruct);

        $output->writeln("Created new price in currency " . $newCurrencyCode);

        $prices = $this->productPriceService->findPricesByProductCode($productCode);

        $output->writeln("All prices for " . $product->getName() . ":");
        foreach ($prices as $price) {
            $output->writeln($price);
        }

        return self::SUCCESS;
    }
}
