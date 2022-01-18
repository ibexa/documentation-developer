# IsProductBased Criterion

The `IsProductBased` Search Criterion searches for content that plays the role of a Product.

## Limitations

The `IsUserBased` Criterion is not available in Solr or Elastic search engines.

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\IsProductBased();
```
