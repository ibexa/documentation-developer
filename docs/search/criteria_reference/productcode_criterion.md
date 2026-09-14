---
description: ProductCode Search Criterion
---

# ProductCode Criterion

The `ProductCode` Search Criterion searches for products by their codes.

## Arguments

- `productCode` - array of strings representing the product codes(s)

## Example

=== "XML"

```xml
<ProductQuery>
    <Filter>
        <ProductCodeCriterion>ski</ProductCodeCriterion>
        <ProductCodeCriterion>snowboard</ProductCodeCriterion>
    </Filter>
</ProductQuery>
```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductCodeCriterion": [
                    "ski",
                    "snowboard"
                ]
            }
        }
    }
    ```
