# CustomPrice Sort Clause

The `CustomPrice` Sort Clause sorts search results by the product's custom price for a selected customer group.

## Arguments

- `currency` - a `CurrencyInterface` object representing the currency to check price for.
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.
- `customerGroup` (optional) - a `CustomerGroupInterface` object representing the customer group to check prices for.
If you do not provide a customer group, the query uses the group related to the current user.

## Limitations

The `CustomPrice` Sort Clause is not available in the Legacy Search engine.

## Example

``` php
$sortClauses = [new SortClause\CustomPrice($currency, ProductQuery::SORT_ASC, $customerGroup)];
$productQuery = new ProductQuery(null, null, $sortClauses);
```
