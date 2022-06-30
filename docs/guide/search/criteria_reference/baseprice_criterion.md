# BasePrice Criterion

The `BasePrice` Search Criterion searches for products by their base price.

## Arguments

- `value` - a `Money` object representing the price in a specific currency.
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ).

## Limitations

The `BasePrice` Criterion is not available in the Legacy Search engine.

## Example

``` php
$query->query = new Product\Query\Criterion\BasePrice(Money::EUR(12900), BasePrice::GTE);
```
