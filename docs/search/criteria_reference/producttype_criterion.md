---
description: ProductType Search Criterion
---

# ProductType Criterion

The `ProductType` Search Criterion searches for products by their codes.

## Arguments

- `productType` - array of strings representing the product type(s)

## Example

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
