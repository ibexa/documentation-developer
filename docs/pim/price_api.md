---
description: Use PHP API to manage currencies in the shop and product prices.
---

# Price API

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

To retrieve the price of a product in the currency for the current context, use `Product::getPrice()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 61, 64) =]]
```

To retrieve the price of a product in a specific currency, use `ProductPriceService::getPriceByProductAndCurrency`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 65, 68) =]]
```

To get all prices (in different currencies) for a given product, use `ProductPriceService::findPricesByProductCode`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 81, 85) =]]
```

You can also use `ProductPriceService` to create or modify existing prices.
For example, to create a new price for a given currency, use `ProductPriceService::createProductPrice` and provide it with a `ProductPriceCreateStruct` object:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 72, 78) =]]
```

!!! note

    Prices operate using the [`Money`](https://github.com/moneyphp/money) library.
    That is why all amounts are provided [in the smallest unit](https://www.moneyphp.org/en/stable/getting-started.html#instantiation).
    For example, for euro `50000` refers to 50000 cents, equal to 50 euros.

## VAT

To get information about the VAT categories and rates configured in the system, use `VatServiceInterface`.
VAT is configured per region, so you also need to use `RegionServiceInterface` to get the relevant region object.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 49, 50) =]]
```

To get information about all VAT categories configured for the selected region, use `VatServiceInterface::getVatCategories()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 51, 56) =]]
```

To get a single VAT category, use `VatServiceInterface::getVatCategoryByIdentifier()` and provide it with the region object and the identifier of the VAT category:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 57, 59) =]]
```
