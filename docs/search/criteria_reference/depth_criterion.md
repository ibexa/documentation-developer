---
description: Depth Search Criterion
---

# Depth Criterion

The `Location\Depth` Search Criterion searches for locations based on their depth in the content tree.

This Criterion is available only for Location Search.

## Arguments

- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the location depth(s)

The `value` argument requires:

- a list of ints for `Operator::IN`
- exactly two ints for `Operator::BETWEEN`
- a single int for other Operators
