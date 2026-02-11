---
description: Shopping list search sort clauses help define result order of search queries for shopping lists.
editions: lts-update commerce
month_change: true
---

# Shopping List Search Sort Clause reference

The sort clauses are in the [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-sortclause.html).

| Sort clause                                                                                                              | Description                    |
|--------------------------------------------------------------------------------------------------------------------------|--------------------------------|
| [`IsDefault`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-IsDefault.html) | Sort by being default or not   |
| [`Name`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-Name.html)           | Sort by name                   |
| [`CreatedAt`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-CreatedAt.html) | Sort by creation date          |
| [`UpdatedAt`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-SortClause-UpdatedAt.html) | Sort by last modification date |

The following example fetch all the shopping lists of the current user, the default shopping list is first, then the others shopping lists sorted by name:

```php hl_lines="6"
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\IsDefault;
use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\Name;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;
//…
$lists = $this->shoppingListService->findShoppingLists(new ShoppingListQuery(null, [new IsDefault(IsDefault::SORT_DESC), new Name()]));
```

For more information about shopping lists search, see [List and search shopping lists](shopping_list_api.md#list-and-search-shopping-lists).
