# ProductPriceRangeAggregation

The ProductPriceRangeAggregation aggregates search results by the value of the product's price.

## Arguments

- `name` - name of the Aggregation
- `currencyCode` - code of the currency to get the price in
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductPriceRangeAggregation('price', 'PLN', [
        new \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range(0, 10000),
        new \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range(10000, 99999),
    ]),
]);
```
