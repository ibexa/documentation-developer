---
description: CreatedAt Search Criterion
---

# CreatedAt Criterion

The `CreatedAt` Search Criterion searches for products based on the date when they were created.

## Arguments

- `created_at` - indicating the date that should be matched, provided as a string acceptable by[`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) constructor
- `operator` - Operator value

## Operators

| Value | Description |
|-------|-------------|
| `=` | Matches products updated exactly on the given date (default) |
| `>` | Matches products updated after the given date |
| `>=` | Matches products updated on or after the given date |
| `<` | Matches products updated before the given date |
| `<=` | Matches products updated on or before the given date |

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
