# Managing prices

## Currencies

To manage currencies, use `CurrencyServiceInterface`.

To access a currency object by its code, use `CurrencyServiceInterface::getCurrencyByCode`.
To access a whole list of currencies, use `CurrencyServiceInterface::findCurrencies`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 50, 59) =]]
```

To create a new currency, use `CurrencyServiceInterface::createCurrency()`
and provide it with a `CurrencyCreateStruct` with code, number of fractional digits and a flag indicating if the currency is enabled:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 65, 68) =]]
```

## Prices

To manage prices, use `ProductPriceService`.

To retrieve the price of a product in a specific currency, use `ProductPriceService::getPriceByProductAndCurrency`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 61, 64) =]]
```

To get all prices (in different currencies) for a given product, use `ProductPriceService::findPricesByProductCode`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 76, 82) =]]
```

You can also use `ProductPriceService` to create or modify existing prices.
For example, to create a new price for a given currency, use `ProductPriceService::createProductPrice` and provide it with a `ProductPriceCreateStruct` object:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 68, 74) =]]
```

!!! note

    Prices operate using the [`Money`](https://github.com/moneyphp/money) library.
    That is why all amounts are provided [in the smallest unit](https://www.moneyphp.org/en/stable/getting-started.html#instantiation).
    For example, for euro `50000` refers to 50000 cents, equal to 50 euros.

