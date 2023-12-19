# BasePrice Criterion

The [`BasePrice` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-BasePrice.html) searches for products by their base price.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)

## Limitations

The `BasePrice` Criterion is not available in the Legacy Search engine.

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\BasePrice(
        \Money\Money::EUR(12900),
        \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator::GTE
    )
);
```
