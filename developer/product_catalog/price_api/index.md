# Price API

Use PHP API to manage currencies in the shop and product prices.

## Currencies

To manage currencies, use [`Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/CurrencyServiceInterface.php).

To access a currency object by its code, use `CurrencyServiceInterface::getCurrencyByCode`. To access a whole list of currencies, use `CurrencyServiceInterface::findCurrencies`.

```php
$currency = $this->currencyService->getCurrencyByCode($currencyCode);
$output->writeln('Currency ID: ' . $currency->getId());

$currencies = $this->currencyService->findCurrencies();

foreach ($currencies as $currency) {
    $output->writeln('Currency ' . $currency->getId() . ' with code ' . $currency->getCode());
}
```

To create a new currency, use `CurrencyServiceInterface::createCurrency()` and provide it with a `CurrencyCreateStruct` with code, number of fractional digits and a flag indicating if the currency is enabled:

```php
$currencyCreateStruct = new CurrencyCreateStruct($newCurrencyCode, 2, true);

$this->currencyService->createCurrency($currencyCreateStruct);
```

## Prices

To manage prices, use [`Ibexa\Contracts\ProductCatalog\ProductPriceServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductPriceServiceInterface.php).

To retrieve the price of a product in the currency for the current context, use `Product::getPrice()`:

```php
$productPrice = $product->getPrice();

$output->writeln('Price for ' . $product->getName() . ' is ' . $productPrice);
```

To retrieve the price of a product in a specific currency, use `ProductPriceService::getPriceByProductAndCurrency`:

```php
$productPrice = $this->productPriceService->getPriceByProductAndCurrency($product, $currency);

$output->writeln('Price for ' . $product->getName() . ' in ' . $currencyCode . ' is ' . $productPrice);
```

To get all prices (in different currencies) for a given product, use `ProductPriceServiceInterface::findPricesByProductCode`:

```php
$prices = $this->productPriceService->findPricesByProductCode($productCode)->getPrices();

$output->writeln('All prices for ' . $product->getName() . ':');
foreach ($prices as $price) {
    $output->writeln((string) $price);
}
```

To load price definitions that match given criteria, use `ProductPriceServiceInterface::findPrices`:

```php
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency as CurrencyCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\CustomerGroup;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalOr;

// ...
        $priceCriteria = [
            new CurrencyCriterion($this->currencyService->getCurrencyByCode('USD')),
            new CustomerGroup('customer_group_1'),
            new Product('ergo_desk'),
        ];

        $priceQuery = new PriceQuery(new LogicalOr(...$priceCriteria));
        $prices = $this->productPriceService->findPrices($priceQuery);

        $output->writeln(sprintf('Found %d prices with provided criteria', $prices->getTotalCount()));
```

You can also use `ProductPriceServiceInterface` to create or modify existing prices. For example, to create a new price for a given currency, use `ProductPriceService::createProductPrice` and provide it with a `ProductPriceCreateStruct` object:

```php
$newCurrency = $this->currencyService->getCurrencyByCode($newCurrencyCode);

$money = new Money\Money(50000, new Money\Currency($newCurrencyCode));
$priceCreateStruct = new ProductPriceCreateStruct($product, $newCurrency, $money, null, null);

$this->productPriceService->createProductPrice($priceCreateStruct);
```

> **Note: Note**
>
> Prices operate using the [`Money`](https://github.com/moneyphp/money) library. That is why all amounts are provided [in the smallest unit](https://www.moneyphp.org/en/stable/getting-started.html#instantiation). For example, for euro `50000` refers to 50000 cents, equal to 500 euros.

### Resolve prices

To display a product price on a product page or in the cart, you must calculate its value based on a base price and the context. Context contains information about any price modifiers that may apply to a specific customer group. To determine the final price, or resolve the price, use the [`Ibexa\Contracts\ProductCatalog\PriceResolverInterface`](../../../../../ibexa/product-catalog/src/contracts/PriceResolverInterface.php) service, which takes the following conditions into account:

1. Existence of base price for the product in the specified currency
2. Existence of customer group-related modifiers
3. Existence of applicable [discounts](../../discounts/discounts/index.md)

If the base price in the specified currency is missing, the return value is `null`.

To resolve a price of a product in the currency for the current context, use either `PriceResolverInterface::resolvePrice()` or `PriceResolverInterface::resolvePrices()`:

```php
use Ibexa\Contracts\ProductCatalog\PriceResolverInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceContext;

// ...
        $context = new PriceContext($currency);
        $price = $this->priceResolver->resolvePrice($product, $context);

        $output->writeln('Price in ' . $currency->getCode() . ' for ' . $product->getName() . ' is ' . $price);
```

## VAT

To get information about the VAT categories and rates configured in the system, use [`Ibexa\Contracts\ProductCatalog\VatServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/VatServiceInterface.php). VAT is configured per region, so you also need to use [`Ibexa\Contracts\ProductCatalog\RegionServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/RegionServiceInterface.php) to get the relevant region object.

```php
$region = $this->regionService->getRegion('poland');
```

To get information about all VAT categories configured for the selected region, use `VatServiceInterface::getVatCategories()`:

```php
$vatCategories = $this->vatService->getVatCategories($region);

foreach ($vatCategories as $category) {
    $output->writeln($category->getIdentifier() . ': ' . $category->getVatValue());
}
```

To get a single VAT category, use `VatServiceInterface::getVatCategoryByIdentifier()` and provide it with the region object and the identifier of the VAT category:

```php
$vatCategory = $this->vatService->getVatCategoryByIdentifier($region, 'reduced');
```
