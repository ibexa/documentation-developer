# BasePriceStatsAggregation

BasePriceStatsAggregation

The BasePriceStatsAggregation aggregates search results by the value of the product's price can provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation
- `\Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface` - currency of the price

## Example

```php
use Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\BasePriceStatsAggregation;

/** @var CurrencyInterface $currency */
$query = new ProductQuery();
$query->setAggregations([
    new BasePriceStatsAggregation('base_price_stats_aggregation', $currency),
]);
```
