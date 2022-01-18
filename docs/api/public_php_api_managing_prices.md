# Managing prices

## Currencies

To manage currencies, use `CurrencyServiceInterface`.

To access a currency object by its code, use `CurrencyServiceInterface::findCurrencyByCode`.
To access a whole list of currencies, use `CurrencyServiceInterface::findCurrencies`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 50, 58) =]]
```

To create a new currency, use `CurrencyServiceInterface::createCurrency()`
and provide it with a `CurrencyCreateStruct` with code, number of fractional digits and a flag indicating if the currency is enabled:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CurrencyCommand.php', 67, 70) =]]
```

## Prices


ProductPriceService::findPricesForProductCode
ProductPriceService::getPriceByProductAndCurrency

ProductPriceService::createProductPrice
ProductPriceService::updateProductPrice



