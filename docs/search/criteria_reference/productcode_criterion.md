---
description: ProductCode Search Criterion
---

# ProductCode Criterion

The `ProductCode` Search Criterion searches for products by their codes.

## Arguments

- `productCode` - array of strings representing the product codes(s)

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCode;

$query = new ProductQuery(
    null,
    new ProductCode(['ergo_desk', 'alter_desk'])
);
```

### REST API

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
