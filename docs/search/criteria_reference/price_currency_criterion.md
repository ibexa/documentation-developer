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
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;

/** @var \Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface $currencyService */
$currency = $currencyService->getCurrencyByCode('EUR');

$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currency)
);
```
