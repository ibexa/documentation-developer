# ProductName Criterion

The `ProductName` Search Criterion searches for products by theis names.

## Arguments

- `productName` - string representing the Product name, with `*` as wildcard

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName('sofa*')
);
```

### REST API

=== "XML"

    ```xml
      <ProductQuery>
        <Filter>
          <ProductNameCriterion>sofa*</ProductNameCriterion>
        </Filter>
      </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Filter": {
          "ProductNameCriterion": "sofa*"
        }
      }
    }
    ```