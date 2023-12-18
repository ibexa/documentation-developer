# CustomPriceStatsAggregation

The CustomPriceStatsAggregation aggregates search results by the value of the custom product's price 
and provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation
- `currencyCode` - currency code of the price
- `customerGroup` - customer group that defines custom pricing

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new CustomPriceStatsAggregation('custom_price_stats_aggregation', $currency, $customerGroup),
]);
```