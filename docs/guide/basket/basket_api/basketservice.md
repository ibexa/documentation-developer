# BasketService [[% include 'snippets/commerce_badge.md' %]]

The ID of the service is `silver_basket.basket_service`.

Service methods:

|Method|Usage|Parameters|Return|
|--- |--- |--- |--- |
|`getBasket`|Returns the basket of the current user with state `new`.|`Request $request`, `string $state`|Basket|
|`getCopiedBasket`|Returns the copied basket by given origin basket ID and given state, or null if no copied basket was found.|`$originId`, `$state`|Basket or null|
|`getOrder`|Returns the order for the given basket ID, or null if no order exists.|`$basketId`|Basket or null|
|`storeBasket`|Stores the basket in the database. If necessary, the price engine is initiated and total prices are calculated and stored.</br>The `allProductsAvailable` flag is set here. If required, the catalog elements are fetched and stored again.</br>The `updateDateLastModified` parameter is used to determine whether `dateLastModified` should be updated in the basket.|`Basket $basket`, `$updateDateLastModified`|Basket - stored $basket|
|`getBasketGroupList`|Not implemented|`Basket $basket`, `$groupType`|array - a list of used codes|
|`mergeBasket`|Merges two baskets. The lines of the `additionalBasket` are assigned to the `baseBasket`.|`Basket $baseBasket`, `Basket $additionalBasket`|Basket - merged basket|
|`copyBasket`|Creates a new basket with the state `offered` based on the given basket. All attributes are copied. The new basket isn't stored in the database.|`Basket $originBasket`|Basket - copied basket|
|`removeBasket`|Removes a basket from the database. If `withAssigned` is true, all baskets that are based on this basket are removed from the database.|`Basket $basket`, `$withAssigned`||
|`cleanUpBaskets`|Removes all anonymous baskets from the storage that are older than the given `datetime`.|`Datetime $datetime`|int - a count of the removed baskets</br>in failure null|
|`getBasketsForType`|Returns a list of baskets belonging to the current user for the given type and status.|`Request $request`, `string $basketType`, `string $state`|Basket[]|
|`getBasketByUserId`|Gets a basket from the database by `userId`. If not found, a new basket is returned, but not stored in the database.|`$userId`, `$type`, `$state`, `$name`, `$splittingCode`|Basket - found or new basket|
|`getBasketBySessionId`|Gets a basket from the database by `sessionId`. If not found, a new basket is returned, but not stored in the database.|`$sessionId`, `$type`, `$state`, `$name`, `$splittingCode`|Basket - found or new basket|
|`addBasketLineToBasket`|Adds a basket line to the basket and stores the basket in the database. Used for throwing and intercepting events.|`Basket $basket`, `$sku`, `$quantity`, `$variantCode||
|`removeBasketLineFromBasket`|Removes a basket line from a basket. Used for throwing and intercepting events. Basket is not stored in the database.|`Basket $basket`, `BasketLine $basketLine`||
|`updateBasketLineInBasket`|Updates a basket line in a basket. Used for throwing and intercepting events. Basket is not stored in the database.|`Basket $basket`, `BasketLine $basketLine`, `$increase`||
|`createBasketLineForSku`|Creates a new basket line for the given SKU and `variantCode`.|`Basket $basket`, `$sku`, `$quantity`, `$variantCode`|BasketLine|
|`addBasketLineToStoredatabaseasket`|Adds a basket line to the basket.|`Basket $basket`, `$basketType`, `$sku`, `$quantity`, `null|string $variantCode`, `null|array $dataMap`||
|`validateQuantity`|Returns validated quantity as a float.|`string $quantity`|float|string|
|`isValidQuantity`|Returns true if the quantity is valid.|`string $quantity`|bool|
|`setBasketMessagesAsFlashMessages`|Adds all basket messages into a session as flash bag messages. The goal of this method is to store basket messages before, for example, a redirection, so the basket messages are not lost.|`Basket $basket`|void|
|`setFlashMessagesAsBasketMessages`|Adds session flash bag messages into basket (if there are any) and deletes the flash bag messages from session.|`Basket $basket`|void|
