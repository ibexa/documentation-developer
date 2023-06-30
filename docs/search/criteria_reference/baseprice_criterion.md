# BasePrice Criterion

The [`BasePrice` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/Ancestor.php) searches for products by their base price.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)

## Limitations

The `BasePrice` Criterion is not available in the Legacy Search engine.

## Example

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\BasePrice(
        \Money\Money::EUR(12900),
        \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator::GTE
    )
);
```
