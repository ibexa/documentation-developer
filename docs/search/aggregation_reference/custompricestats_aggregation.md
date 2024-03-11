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
- `\Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface` - currency of the price
- `\Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface|null` - customer group that defines custom pricing, by default it is the one assigned to current user

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new CustomPriceStatsAggregation('custom_price_stats_aggregation', $currency, $customerGroup),
]);
```