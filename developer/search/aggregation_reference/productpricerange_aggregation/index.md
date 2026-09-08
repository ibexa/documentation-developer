# ProductPriceRangeAggregation

ProductPriceRangeAggregation

The ProductPriceRangeAggregation aggregates search results by the value of the product's price.

## Arguments

- `name` - name of the Aggregation
- `currencyCode` - currency code of the price
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\ProductPriceRangeAggregation;

$query = new ProductQuery();
$query->setAggregations([
    new ProductPriceRangeAggregation('price', 'PLN', [
        Range::ofInt(0, 10000),
        Range::ofInt(10000, null),
    ]),
]);
```
