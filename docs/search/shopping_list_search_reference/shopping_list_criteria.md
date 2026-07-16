---
description: Shopping list search criteria help define and fine-tune search queries for shopping lists.
editions: lts-update commerce
month_change: false
---

# Shopping list search criteria reference

The criteria are in the [`Ibexa\Contracts\ShoppingList\ShoppingList\Query\Criterion` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-criterion.html)
and implement the [`Ibexa\Contracts\ShoppingList\Value\Query\CriterionInterface` interface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-CriterionInterface.html).

| Criterion                                                                                                                                     | Description                                                                |
|-----------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
| [`CreatedAtCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-CreatedAtCriterion.html)     | Find shopping lists created before or after a given date.                  |
| [`IsDefaultCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-IsDefaultCriterion.html)     | Find shopping lists that are (or are not) the default one.                 |
| [`LogicalAnd`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-LogicalAnd.html)                     | Combine the criteria passed as arguments.                                  |
| [`NameCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-NameCriterion.html)               | Find shopping lists with a name containing the given string.               |
| [`OwnerCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-OwnerCriterion.html)             | Find shopping lists belonging to the given user or one of the given users. |
| [`ProductCodeCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-ProductCodeCriterion.html) | Find shopping lists containing an entry with the given product code.       |
| [`UpdatedAtCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-UpdatedAtCriterion.html)     | Find shopping lists updated before or after a given date.                  |

The following example query returns all shopping lists available to the current user.
If the user’s permissions include the [`ShoppingListOwner` `self` limitation](limitation_reference.md#shopping-list-limitation), the query returns only lists created by that user.
Otherwise, it returns all shopping lists in the system.

``` php
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

$query = new ShoppingListQuery();
```

The following example query returns current user's shopping lists, excluding the default one, and sorts them by name:

``` php hl_lines="7-8"
[[= include_code('code_samples/shopping_list/search/criteria.php', 3, remove_indent=True) =]]
```

For more information about shopping lists search, see [List and search shopping lists](shopping_list_api.md#list-and-search-shopping-lists).
