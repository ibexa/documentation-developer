# CustomPrice Sort Clause

The `CustomPrice` Sort Clause sorts search results by the product's custom price for a selected customer group.

## Arguments

- `currency` - a `CurrencyInterface` object representing the currency to check price for
[[= include_file('docs/snippets/sort_direction.md') =]]
- (optional) `customerGroup` - a `CustomerGroupInterface` object representing the customer group to check prices for.
If you do not provide a customer group, the query uses the group related to the current user.

## Limitations

The `CustomPrice` Sort Clause is not available in the Legacy Search engine.

## Example

``` php
$sortClauses = [
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\CustomPrice(
        $currency,
        ProductQuery::SORT_ASC, $customerGroup
    )
];
$productQuery = new ProductQuery(null, null, $sortClauses);
```
