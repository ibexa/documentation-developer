---
description: ProductName Search Criterion
---

# ProductName Criterion

The `ProductName` Search Criterion searches for products by their names.

## Arguments

- `productName` - string representing the Product name, with `*` as wildcard

## Example

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
