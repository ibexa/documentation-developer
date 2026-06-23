---
description: CustomPriceStatsAggregation
---

# CustomPriceStatsAggregation

The CustomPriceStatsAggregation aggregates search results by the value of the custom product's price and provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation
- `\Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface` - currency of the price
- `\Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface|null` - customer group that defines custom pricing, by default it's the one assigned to current user

## Example

``` php
use Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface;
use Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\CustomPriceStatsAggregation;

/** @var CurrencyInterface $currency */
/** @var CustomerGroupInterface $customerGroup */
$query = new ProductQuery();
$query->setAggregations([
    new CustomPriceStatsAggregation('custom_price_stats_aggregation', $currency, $customerGroup),
]);
```
