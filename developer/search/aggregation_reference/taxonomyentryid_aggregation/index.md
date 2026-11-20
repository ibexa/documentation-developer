# TaxonomyEntryIdAggregation

TaxonomyEntryIdAggregation

The `TaxonomyEntryIdAggregation` aggregates search results by the content item's taxonomy entry or a product's category.

## Arguments

- `name` - name of the Aggregation object
- `taxonomyIdentifier` - identifier of the taxonomy to aggregate results by

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Taxonomy\Search\Query\Aggregation as Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\TaxonomyEntryIdAggregation('taxonomy', 'tags');
```

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\Taxonomy\Search\Query\Aggregation\TaxonomyEntryIdAggregation;

$query = new ProductQuery();
$query->setAggregations([new TaxonomyEntryIdAggregation('categories', 'product_categories')]);
```
