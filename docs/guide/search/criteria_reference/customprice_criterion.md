# CustomPrice Criterion

The `CustomPrice` Search Criterion searches for products by their custom price for a specific customer group.

## Arguments

- `value` - a `Money` object representing the price in a specific currency.
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ).
- (optional) `customerGroup` - a `CustomerGroupInterface` object representing the customer group to prices prices for.
If you do not provide a customer group, the query uses the group related to the current user.

## Limitations

The `CustomPrice` Criterion is not available in the Legacy Search engine.

## Example

``` php
$query->query = new Product\Query\Criterion\CustomPrice(Money::EUR(13800), BasePrice::GTE, $customerGroup);
```
