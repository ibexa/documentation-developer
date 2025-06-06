<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\PriceResolverInterface;
use Ibexa\Contracts\ProductCatalog\ProductPriceServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\Create\Struct\ProductPriceCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceContext;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency as CurrencyCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\CustomerGroup;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalOr;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Product;
use Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:price'
)]
final class ProductPriceCommand extends Command
{
    private ProductPriceServiceInterface $productPriceService;

    private PriceResolverInterface $priceResolver;

    private ProductServiceInterface $productService;

    private CurrencyServiceInterface $currencyService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(
        CurrencyServiceInterface $currencyService,
        ProductServiceInterface $productService,
        ProductPriceServiceInterface $productPriceService,
        PriceResolverInterface $priceResolver,
        UserService $userService,
        PermissionResolver $permissionResolver
    ) {
        $this->currencyService = $currencyService;
        $this->productPriceService = $productPriceService;
        $this->priceResolver = $priceResolver;
        $this->productService = $productService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
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

        $productPrice = $product->getPrice();

        $output->writeln('Price for ' . $product->getName() . ' is ' . $productPrice);

        $productPrice = $this->productPriceService->getPriceByProductAndCurrency($product, $currency);

        $output->writeln('Price for ' . $product->getName() . ' in ' . $currencyCode . ' is ' . $productPrice);

        $newCurrencyCode = $input->getArgument('newCurrencyCode');
        $newCurrency = $this->currencyService->getCurrencyByCode($newCurrencyCode);

        $money = new Money\Money(50000, new Money\Currency($newCurrencyCode));
        $priceCreateStruct = new ProductPriceCreateStruct($product, $newCurrency, $money, null, null);

        $this->productPriceService->createProductPrice($priceCreateStruct);

        $output->writeln('Created new price in currency ' . $newCurrencyCode);

        $prices = $this->productPriceService->findPricesByProductCode($productCode)->getPrices();

        $output->writeln('All prices for ' . $product->getName() . ':');
        foreach ($prices as $price) {
            $output->writeln((string) $price);
        }

        $priceCriteria = [
            new CurrencyCriterion($this->currencyService->getCurrencyByCode('USD')),
            new CustomerGroup('customer_group_1'),
            new Product('ergo_desk'),
        ];

        $priceQuery = new PriceQuery(new LogicalOr(...$priceCriteria));
        $prices = $this->productPriceService->findPrices($priceQuery);

        $output->writeln(sprintf('Found %d prices with provided criteria', $prices->getTotalCount()));

        $context = new PriceContext($currency);
        $price = $this->priceResolver->resolvePrice($product, $context);

        $output->writeln('Price in ' . $currency->getCode() . ' for ' . $product->getName() . ' is ' . $price);

        return self::SUCCESS;
    }
}
