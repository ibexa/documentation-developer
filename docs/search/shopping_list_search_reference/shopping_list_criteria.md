---
description: TODO
editions: lts-update commerce
month_change: true
---

# Shopping List Search Criterion reference

Shopping list search can be done with
[`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface::findShoppingLists()` method](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html#method_findShoppingLists)
with a [`Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-ShoppingListQuery.html)
built with criteria from the [`Ibexa\Contracts\ShoppingList\ShoppingList\Query\Criterion` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-criterion.html),
implementing the [`Ibexa\Contracts\ShoppingList\Value\Query\CriterionInterface` interface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-CriterionInterface.html):

TODO: `Ibexa\Contracts\CoreSearch\Values\Query\Criterion\CriterionInterface` is directly used instead of the `ShoppingList` one.

| Criterion                                                                                                                                     | Description                                                                |
|-----------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
| [`IsDefaultCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-IsDefaultCriterion.html)     | Find shopping lists that are (or are not) the default one.                 |
| [`NameCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-NameCriterion.html)               | Find shopping lists with a name containing the given string.               |
| [`OwnerCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-OwnerCriterion.html)             | Find shopping lists belonging to the given user or one of the given users. |
| [`CreatedAtCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-CreatedAtCriterion.html)     | Find shopping lists created before or after a given date.                  |
| [`UpdatedAtCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-UpdatedAtCriterion.html)     | Find shopping lists updated before or after a given date.                  |
| [`ProductCodeCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-ProductCodeCriterion.html) | Find shopping lists containing an entry with the given product code.       |
| [`LogicalAnd`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-Query-Criterion-LogicalAnd.html)                     | Combine the criteria passed as arguments.                                  |

The following query example gets all shopping lists if current user doesn't have any limitation, or get all current user's lists otherwise:

```php
$query = new ShoppingListQuery();
```

The following query example gets current user's shopping lists except the default one sorted by name:

```php
$query = new ShoppingListQuery(new Query\Criterion\LogicalAnd(
    new Query\Criterion\OwnerCriterion($this->permissionResolver->getCurrentUserReference()),
    new Query\Criterion\IsDefaultCriterion(false)
), [new Query\SortClause\Name()]);
```
