# ProductType Criterion

The `ProductType` Search Criterion searches for products by their codes.

## Arguments

- `productType` - array of strings representing the Product type(s)

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductType(['dress'])
);
```

### REST API

=== "XML"

    ```xml
      <ProductQuery>
        <Filter>
            <ProductTypeCriterion>desk</ProductTypeCriterion>
        </Filter>
      </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Filter": {
          "ProductTypeCriterion": "desk"
        }
      }
    }
    ```