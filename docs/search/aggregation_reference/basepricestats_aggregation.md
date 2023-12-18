# BasePriceStatsAggregation

The BasePriceStatsAggregation aggregates search results by the value of the product's price
and provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation
- `currencyCode` - currency code of the price

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new BasePriceStatsAggregation('base_price_stats_aggregation', $currency),
]);
```