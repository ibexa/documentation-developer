---
description: Manage shopping lists from PHP API or REST API.
editions: lts-update commerce
month_change: true
---

# Shopping list APIs

The shopping list APIs allow managing shopping lists.
The cart APIs includes methods to move products from cart to shopping list and vice versa.

## About the default shopping list

There is one default shopping list per user. This default shopping list is created only when a user uses it for the first time.

The default shopping list is created by [`\Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface::getOrCreateDefaultShoppingList()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html#method_getOrCreateDefaultShoppingList).
For example, starting to use the default list from REST API will create it if it doesn't exist, as during a call
to [`POST /shopping-list/default/entries`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-listdefaultentries_post)
or [`POST /cart/{identifier}/move-to-shopping-list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_post).

As soon a user has the create shopping list permission [`shopping_list/create`](policies.md#shopping-lists),
the default shopping list can be created regardless of the maximum shopping list count per user configuration [`max_lists_per_user`](install_shopping_list.md#configure).

## PHP API

In the [`Ibexa\Contracts\ShoppingList`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist.html) namespace are the interfaces to manipulate shopping lists.
The [`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html) defines methods to
create, get, find, update, clear, and delete shopping lists, and to add, get, move, and remove entries.

### List and search shopping lists

Shopping list search can be done with
[`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface::findShoppingLists()` method](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html#method_findShoppingLists)
with a [`Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Value-ShoppingListQuery.html)
built with criteria from the [`Ibexa\Contracts\ShoppingList\ShoppingList\Query\Criterion` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-criterion.html),
and with sort clauses from the [`Ibexa\Contracts\ShoppingList\ShoppingList\Query\SortClause` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-sortclause.html).

TODO: implementing the [`Ibexa\Contracts\ShoppingList\Value\Query\CriterionInterface` interface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-CriterionInterface.html)

To get all shopping lists (of the current user or of the whole repository depending on the current user limitation), use the search method without criterion:

```php
$lists = $this->shoppingListService->findShoppingLists(new ShoppingListQuery());
```

For more information about the shopping list search,
see [Shopping list criteria](shopping_list_criteria.md),
and [Shopping list sort clauses](shopping_list_sort_clauses.md)
references.

### Manage shopping lists entries

Methods editing the shopping list first store the change in the persistence layer then return the updated shopping list object.
If you forgot to retrieve this result in your variable, the local object isn't synchronized with the database.
In the following example, if some assignments (`$list =`) are removed, the dumped `$list` object doesn't contain the stored shopping list at that time.
If only the middle assignment is removed, the last dumped variable contains the up-to-date shopping list.

```php
$list = $this->shoppingListService->getOrCreateDefaultShoppingList();
dump($list);
$list = $this->shoppingListService->clearShoppingList($list);
dump($list);
$list = $this->shoppingListService->addEntries($list, [new EntryAddStruct($productCode)]);
dump($list);
```

You can choose to not keep the local object up-to-date until the end of your operations and just reload it when needed, for example, for display.

When adding array of entries with `ShoppingListService::addEntries()` or `ShoppingListService::moveEntries()`,
an exception is thrown if a product is already in the shopping list and the whole array is canceled.

The following example add products to a shopping list while avoiding error on duplicate.
(To stay short, this example doesn't track down duplicates, but it could be implemented for notification to the user.)

```php
$filteredProductCodes = array_filter($desiredProductCodes, function ($productCode) use ($list) {
    return !$list->getEntries()->hasEntryWithProductCode($productCode);
});
$list = $this->shoppingListService->addEntries($list, array_map(function ($productCode) { return new EntryAddStruct($productCode); }, $filteredProductCodes));
```

`ShoppingListService::moveEntries()` doesn't return an updated shopping list because several lists might be updated.

The following example moves products from a source shopping list to a target shopping list after filtering products already in the target list.
Notice how the source and target lists' variables are updated from persistence after the move:

```php
[[= include_file('code_samples/shopping_list/php_api/src/Command/ShoppingListMoveCommand.php', 44, 58) =]]
```

### Transfer between shopping list and cart

Interactions between shopping list and cart are managed by
[`Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-CartShoppingListTransferServiceInterface.html)

The following example start with an empty cart and an empty shopping list,
then add a product to the shopping list and copy it to the cart.

```php
[[= include_file('code_samples/shopping_list/php_api/src/Command/CartShoppingListTransferCommand.php', 60, 71) =]]
```

### Events

When the shopping list service methods are called, event are dispatched before and after the action so its parameters or results can be customized.
For more information, see [Shopping list event reference](shopping_list_events.md).

There is no specific event for the transfer operations.

- When adding from shopping list to cart, the [`Ibexa\Contracts\Cart\Event\BeforeAddEntryEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Event-BeforeAddEntryEvent.html) and [`Ibexa\Contracts\Cart\Event\AddEntryEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Event-AddEntryEvent.html) are dispatched for each entry that weren't previously in the cart.
- When moving from cart to shopping list, [`Ibexa\Contracts\ShoppingList\Event\BeforeAddEntriesEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Event-BeforeAddEntriesEvent.html) and [`Ibexa\Contracts\ShoppingList\Event\AddEntriesEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Event-AddEntriesEvent.html) are dispatched for the batch of entries that weren't already in the shopping list,
  then [`Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Event-BeforeRemoveEntryEvent.html) and [`Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Event-RemoveEntryEvent.html) are dispatched for each entry removed from the cart.

## REST API

The REST API has several resources to manage shopping lists and their entries
and few to move products between cart and shopping list.

This resources start with [`/shopping-list/*`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List).

TODO: Examples, at least with `GET /shopping-list` and `GET /shopping-list/{identifier}`

### Transfer between shopping list and cart

- [`POST /shopping-list/{identifier}/add-entries-to-cart`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-entries-to-cart_post) to add some shopping list entries to the default cart
- [`POST /shopping-list/{identifier}/add-entries-to-cart/{cartIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-entries-to-cart_cartIdentifier_post) to add some shopping list entries to a specific cart
- [`POST /shopping-list/{identifier}/add-to-cart`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-to-cart_post) to add all entries from a shopping list to the default cart
- [`POST /shopping-list/{identifier}/add-to-cart/{cartIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-to-cart_cartIdentifier_post) to add all entries from a shopping list to a specific cart
- [`POST /cart/{identifier}/move-entries-to-shopping-list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_post) to move some cart entries to the default shopping list
- [`POST /cart/{identifier}/move-entries-to-shopping-list/{shoppingListIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_shoppingListIdentifier_post) to move some cart entries to a specific shopping list
- [`POST /cart/{identifier}/move-to-shopping-list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_post) to move all entries from a cart to the default shopping list
- [`POST /cart/{identifier}/move-to-shopping-list/{shoppingListIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_shoppingListIdentifier_post) to move all entries from a cart to a specific shopping list
