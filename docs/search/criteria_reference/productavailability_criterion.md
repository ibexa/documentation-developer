# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by their availability.

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductAvailability(true)
);
```

### REST API

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductAvailabilityCriterion>false</ProductAvailabilityCriterion
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductAvailabilityCriterion": false
            }
        }
    }
    ```