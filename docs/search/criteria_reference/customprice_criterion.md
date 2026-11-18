---
description: CustomPrice Search Criterion
---

# CustomPrice Criterion

The `CustomPrice` Search Criterion searches for products by their custom price for a specific customer group.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)
- (optional) `customerGroup` - a `CustomerGroupInterface` object representing the customer group to show prices for.
If you don't provide a customer group, the query uses the group related to the current user.

## Limitations

The `CustomPrice` Criterion isn't available in the Legacy Search engine.

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CustomPrice;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator;
use Money\Money;

/** @var CustomerGroupInterface $customerGroup */
$query = new ProductQuery(
    null,
    new CustomPrice(
        Money::EUR(13800),
        Operator::GTE,
        $customerGroup
    )
);
```
