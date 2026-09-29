# Shopping list APIs

Manage shopping lists from PHP API or REST API.

Editions: LTS Update, Commerce

The shopping list APIs allow managing shopping lists. The cart APIs includes methods to move products from cart to shopping list and vice versa.

## About the default shopping list

There is one default shopping list per user. This default shopping list is created only when a user uses it for the first time.

The default shopping list is created by [`\Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface::getOrCreateDefaultShoppingList()`](../../../../../../ibexa/shopping-list/src/contracts/ShoppingListServiceInterface.php). For example, starting to use the default list from REST API will create it if it doesn't exist, as during a call to [`POST /shopping-list/default/entries`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-listdefaultentries_post) or [`POST /cart/{identifier}/move-to-shopping-list`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_post).

Note that `default` isn't the default shopping list identifier. Each user's default shopping list has a unique identifier, a hash string like `01234567-89ab-cdef-0123-456789abcdef`.

When a user has permissions to create shopping lists [`shopping_list/create`](../../../permissions/policies/index.md#shopping-lists), they can always create a default shopping list, regardless of the maximum shopping list count per user configuration [`max_lists_per_user`](../install_shopping_list/index.md#configure).

## PHP API

In the [`Ibexa\Contracts\ShoppingList`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist.html) namespace are the interfaces to manipulate shopping lists. The [`Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface`](../../../../../../ibexa/shopping-list/src/contracts/ShoppingListServiceInterface.php) defines methods to create, get, find, update, clear, and delete shopping lists, and to add, get, move, and remove entries.

### List and search shopping lists

Shopping list search can be done with [`ShoppingListServiceInterface::findShoppingLists()` method](../../../../../../ibexa/shopping-list/src/contracts/ShoppingListServiceInterface.php) with a [`Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery`](../../../../../../ibexa/shopping-list/src/contracts/Value/ShoppingListQuery.php) built with criteria from the [`Criterion` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-criterion.html) implementing the [`Ibexa\Contracts\ShoppingList\Value\Query\CriterionInterface`](../../../../../../ibexa/shopping-list/src/contracts/Value/Query/CriterionInterface.php), and with sort clauses from the [`SortClause` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist-value-query-sortclause.html).

To get all shopping lists (of the current user or of the whole repository depending on the current user limitation), use the search method without criterion:

```php
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

/** @var ShoppingListServiceInterface $shoppingListService */
$lists = $shoppingListService->findShoppingLists(new ShoppingListQuery());
```

For more information about the shopping list search, see [Shopping list criteria](../../../search/shopping_list_search_reference/shopping_list_criteria/index.md), and [Shopping list sort clauses](../../../search/shopping_list_search_reference/shopping_list_sort_clauses/index.md) references.

### Manage shopping lists entries

Methods editing the shopping list first store the change in the persistence layer then return the updated shopping list object. If you forgot to retrieve this result in your variable, the local object isn't synchronized with the database. In the following example, if some assignments (`$list =`) are removed, the dumped `$list` object doesn't contain the stored shopping list at that time. If only the middle assignment is removed, the last dumped variable contains the up-to-date shopping list.

```php
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\EntryAddStruct;

/**
 * @var ShoppingListServiceInterface $shoppingListService
 * @var string $productCode
 */
$list = $shoppingListService->getOrCreateDefaultShoppingList();
dump($list);
$list = $shoppingListService->clearShoppingList($list);
dump($list);
$list = $shoppingListService->addEntries($list, [new EntryAddStruct($productCode)]);
dump($list);
```

When adding array of entries with `ShoppingListService::addEntries()`, an exception is thrown if at least product is already in the shopping list and no entries are added to the list.

The following example adds products to a shopping list while avoiding error on duplicated entries. In this example the duplicates are ignored, but you could extend it to, for example, notify the user about each found duplicate.

```php
$filteredProductCodes = array_filter(
    $desiredProductCodes,
    static fn ($productCode): bool => !$list->getEntries()->hasEntryWithProductCode($productCode)
);
$list = $this->shoppingListService->addEntries(
    $list,
    array_map(
        static fn ($productCode): EntryAddStruct => new EntryAddStruct($productCode),
        $filteredProductCodes
    )
);
```

The following example moves products from a source shopping list to a target shopping list after filtering out products already in the target list:

```php
$entriesToRemove = [];
$entriesToAdd = [];
foreach ($movedProductCodes as $productCode) {
    if ($sourceList->getEntries()->hasEntryWithProductCode($productCode)) {
        $entriesToRemove[] = $sourceList->getEntries()->getEntryWithProductCode($productCode);
        if (!$targetList->getEntries()->hasEntryWithProductCode($productCode)) {
            $entriesToAdd[] = new EntryAddStruct($productCode);
        }
    }
}
$sourceList = $this->shoppingListService->removeEntries($sourceList, $entriesToRemove);
$targetList = $this->shoppingListService->addEntries($targetList, $entriesToAdd);
```

### Transfer between shopping list and cart

Interactions between shopping list and cart are managed by [`Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface`](../../../../../../ibexa/cart/src/contracts/CartShoppingListTransferServiceInterface.php)

The following example starts with an empty cart and an empty shopping list, then adds a product to the shopping list and copies it twice to the cart. It continues with moving the whole cart to an empty list.

```php
$this->cartService->emptyCart($cart);
$list = $this->shoppingListService->clearShoppingList($list);

$list = $this->shoppingListService->addEntries($list, [new ShoppingListEntryAddStruct($productCode)]);

$entry = $list->getEntries()->getEntryWithProductCode($productCode)->getIdentifier(); // Get entry's automatically generated identifier
$cart = $this->cartShoppingListTransferService->addSelectedEntriesToCart($list, [$entry], $cart);
$cart = $this->cartShoppingListTransferService->addSelectedEntriesToCart($list, [$entry], $cart);

dump(
    $list->getEntries()->hasEntryWithProductCode($productCode), // true as the entry is copied and not moved
    $cart->getEntries()->getEntryForProduct($this->productService->getProduct($productCode))->getQuantity() // 2 as the entry was added twice
);

$list = $this->shoppingListService->clearShoppingList($list); // Empty the list to avoid duplicate and test the move from cart

$list = $this->cartShoppingListTransferService->moveCartToShoppingList($cart, $list);
$cart = $this->cartService->getCart($cart->getIdentifier()); // Refresh local object from persistence

dump(
    $list->getEntries()->hasEntryWithProductCode($productCode), // true as, after the clear, the entry is moved from cart
    $cart->getEntries()->hasEntryForProduct($this->productService->getProduct($productCode)) // false as the entry was moved
);
```

### Events

When the shopping list service methods are called, event are dispatched before and after the action so its parameters or results can be customized. For more information, see [Shopping list event reference](../../../api/event_reference/shopping_list_events/index.md).

There is no specific event for the transfer operations.

- When adding from shopping list to cart, the [`Ibexa\Contracts\Cart\Event\BeforeAddEntryEvent`](../../../../../../ibexa/cart/src/contracts/Event/BeforeAddEntryEvent.php) and [`Ibexa\Contracts\Cart\Event\AddEntryEvent`](../../../../../../ibexa/cart/src/contracts/Event/AddEntryEvent.php) are dispatched for each entry that wasn't previously in the cart.
- When moving from cart to shopping list, single [`Ibexa\Contracts\ShoppingList\Event\BeforeAddEntriesEvent`](../../../../../../ibexa/shopping-list/src/contracts/Event/BeforeAddEntriesEvent.php) and [`Ibexa\Contracts\ShoppingList\Event\AddEntriesEvent`](../../../../../../ibexa/shopping-list/src/contracts/Event/AddEntriesEvent.php) events are dispatched for the batch of entries, then [`Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent`](../../../../../../ibexa/cart/src/contracts/Event/BeforeRemoveEntryEvent.php) and [`Ibexa\Contracts\Cart\Event\BeforeRemoveEntryEvent`](../../../../../../ibexa/cart/src/contracts/Event/RemoveEntryEvent.php) are dispatched for each entry removed from the cart.

## REST API

The REST API provides resources for managing shopping lists and their entries, as well as for moving products between the cart and the shopping list.

These resources start with [`/shopping-list/*`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List). In Symfony's `dev` environment, you can consult and test the REST API at `/api/ibexa/v2/doc#/Shopping%20List`.

The following REST example uses `curl` and [`jq`](https://jqlang.org/) to:

- log in a user
- search for the default shopping list to get its identifier
- clear the default shopping list if it exists using its identifier
- add a product to the default shopping list

```bash
# Log in and store CSRF Token
csrf_token=`curl -s -c cookie.txt -X 'POST' \
  "$BASE_URL/api/ibexa/v2/user/sessions" \
  -H 'accept: application/vnd.ibexa.api.Session+json' \
  -H 'Content-Type: application/vnd.ibexa.api.SessionInput+json' \
  -d "{
  \"SessionInput\": {
    \"login\": \"$CUSTOMER_USERNAME\",
    \"password\": \"$CUSTOMER_PASSWORD\"
  }
}" | jq -r '.Session.csrfToken'`

