# ProductCategory Criterion

The `ProductCategory` Search Criterion searches for products by the category they are assigned to.

## Arguments

- `taxonomyEntries` - array of ints representing category IDs

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCategory([2, 3])
);
```

### REST API

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductCategoryCriterion>[2, 3]</ProductCategoryCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductCategoryCriterion": [
                    2,
                    3
                ]
            }
        }
    }
    ```
