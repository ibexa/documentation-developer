---
description: Shopping list search sort clauses help define result order of search queries for shopping lists.
editions: lts-update commerce
month_change: false
---

# Shopping list search sort clauses reference

The sort clauses are in the [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-sortclause.html).

| Sort clause                                                                                                              | Description                    |
|--------------------------------------------------------------------------------------------------------------------------|--------------------------------|
| [`CreatedAt`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-CreatedAt.html) | Sort by creation date          |
| [`IsDefault`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-IsDefault.html) | Sort by being default or not   |
| [`Name`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-Name.html)           | Sort by name                   |
| [`UpdatedAt`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-UpdatedAt.html) | Sort by last modification date |

The following example returns all the shopping lists available to the current user.
The returned shopping list are sorted with the default shopping list on top, followed by the rest sorted by their name.

``` php hl_lines="10-11"
[[= include_code('code_samples/shopping_list/search/sort_clauses.php', 3, remove_indent=True) =]]
```

For more information about shopping lists search, see [List and search shopping lists](shopping_list_api.md#list-and-search-shopping-lists).
