# BasePrice Sort Clause

The `BasePrice` Sort Clause sorts search results by the product's base price.

## Arguments

- `currency` - a `CurrencyInterface` object representing the currency to check price for.
- `sortDirection` (optional) - ProductQuery constant, either `ProductQuery::SORT_ASC` or `ProductQuery::SORT_DESC`.

## Limitations

The `BasePrice` Sort Clause is not available in the Legacy Search engine.

## Example

``` php
$sortClauses = [new SortClause\BasePrice($currency, ProductQuery::SORT_ASC)];
$productQuery = new ProductQuery(null, null, $sortClauses);
```
