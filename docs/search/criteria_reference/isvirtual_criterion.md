# IsVirtual Criterion

The `IsVirtual` Search Criterion searches for virtual products. 

## Arguments

- (optional) `value` - bool representing whether to search for virtual (default `true`)
or physical (`false`) products.

## Limitations

The `IsVirtual` Criterion is available in Solr or Elastic search engines.

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\IsVirtual(true)
);
```

### REST API

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <IsVirtualCriterion>true</IsVirtualCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    "ProductQuery": {
        "Filter": {
            "IsVirtualCriterion": true
        }
    }
    ```