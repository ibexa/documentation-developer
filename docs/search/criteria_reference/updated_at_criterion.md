---
description: UpdatedAt Search Criterion
month_change: false
---

# UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for products based on the date when they were last updated.

## Arguments

- `date` - indicating the date that should be matched, provided as a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object in PHP, or as a string acceptable by `DateTimeInterface` constructor in REST
- `operator` - Operator constant (EQ, GT, GTE, LT, LTE) in PHP or its value in REST

## Operators

| Operator | Value | Description |
|----------|-------|-------------|
| `Operator::EQ` | `=` | Matches products updated exactly on the given date (default) |
| `Operator::GT` | `>` | Matches products updated after the given date |
| `Operator::GTE` | `>=` | Matches products updated on or after the given date |
| `Operator::LT` | `<` | Matches products updated before the given date |
| `Operator::LTE` | `<=` | Matches products updated on or before the given date |

## Example

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
