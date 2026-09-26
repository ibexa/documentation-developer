# Shopping list search sort clauses reference

Shopping list search sort clauses help define result order of search queries for shopping lists.

Editions: LTS Update, Commerce

The sort clauses are in the [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-sortclause.html).

| Sort clause                                                                                                                                         | Description                    |
| --------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------ |
| [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause\CreatedAt`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/SortClause/CreatedAt.php) | Sort by creation date          |
| [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause\IsDefault`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/SortClause/IsDefault.php) | Sort by being default or not   |
| [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause\Name`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/SortClause/Name.php)           | Sort by name                   |
| [`Ibexa\Contracts\ShoppingList\Value\Query\SortClause\UpdatedAt`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/SortClause/UpdatedAt.php) | Sort by last modification date |

The following example returns all the shopping lists available to the current user. The returned shopping list are sorted with the default shopping list on top, followed by the rest sorted by their name.

```php
use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\IsDefault;
use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\Name;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

/** @var \Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface $shoppingListService */
$lists = $shoppingListService->findShoppingLists(
    new ShoppingListQuery(
        null,
        [
            new IsDefault(IsDefault::SORT_DESC),
            new Name(),
        ]
    )
);
```

For more information about shopping lists search, see [List and search shopping lists](../../../commerce/shopping_list/shopping_list_api/index.md#list-and-search-shopping-lists).
