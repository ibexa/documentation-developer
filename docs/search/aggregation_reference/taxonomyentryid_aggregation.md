# TaxonomyEntryIdAggregation

The `TaxonomyEntryIdAggregation` aggregates search results by the Content item's taxonomy entry or a product's category.

## Arguments

- `name` - name of the Aggregation object
- `taxonomyIdentifier` - identifier of the taxonomy to aggregate results by

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\TaxonomyEntryIdAggregation('taxonomy', 'tags');
```

``` php
$query = new ProductQuery();
$query->aggregations[] = new Aggregation\TaxonomyEntryIdAggregation('categories', 'product_categories');
```
