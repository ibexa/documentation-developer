---
description: BasePrice Search Criterion
---

# BasePrice Criterion

The [`BasePrice` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-BasePrice.html) searches for products by their base price.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)

## Limitations

The `BasePrice` Criterion isn't available in the Legacy Search engine.

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\BasePrice;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator;
use Money\Money;

$query = new ProductQuery(
    null,
    new BasePrice(
        Money::EUR(12900),
        Operator::GTE
    )
);
```
