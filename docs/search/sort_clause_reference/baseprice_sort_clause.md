---
description: BasePrice Sort Clause
---

# BasePrice Sort Clause

The `BasePrice` Sort Clause sorts search results by the product's base price.

## Arguments

- `currency` - a `CurrencyInterface` object representing the currency to check price for
- (optional) `sortDirection` - ProductQuery constant, either `ProductQuery::SORT_ASC` or `ProductQuery::SORT_DESC`

## Limitations

The `BasePrice` Sort Clause isn't available in the Legacy Search engine.
