---
description: UpdatedAt Search Criterion
month_change: true
---

# UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for products based on the date when they were last updated.

## Arguments

- `date` - indicating the date that should be matched, provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST
- `operator` - Operator constant (EQ, GT, GTE, LT, LTE) in PHP or its value in REST

## Operators

| Operator | Value | Description |
|----------|-------|-------------|
| [`Operator::EQ`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-Operator.html#constant_EQ) | `=` | Matches products updated exactly on the given date (default) |
| [`Operator::GT`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-Operator.html#constant_GT) | `>` | Matches products updated after the given date |
| [`Operator::GTE`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-Operator.html#constant_GTE) | `>=` | Matches products updated on or after the given date |
| [`Operator::LT`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-Operator.html#constant_LT) | `<` | Matches products updated before the given date |
| [`Operator::LTE`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-Operator.html#constant_LTE) | `<=` | Matches products updated on or before the given date |

## Example

### PHP

``` php
[[= include_file('code_samples/back_office/search/src/Query/UpdatedAtQuery.php') =]]
```

### REST API

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <UpdatedAtCriterion>
                <updated_at>2023-06-12</updated_at>
                <operator>>=</operator>
            </UpdatedAtCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Filter": {
          "UpdatedAtCriterion": {
            "updated_at": "2023-06-12",
            "operator": ">="
          }
        }
      }
    }
    ```
