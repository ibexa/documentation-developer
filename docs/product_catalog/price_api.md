---
description: Use PHP API to manage currencies in the shop and product prices.
---

# Price API

## Currencies

To manage currencies, use [`CurrencyServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-CurrencyServiceInterface.html).

To access a currency object by its code, use `CurrencyServiceInterface::getCurrencyByCode`.
To access a whole list of currencies, use `CurrencyServiceInterface::findCurrencies`.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 46, 53, remove_indent=True) =]]
```

To create a new currency, use `CurrencyServiceInterface::createCurrency()` and provide it with a `CurrencyCreateStruct` with code, number of fractional digits and a flag indicating if the currency is enabled:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 61, 63, remove_indent=True) =]]
```

## Prices

To manage prices, use [`ProductPriceServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductPriceServiceInterface.html).

To retrieve the price of a product in the currency for the current context, use `Product::getPrice()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 61, 63, remove_indent=True) =]]
```

To retrieve the price of a product in a specific currency, use `ProductPriceService::getPriceByProductAndCurrency`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 65, 67, remove_indent=True) =]]
```

To get all prices (in different currencies) for a given product, use `ProductPriceServiceInterface::findPricesByProductCode`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 79, 84, remove_indent=True) =]]
```

To load price definitions that match given criteria, use `ProductPriceServiceInterface::findPrices`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 12, 16) =]]
// ...
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 85, 95) =]]
```

You can also use `ProductPriceServiceInterface` to create or modify existing prices.
For example, to create a new price for a given currency, use `ProductPriceService::createProductPrice` and provide it with a `ProductPriceCreateStruct` object:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 70, 75, remove_indent=True) =]]
```

!!! note

    Prices operate using the [`Money`](https://github.com/moneyphp/money) library.
    That is why all amounts are provided [in the smallest unit](https://www.moneyphp.org/en/stable/getting-started.html#instantiation).
    For example, for euro `50000` refers to 50000 cents, equal to 500 euros.

### Resolve prices

To display a product price on a product page, you must calculate its value based on a base price and the context.
Context contains information about any price modifiers that may apply to a specific customer group.
To determine the final price, or resolve the price, use the [`PriceResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-PriceResolverInterface.html) service, which takes the following conditions into account:

1. Existence of base price for the product in the specified currency
2. Existence of customer group-related modifiers

If the base price in the specified currency is missing, the return value is `null`.

To resolve a price of a product in the currency for the current context, use either `PriceResolverInterface::resolvePrice()` or `PriceResolverInterface::resolvePrices()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 7, 8) =]][[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 11, 12) =]]
// ...
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 96, 100) =]]
```

## VAT

To get information about the VAT categories and rates configured in the system, use [`VatServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-VatServiceInterface.html).
VAT is configured per region, so you also need to use [`RegionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-RegionServiceInterface.html) to get the relevant region object.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/VatCommand.php', 42, 42, remove_indent=True) =]]
```

To get information about all VAT categories configured for the selected region, use `VatServiceInterface::getVatCategories()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/VatCommand.php', 44, 48, remove_indent=True) =]]
```

To get a single VAT category, use `VatServiceInterface::getVatCategoryByIdentifier()` and provide it with the region object and the identifier of the VAT category:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/VatCommand.php', 50, 50, remove_indent=True) =]]
```
