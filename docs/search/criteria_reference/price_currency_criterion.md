---
description: Price Currency Search Criterion
---

# Price Currency Criterion

The `Currency` Search Criterion searches for prices based on the given currency.

## Arguments

- `currency` - a single object or an array of `CurrencyInterface` objects that represent the currency (`Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface`)

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency;

/** @var CurrencyServiceInterface $currencyService */
$currency = $currencyService->getCurrencyByCode('EUR');

$query = new PriceQuery(
    new Currency($currency)
);
```
