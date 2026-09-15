---
description: CreatedAtRange Search Criterion
---

# CreatedAtRange Criterion

The `CreatedAtRange` Search Criterion searches for products based on the date range when they were created.

## Arguments

- `min` - indicating the beginning of the date range, provided as a `DateTimeInterface` object
- `max` - indicating the end of the date range, provided as a `DateTimeInterface` object

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <CreatedAtRange>
                <min>2023-06-12</min>
                <max>2023-06-20</max>
            </CreatedAtRange>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "CreatedAtRange": {
                    "min": "2023-06-12",
                    "max": "2023-06-20"
                }
            }
        }
    }
    ```