# Get default shopping list identifier if it exists
default_list_identifier=`curl -s -b cookie.txt -X 'GET' \
  "$BASE_URL/api/ibexa/v2/shopping-list?isDefault=true" \
  -H 'accept: application/vnd.ibexa.api.ShoppingListCollection+json' \
  | jq -r '.ShoppingListCollection.ShoppingList[0].identifier'`

# Clear default shopping list
if [ "" != "$default_list_identifier" ]; then
  curl -s -b cookie.txt -X 'POST' \
    "$BASE_URL/api/ibexa/v2/shopping-list/$default_list_identifier/clear" \
    -H 'accept: application/vnd.ibexa.api.ShoppingList+json' \
    -H "X-CSRF-Token: $csrf_token" | jq
fi

# Add entries to the default shopping list,
# create it if it doesn't exist yet,
# and get the updated data
curl -s -b cookie.txt -X 'POST' \
  "$BASE_URL/api/ibexa/v2/shopping-list/default/entries" \
  -H 'accept: application/vnd.ibexa.api.ShoppingList+json' \
  -H "X-CSRF-Token: $csrf_token" \
  -H 'Content-Type: application/vnd.ibexa.api.ShoppingListEntriesAdd+json' \
  -d "{
  \"ShoppingListEntriesAdd\": {
    \"entries\": [
      {
        \"productCode\": \"$PRODUCT_CODE\"
      }
    ]
  }
}" | jq
```

### Transfer between shopping list and cart

You can use:

- [`POST /shopping-list/{identifier}/add-entries-to-cart`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-entries-to-cart_post) to add some shopping list entries to the default cart
- [`POST /shopping-list/{identifier}/add-entries-to-cart/{cartIdentifier}`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-entries-to-cart_cartIdentifier_post) to add some shopping list entries to a specific cart
- [`POST /shopping-list/{identifier}/add-to-cart`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-to-cart_post) to add all entries from a shopping list to the default cart
- [`POST /shopping-list/{identifier}/add-to-cart/{cartIdentifier}`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Shopping-List/operation/api_shopping-list_identifieradd-to-cart_cartIdentifier_post) to add all entries from a shopping list to a specific cart
- [`POST /cart/{identifier}/move-entries-to-shopping-list`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_post) to move some cart entries to the default shopping list
- [`POST /cart/{identifier}/move-entries-to-shopping-list/{shoppingListIdentifier}`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-entries-to-shopping-list_shoppingListIdentifier_post) to move some cart entries to a specific shopping list
- [`POST /cart/{identifier}/move-to-shopping-list`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_post) to move all entries from a cart to the default shopping list
- [`POST /cart/{identifier}/move-to-shopping-list/{shoppingListIdentifier}`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart/operation/api_cart_identifiermove-to-shopping-list_shoppingListIdentifier_post) to move all entries from a cart to a specific shopping list
