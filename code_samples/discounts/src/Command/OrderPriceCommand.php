<?php declare(strict_types=1);

namespace App\Command;

use Exception;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\PriceResolverInterface;
use Ibexa\Contracts\ProductCatalog\ProductPriceServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceContext;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceEnvelopeInterface;
use Ibexa\Discounts\Value\Price\Stamp\DiscountStamp;
use Ibexa\OrderManagement\Discounts\Value\DiscountsData;
use Ibexa\ProductCatalog\Money\IntlMoneyFactory;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class OrderPriceCommand extends Command
{
    protected static $defaultName = 'app:discounts:prices';

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ProductServiceInterface $productService;

    private OrderServiceInterface $orderService;

    private ProductPriceServiceInterface $productPriceService;

    private CurrencyServiceInterface $currencyService;

    private PriceResolverInterface $priceResolver;

    private IntlMoneyFactory $moneyFactory;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        ProductServiceInterface $productService,
        OrderServiceInterface $orderService,
        ProductPriceServiceInterface $productPriceService,
        CurrencyServiceInterface $currencyService,
        PriceResolverInterface $priceResolver,
        IntlMoneyFactory $moneyFactory
    ) {
        parent::__construct();

        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->productPriceService = $productPriceService;
        $this->currencyService = $currencyService;
        $this->priceResolver = $priceResolver;
        $this->moneyFactory = $moneyFactory;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin('admin'));

        $productCode = 'product_code_control_unit_0';
        $orderIdentifier = '4315bc58-1e96-4f21-82a0-15f736cbc4bc';
        $currencyCode = 'EUR';

        $output->writeln('Product data:');
        $product = $this->productService->getProduct($productCode);
        $currency = $this->currencyService->getCurrencyByCode($currencyCode);

        $basePrice = $this->productPriceService->getPriceByProductAndCurrency($product, $currency);
        $resolvedPrice = $this->priceResolver->resolvePrice($product, new PriceContext($currency));

        if ($resolvedPrice === null) {
            throw new Exception('Could not resolve price for the product');
        }

        $output->writeln(sprintf('Base price: %s', $this->formatPrice($basePrice->getMoney())));
        $output->writeln(sprintf('Discounted price: %s', $this->formatPrice($resolvedPrice->getMoney())));

        if ($resolvedPrice instanceof PriceEnvelopeInterface) {
            /** @var \Ibexa\Discounts\Value\Price\Stamp\DiscountStamp $discountStamp */
            foreach ($resolvedPrice->all(DiscountStamp::class) as $discountStamp) {
                $output->writeln(
                    sprintf(
                        'Discount applied: %s , new amount: %s',
                        $discountStamp->getDiscount()->getName(),
                        $this->formatPrice(
                            $discountStamp->getNewPrice()
                        )
                    )
                );
            }
        }

        $output->writeln('Order details:');

        $order = $this->orderService->getOrderByIdentifier($orderIdentifier);
        foreach ($order->getItems() as $item) {
            /** @var ?DiscountsData $discountData */
            $discountData = $item->getContext()['discount_data'] ?? null;
            if ($discountData instanceof DiscountsData) {
                $output->writeln(
                    sprintf(
                        'Product bought with discount: %s, base price: %s, discounted price: %s',
                        $item->getProduct()->getName(),
                        $this->formatPrice($discountData->getOriginalPrice()),
                        $this->formatPrice(
                            $item->getValue()->getUnitPriceGross()
                        )
                    )
                );
            } else {
                $output->writeln(
                    sprintf(
                        'Product bought with original price: %s, price: %s',
                        $item->getProduct()->getName(),
                        $this->formatPrice(
                            $item->getValue()->getUnitPriceGross()
                        )
                    )
                );
            }
        }

        return Command::SUCCESS;
    }

    private function formatPrice(Money $money): string
    {
        return $this->moneyFactory->getMoneyFormatter()->format($money);
    }
}
