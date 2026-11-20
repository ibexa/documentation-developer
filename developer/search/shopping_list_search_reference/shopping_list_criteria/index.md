# Shopping list search criteria reference

Shopping list search criteria help define and fine-tune search queries for shopping lists.

Editions: LTS Update, Commerce

The criteria are in the [`Ibexa\Contracts\ShoppingList\ShoppingList\Query\Criterion` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-criterion.html) and implement the [`Ibexa\Contracts\ShoppingList\Value\Query\CriterionInterface` interface](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/CriterionInterface.php).

| Criterion                                                                                                                                                                | Description                                                                |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------- |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\CreatedAtCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/CreatedAtCriterion.php)     | Find shopping lists created before or after a given date.                  |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\IsDefaultCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/IsDefaultCriterion.php)     | Find shopping lists that are (or are not) the default one.                 |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\LogicalAnd`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/LogicalAnd.php)                     | Combine the criteria passed as arguments.                                  |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\NameCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/NameCriterion.php)               | Find shopping lists with a name containing the given string.               |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\OwnerCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/OwnerCriterion.php)             | Find shopping lists belonging to the given user or one of the given users. |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\ProductCodeCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/ProductCodeCriterion.php) | Find shopping lists containing an entry with the given product code.       |
| [`Ibexa\Contracts\ShoppingList\Value\Query\Criterion\UpdatedAtCriterion`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/Criterion/UpdatedAtCriterion.php)     | Find shopping lists updated before or after a given date.                  |

The following example query returns all shopping lists available to the current user. If the user’s permissions include the [`ShoppingListOwner` `self` limitation](../../../permissions/limitation_reference/index.md#shopping-list-limitation), the query returns only lists created by that user. Otherwise, it returns all shopping lists in the system.

```php
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

$query = new ShoppingListQuery();
```

The following example query returns current user's shopping lists, excluding the default one, and sorts them by name:

```php
use Ibexa\Contracts\ShoppingList\Value\Query;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

/** @var \Ibexa\Contracts\Core\Repository\PermissionResolver $permissionResolver */
$query = new ShoppingListQuery(
    new Query\Criterion\LogicalAnd(
        new Query\Criterion\OwnerCriterion($permissionResolver->getCurrentUserReference()),
        new Query\Criterion\IsDefaultCriterion(false)
    ),
    [
        new Query\SortClause\Name(),
    ]
);
```

For more information about shopping lists search, see [List and search shopping lists](../../../commerce/shopping_list/shopping_list_api/index.md#list-and-search-shopping-lists).
