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
For example, starting to use the default list from REST API will create it if it doesn't exist, as during a call to [`POST /shopping-list/default/entries](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-Lists/operation/api_shopping-listdefaultentries_post) or [`POST /cart/{identifier}/move-to-shopping-list`]().

## PHP API

TODO: [`Ibexa\Contracts\ShoppingList`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist.html)

TODO: [`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-ShoppingListServiceInterface.html)

TODO: [`Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-CartShoppingListTransferServiceInterface.html)

TODO: [Shopping list event reference](shopping_list_events.md)

## REST API

TODO: `* /shopping-list/*`

TODO: `POST /cart/{identifier}/move-entries-to-shopping-list`
TODO: `POST /cart/{identifier}/move-entries-to-shopping-list/{shoppingListIdentifier}`
TODO: `POST /cart/{identifier}/move-to-shopping-list`
TODO: `POST /cart/{identifier}/move-to-shopping-list/{shoppingListIdentifier}`
