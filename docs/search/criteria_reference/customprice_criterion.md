# CustomPrice Criterion

The `CustomPrice` Search Criterion searches for products by their custom price for a specific customer group.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)
- (optional) `customerGroup` - a `CustomerGroupInterface` object representing the customer group to show prices for.
If you do not provide a customer group, the query uses the group related to the current user.

## Limitations

The `CustomPrice` Criterion is not available in the Legacy Search engine.

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CustomPrice(
        \Money\Money::EUR(13800),
        \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator::GTE,
        $customerGroup)
);
```
