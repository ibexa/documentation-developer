---
description: CreatedAt Search Criterion
---

# CreatedAt Criterion

The `CreatedAt` Search Criterion searches for products based on the date when they were created.

## Arguments

- `createdAt` (PHP), `created_at` (REST) - indicating the date that should be matched, provided as a `DateTimeInterface` object in PHP, or as a string acceptable by `DateTime` constructor in REST
- `operator` - Operator constant (EQ, GT, GTE, LT, LTE) in PHP or its value in REST

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <CreatedAtCriterion>
                <created_at>2023-06-12</created_at>
                <operator>>=</operator>
            </CreatedAtCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Filter": {
          "CreatedAtCriterion": {
            "created_at": "2023-06-12",
            "operator": ">="
          }
        }
      }
    }
    ```
