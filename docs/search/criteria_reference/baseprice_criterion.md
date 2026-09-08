---
description: BasePrice Search Criterion
---

# BasePrice Criterion

The `BasePrice` Search Criterion searches for products by their base price.

## Arguments

- `value` - a `Money\Money` object representing the price in a specific currency
- (optional) `operator` - Operator constant (EQ, GT, GTE, LT, LTE, default EQ)

## Limitations

The `BasePrice` Criterion isn't available in the Legacy Search engine.
