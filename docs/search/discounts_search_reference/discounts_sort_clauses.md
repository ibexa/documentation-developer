---
month_change: true
editions:
    - commerce
---

# Discounts Search Sort Clauses reference

Sort Clauses are found in the [`Ibexa\Contracts\Discounts\Value\Query\SortClause`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-discounts-value-query-sortclause.html) namespace, implementing the [SortClauseInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClauseInterface.html) interface:

| Name | Description |
| --- | --- |
| [CreatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-CreatedAt.html)| Sort by discount's creation date |
| [EndDate](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-EndDate.html)| Sort by discount's end date |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Id.html)| Sort by discount's database ID |
| [Identifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Identifier.html)| Sort by discount identifier |
| [Priority](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Priority.html)| Sort by discount priority |
| [StartDate](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-StartDate.html)| Sort by discount start date |
| [Type](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Type.html)| Sort by the place where the discount activates: catalog or cart. When sorting with ascending order, cart discounts are returned first. |
| [UpdatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-UpdatedAt.html)| Sort by discount modification date |

The following example shows how to use them to sort the searched discounts:

```php hl_lines="22-24"
[[= include_file('code_samples/discounts/src/Query/Search.php') =]]
```

The returned active discounts are sorted by:

- the place where they activate: catalog or cart, with `cart` discounts returned first
- priority (descending)
- creation date (descending)

You can change the default sorting order by using the `SORT_ASC` and `SORT_DESC` constants from [`AbstractSortClause`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-AbstractSortClause.html#constants).
