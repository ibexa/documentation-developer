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

## PHP API

In the [`Ibexa\Contracts\ShoppingList`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist.html) namespace are the interfaces to manipulate shopping lists.
The [`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html) defines methods to
create, get, find, update, clear, and delete shopping lists, and to add, get, move, and remove entries.

To get all shopping lists (of the current user or of the whole repository depending on the current user limitation), use the search method without criterion:

```php
$lists = $this->shoppingListService->findShoppingLists(new ShoppingListQuery());
```

Methods editing the shopping list first store the change in the persistence layer then return the updated shopping list object.
If you forgot to retrieve this result in your variable, the local object isn't synchronized with the database.
In the following example, if the two last assignments (`$list =`) are removed, the dumped `$list` object won't contain the stored shopping list.
If only the middle assignment is removed, the dumped variable contains the up-to-date shopping list.

```php
$list = $this->shoppingListService->getOrCreateDefaultShoppingList();
$list = $this->shoppingListService->clearShoppingList($list);
$list = $this->shoppingListService->addEntries($list, [new EntryAddStruct($productCode)]);
dump($list);
```

When adding array of entries with `ShoppingListService::addEntries()` or `ShoppingListService::moveEntries()`,
an exception is thrown if a product is already in the shopping list and the whole array is canceled.

The two following examples both add products to a shopping list while avoiding error on duplicate.
(To stay short, this examples doesn't track down duplicates but it could be implemented for notification to the user.)

```php
$filteredProductCodes = array_filter($desiredProductCodes, function ($productCode) use ($list) {
    return !$list->getEntries()->hasEntryWithProductCode($productCode);
});
$list = $this->shoppingListService->addEntries($list, array_map(function ($productCode) { return new EntryAddStruct($productCode); }, $filteredProductCodes));
```

```php
foreach ($desiredProductCodes as $productCode) {
    try {
        $list = $this->shoppingListService->addEntries($list, [new EntryAddStruct($productCode)]);
    } catch (\Ibexa\Contracts\Core\Validation\ValidationFailedException $exception) {}
}
```

TODO: How to choose which solution to use between the two above?

`ShoppingListService::moveEntries()` doesn't return an updated shopping list because several lists might be updated.

The following example moves products from a source shopping list to a target shopping list after filtering products already in the target list.
Notice how the source and target lists' variables are updated from persistence after the move:

```php
$entriesToMove = [];
$entriesToRemove = [];
foreach ($movedProductCodes as $productCode) {
    if ($targetList->getEntries()->hasEntryWithProductCode($productCode)) {
        $entriesToRemove[] = $sourceList->getEntries()->getEntryWithProductCode($productCode);
    } else {
        $entriesToMove[] = $sourceList->getEntries()->getEntryWithProductCode($productCode);
    }
}
$this->shoppingListService->moveEntries($targetList, $entriesToMove);
$targetList = $this->shoppingListService->getShoppingList($targetList->getIdentifier()); // Refresh local object from persistence
$sourceList = $this->shoppingListService->removeEntries($sourceList, $entriesToRemove); // Refresh local object from persistence even if $entriesToRemove is empty
```

When the shopping list service methods are called, event are dispatched before and after the action so its parameters or results can be customized.
TODO: Event example?
For more information, see [Shopping list event reference](shopping_list_events.md).

Interactions between shopping list and cart are managed by
[`Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-CartShoppingListTransferServiceInterface.html)

TODO: example and reco. Maybe clarify duplicate handling of this case methods

There is no specific event for the transfer operations.

- When adding from shopping list to cart, the `Ibexa\Contracts\Cart\Event\BeforeAddEntryEvent` and `Ibexa\Contracts\Cart\Event\AddEntryEvent` are dispatched for each entry that weren't previously in the cart.
- When moving from cart to shopping list, `Ibexa\Contracts\ShoppingList\Event\BeforeAddEntriesEvent` and `Ibexa\Contracts\ShoppingList\Event\AddEntriesEvent` are dispatched for the batch of entries that weren't already in the shopping list,
  then `Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent` and `Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent` are dispatched for each entry removed from the cart.

## REST API

The REST API has several resources to manage shopping lists and their entries
and few to move products between cart and shopping list.

TODO: [`/shopping-list/*`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List)

TODO: [`POST /cart/{identifier}/move-entries-to-shopping-list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_post)
TODO: [`POST /cart/{identifier}/move-entries-to-shopping-list/{shoppingListIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_shoppingListIdentifier_post)
TODO: [`POST /cart/{identifier}/move-to-shopping-list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_post)
TODO: [`POST /cart/{identifier}/move-to-shopping-list/{shoppingListIdentifier}`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_shoppingListIdentifier_post)
