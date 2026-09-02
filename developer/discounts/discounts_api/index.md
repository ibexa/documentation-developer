# Discounts API

Discounts enable reducing prices on products or product categories based on a detailed logic resolution.

Editions: Commerce

## Manage discounts and discount codes

By integrating with the [Discount feature](../discounts_guide/index.md) you can automate the process of managing discounts, streamlining the whole process and automating business rules.

For example, you can automatically create a discount when a customer places their 3rd order, encouraging them to make another purchase and increase their chances of becoming a loyal customer.

You can manage discounts using [data migrations](../../content_management/data_migration/importing_data/index.md#discounts), [REST API](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#discounts), or the PHP API by using the [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) service.

The core concepts when working with discounts through the APIs are listed below.

### Types

When using the PHP API, the discount type defines where the discount can be applied.

Discounts are applied in two places, listed in the [`Ibexa\Contracts\Discounts\Value\DiscountType`](../../../../../ibexa/discounts/src/contracts/Value/DiscountType.php) class:

- **Product catalog** - `catalog` discounts are activated when browsing the product catalog and do not require any action from the customer to be activated
- **Cart** - `cart` discounts can activate when entering the [cart](../../commerce/cart/cart/index.md), if the right conditions are met. They may also require entering a discount code to be activated

Regardless of activation place, discounts always apply to products and reduce their base price.

To define when a discount activates and how the price is reduced, use rules and conditions. They use the [Symfony Expression language](https://symfony.com/doc/7.4/expression_language.html) to express their logic.

### Rules

Discount rules define how to calculate the price reduction. The following discount rule types are available in the `\Ibexa\Discounts\Value\DiscountRule` namespace:

| Rule type (identifier)         | Description                                                             | Required expression value |
| ------------------------------ | ----------------------------------------------------------------------- | ------------------------- |
| `FixedAmount` (`fixed_amount`) | Deducts the specified amount, for example 10 EUR, from the base price   | `discount_amount`         |
| `Percentage` (`percentage`)    | Deducts the specified percentage, for example -10%, from the base price | `discount_percentage`     |

Only a single discount can be applied to a given product, and a discount can only have a single rule.

When creating a rule, not with the user interface but an API, you must pass the required expression values for the rule to be valid:

- using PHP, the values are passed through the constructor which converts them into an expression variable
- using data migrations and the REST API, the values are specified using the `expressionValues` key

See the following examples for data migrations and the REST API usage:

- creating discounts with [data migrations](../../content_management/data_migration/importing_data/index.md#discounts):

```yaml
-   type: discount
    mode: create
# ...
    rule:
        type: percentage
        expressionValues:
            discount_percentage: 10
```

- parsing responses from the [REST API](https://doc.ibexa.co/en/4.6/api/rest_api/rest_api_reference/rest_api_reference.html#discounts):

```json
{
    "Discount": {
        "_media-type": "application/vnd.ibexa.api.Discount+json",
        "id": 1,
        "identifier": "summersale2025",
        "name": "SummerSale2025",
        "type": "catalog",
        "label": "Summer Sale 2025",
        "labelDescription": "Summer Sale 2025",
        "priority": 1,
        "isEnabled": true,
        "createdAt": "2025-06-10T09:43:42+00:00",
        "updatedAt": "2025-06-10T09:48:23+00:00",
        "startDate": "2025-07-01T09:34:19+00:00",
        "endDate": "2025-07-31T12:00:00+00:00",
        "DiscountExpressionAware": {
            "_media-type": "application/vnd.ibexa.api.DiscountExpressionAware+json",
            "expressionValues": {
                "discount_amount": "10"
            }
        },

}
```

### Conditions

With conditions you can narrow down the scenarios in which the discount applies. The following conditions are available in the `\Ibexa\Discounts\Value\DiscountCondition` and `\Ibexa\DiscountsCodes\Value\DiscountCondition` namespaces:

| Condition (identifier)                                         | Applies to    | Description                                                                                                                                                   | Required expression values     |
| -------------------------------------------------------------- | ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------ |
| `IsInCategory` (`is_in_category`)                              | Cart, Catalog | Checks if the product belongs to specified [product categories](../../../user/product_catalog/work_with_product_categories/index.md) | `categories`                   |
| `IsInCurrency` (`is_in_currency`)                              | Cart, Catalog | Checks if the product has price in the specified currency                                                                                                     | `currency_code`                |
| `IsInRegions` (`is_in_regions`)                                | Cart, Catalog | Checks if the customer is making the purchase in one of the specified regions                                                                                 | `regions`                      |
| `IsProductInArray` (`is_product_in_array`)                     | Cart, Catalog | Checks if the product belongs to the group of selected products                                                                                               | `product_codes`                |
| `IsUserInCustomerGroup` (`is_user_in_customer_group`)          | Cart, Catalog | Check if the customer belongs to specified [customer groups](../../users/customer_groups/index.md)                                      | `customer_groups`              |
| `IsProductInQuantityInCart` (`is_product_in_quantity_in_cart`) | Cart          | Checks if the required minimum quantity of a given product is present in the cart                                                                             | `quantity`                     |
| `MinimumPurchaseAmount` (`minimum_purchase_amount`)            | Cart          | Checks if purchase amount in the cart exceeds the specified minimum                                                                                           | `minimum_purchase_amount`      |
| `IsValidDiscountCode` (`is_valid_discount_code`)               | Cart          | Checks if the correct discount code has been provided and how many times it was used by the customer                                                          | `discount_code`, `usage_count` |

When multiple conditions are specified, all of them must be met.

As with rules, when creating a condition through other means than the user interface, you must pass the required expression values for the condition to be valid:

- using PHP, the values are passed through the constructor which converts them into an expression variable
- using data migrations and the REST API, the values are specified using the `expressionValues` key

See the following examples for data migrations and the REST API usage:

- creating discounts with [data migrations](../../content_management/data_migration/importing_data/index.md#discounts):

```yaml
-   type: discount
    mode: create
# ...
    conditions:
        -   
            identifier: is_in_currency
            expressionValues: 
                currency_code: EUR
        -
            identifier: is_product_in_array
            expressionValues:
                product_codes: 
                    - product_code_book_0
                    - product_code_book_1
```

- parsing responses from the [REST API](https://doc.ibexa.co/en/4.6/api/rest_api/rest_api_reference/rest_api_reference.html#discounts):

```json
{
    "Discount": {
        "_media-type": "application/vnd.ibexa.api.Discount+json",
        "id": 1,
        "identifier": "summersale2025",
        "name": "SummerSale2025",
        "type": "catalog",
        "label": "Summer Sale 2025",
        "labelDescription": "Summer Sale 2025",
        "priority": 1,
        "isEnabled": true,
        "createdAt": "2025-06-10T09:43:42+00:00",
        "updatedAt": "2025-06-10T09:48:23+00:00",
        "startDate": "2025-07-01T09:34:19+00:00",
        "endDate": "2025-07-31T12:00:00+00:00",
        "DiscountConditions": [
            {
                "_media-type": "application/vnd.ibexa.api.DiscountExpressionAware+json",
                "expressionValues": {
                    "currency_code": "USD"
                }
            }
        ],

}
```

### Priority

You can set discount priority as a number between 1 and 10 to indicate which discount should have [higher priority](../discounts_guide/index.md#discounts-priority) when choosing the one to apply.

### Start and end date

Discounts can be permanent, or valid only in a specified time frame.

Every discount has a start date, which defaults to the date when the discount was created. The end date can be set to `null` to make the discount permanent.

### Status

You can disable a discount anytime to stop it from being active, even if the conditions enforced by start and end date are met.

Only disabled discounts can be deleted.

### Discount translations

The discount has four properties that can be translated:

| Property              | Usage                                   |
| --------------------- | --------------------------------------- |
| Name                  | Internal information for store managers |
| Description           | Internal information for store managers |
| Promotion label       | Information displayed to customers      |
| Promotion description | Information displayed to customers      |

Use the [`Ibexa\Contracts\Discounts\Value\Struct\DiscountTranslationStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountTranslationStruct.php) to provide translations for discounts.

### Discount codes

To activate a cart discount only after a proper discount code is provided, you need to:

1. Create a discount code using the [`DiscountCodeServiceInterface::createDiscountCode()`](../../../../../ibexa/discounts-codes/src/contracts/DiscountCodeServiceInterface.php) method
2. Attach it to a discount by using the `IsValidDiscountCode` condition

Set the [`usedLimit`](../../../../../ibexa/discounts-codes/src/contracts/Value/Struct/DiscountCodeCreateStruct.php) property to the number of times a single customer can use this code, or to `null` to make the usage unlimited.

The [`DiscountCodeServiceInterface::registerUsage()`](../../../../../ibexa/discounts-codes/src/contracts/DiscountCodeServiceInterface.php) method is used to track the number of times a discount code has been used.

### Example API usage

The example below contains a Command creating a cart discount. The discount:

- has the highest possible [priority](#priority) value
- [rule](#rules) deducts 10 EUR from the base price of the product
- is [permanent](#start-and-end-date)
- [depends](#conditions) on
  - being bought from Germany or France
  - 2 products
  - a `summer10` [discount code](#discount-codes) which can be used only 10 times, but a single customer can use the code multiple times

```php
<?php

declare(strict_types=1);

namespace App\Command;

use DateTimeImmutable;
use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Discounts\DiscountServiceInterface;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountTranslationStruct;
use Ibexa\Contracts\DiscountsCodes\DiscountCodeServiceInterface;
use Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct;
use Ibexa\Discounts\Value\DiscountCondition\IsInCurrency;
use Ibexa\Discounts\Value\DiscountCondition\IsInRegions;
use Ibexa\Discounts\Value\DiscountCondition\IsProductInArray;
use Ibexa\Discounts\Value\DiscountRule\FixedAmount;
use Ibexa\DiscountsCodes\Value\DiscountCondition\IsValidDiscountCode;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'discounts:manage')]
final class ManageDiscountsCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly DiscountServiceInterface $discountService,
        private readonly DiscountCodeServiceInterface $discountCodeService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        $now = new DateTimeImmutable();

        $discountCodeCreateStruct = new DiscountCodeCreateStruct(
            'summer10',
            10, // Global usage limit
            null, // Unlimited usage per customer
            $this->permissionResolver->getCurrentUserReference()->getUserId(),
            $now
        );
        $discountCode = $this->discountCodeService->createDiscountCode($discountCodeCreateStruct);

        $discountCreateStruct = new DiscountCreateStruct();
        $discountCreateStruct
            ->setIdentifier('discount_identifier')
            ->setType(DiscountType::CART)
            ->setPriority(10)
            ->setEnabled(true)
            ->setUser($this->userService->loadUserByLogin('admin'))
            ->setRule(new FixedAmount(10))
            ->setStartDate($now)
            ->setConditions([
                new IsInRegions(['germany', 'france']),
                new IsProductInArray(['product-1', 'product-2']),
                new IsInCurrency('EUR'),
                new IsValidDiscountCode(
                    $discountCode->getCode(),
                    $discountCode->getGlobalLimit(),
                    $discountCode->getUsedLimit()
                ),
            ])
            ->setTranslations([
                new DiscountTranslationStruct('eng-GB', 'Discount name', 'This is a discount description', 'Promotion Label', 'Promotion Description'),
                new DiscountTranslationStruct('ger-DE', 'Discount name (German)', 'Description (German)', 'Promotion Label (German)', 'Promotion Description (German)'),
            ])
            ->setEndDate(null) // Permanent discount
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->setContext(new ArrayMap(['custom_context' => 'custom_value']));

        $this->discountService->createDiscount($discountCreateStruct);

        return Command::SUCCESS;
    }
}
```

Similarly, use the `deleteDiscount`, `deleteTranslation`, `disableDiscount`, `enableDiscount`, and `updateDiscount` methods from the [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) to manage the discounts. You can always attach additional logic to the Discounts API by listening to the [available events](../../api/event_reference/discounts_events/index.md).

## Search

You can search for Discounts using the [`DiscountServiceInterface::findDiscounts()`](../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) method. To learn more about the available search options, see Discounts' [Search Criteria](../../search/discounts_search_reference/discounts_criteria/index.md) and [Sort Clauses](../../search/discounts_search_reference/discounts_sort_clauses/index.md).

For discount codes, you can query the database for discount code usage using [`DiscountCodeServiceInterface::findCodeUsages()`](../../../../../ibexa/discounts-codes/src/contracts/DiscountCodeServiceInterface.php) and [`Ibexa\Contracts\DiscountsCodes\Value\Query\DiscountCodeUsageQuery`](../../../../../ibexa/discounts-codes/src/contracts/Value/Query/DiscountCodeUsageQuery.php).

## Retrieve applied discounts

The applied discounts change final product pricing. To learn more about working with prices, see [Price API](../../product_catalog/price_api/index.md#prices).

The example below shows how you can use:

- [`Ibexa\Contracts\ProductCatalog\ProductPriceServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductPriceServiceInterface.php) to query for base product prices
- [`Ibexa\Contracts\ProductCatalog\PriceResolverInterface`](../../../../../ibexa/product-catalog/src/contracts/PriceResolverInterface.php) to query for final product prices
- [`Ibexa\Contracts\ProductCatalog\Values\Price\PriceEnvelopeInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Price/PriceEnvelopeInterface.php) to retrieve applied discounts
- [`Ibexa\Contracts\OrderManagement\OrderServiceInterface`](../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) to display discount details for [orders](../../commerce/order_management/order_management/index.md)

```php
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

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'app:discounts:prices')]
final class OrderPriceCommand extends Command
{
    public function __construct(
        private readonly PermissionResolver $permissionResolver,
        private readonly UserService $userService,
        private readonly ProductServiceInterface $productService,
        private readonly OrderServiceInterface $orderService,
        private readonly ProductPriceServiceInterface $productPriceService,
        private readonly CurrencyServiceInterface $currencyService,
        private readonly PriceResolverInterface $priceResolver,
        private readonly IntlMoneyFactory $moneyFactory
    ) {
        parent::__construct();
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
```
