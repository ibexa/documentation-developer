---
description: Priority Search Criterion
---

# Priority Criterion

The `Location\Priority` Search Criterion searches for locations based on their priority.

This Criterion is available only for Location Search.

## Arguments

- `operator`- Operator constant (GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the priority

The `value` argument requires:

- a list of ints for `Operator::BETWEEN`
- a single int for other Operators
