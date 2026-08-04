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

### PHP

``` php
[[= include_code('code_samples/back_office/search/src/Query/UpdatedAtRangeQuery.php') =]]
```

### REST API

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
