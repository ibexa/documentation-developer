---
description: UpdatedAtRange Search Criterion
month_change: false
---

# UpdatedAtRange Criterion

The `UpdatedAtRange` Search Criterion searches for products based on the date range when they were last updated.

## Arguments

- `min` - the start of the date range (inclusive), provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST
- `max` - the end of the date range (inclusive), provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST

At least one of `min` or `max` must be provided.

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <UpdatedAtRangeCriterion>
                <min>2023-06-12</min>
                <max>2023-06-20</max>
            </UpdatedAtRangeCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Filter": {
          "UpdatedAtRangeCriterion": {
            "min": "2023-06-12",
            "max": "2023-06-20"
          }
        }
      }
    }
    ```
