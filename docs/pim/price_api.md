---
description: Use PHP API to manage currencies in the shop and product prices.
---

# Price API

## Currencies

To manage currencies, use `CurrencyServiceInterface`.

To access a currency object by its code, use `CurrencyServiceInterface::getCurrencyByCode`.
To access a whole list of currencies, use `CurrencyServiceInterface::findCurrencies`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 52, 61) =]]
```

To create a new currency, use `CurrencyServiceInterface::createCurrency()` and provide it with a `CurrencyCreateStruct` with code, number of fractional digits and a flag indicating if the currency is enabled:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 67, 71) =]]
```

## Prices

To manage prices, use `ProductPriceService`.

To retrieve the price of a product in the currency for the current context, use `Product::getPrice()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 79, 82) =]]
```

To retrieve the price of a product in a specific currency, use `ProductPriceService::getPriceByProductAndCurrency`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 83, 86) =]]
```

To get all prices (in different currencies) for a given product, use `ProductPriceService::findPricesByProductCode`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 97, 103) =]]
```

To load price definitions that match given criteria, use `ProductPriceServiceInterface::findPrices`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 12, 16) =]]
// ...
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 104, 114) =]]
```

You can also use `ProductPriceService` to create or modify existing prices.
For example, to create a new price for a given currency, use `ProductPriceService::createProductPrice` and provide it with a `ProductPriceCreateStruct` object:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 79, 85) =]]
```

!!! note

    Prices operate using the [`Money`](https://github.com/moneyphp/money) library.
    That is why all amounts are provided [in the smallest unit](https://www.moneyphp.org/en/stable/getting-started.html#instantiation).
    For example, for euro `50000` refers to 50000 cents, equal to 500 euros.

### Resolve prices

To display a product price on a product page or in the cart, you must calculate its value based on a base price and the context.
Context contains information about any price modifiers that may apply to a specific customer group.
To determine the final price, or resolve the price, use the `PriceResolverInterface` service, which uses the following logic:

1. Checks whether a price exists for the product and currency, returns `null` if no such price exists.
2. Verifies whether a customer group-related modifier exists:
    1. If yes, it returns a custom price that is valid for the selected customer group.
    2. If not, it returns a base product price in the selected currency.

To resolve a price of a product in the currency for the current context, use either `PriceResolverInterface::resolvePrice()` or `PriceResolverInterface::resolvePrices()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 7, 8) =]][[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 11, 12) =]]
// ...
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 115, 119) =]]
```

## VAT

To get information about the VAT categories and rates configured in the system, use `VatServiceInterface`.
VAT is configured per region, so you also need to use `RegionServiceInterface` to get the relevant region object.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 54, 55) =]]
```

To get information about all VAT categories configured for the selected region, use `VatServiceInterface::getVatCategories()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 56, 61) =]]
```

To get a single VAT category, use `VatServiceInterface::getVatCategoryByIdentifier()` and provide it with the region object and the identifier of the VAT category:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/VatCommand.php', 62, 64) =]]
```
