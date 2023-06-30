---
description: Events that are triggered when working with carts.
page_type: reference
---

# Cart events

| Event | Dispatched by | Properties |
|---|---|---|
|`AddEntryEvent`|`CartService::addEntry`|`CartInterface $cart`</br>`EntryAddStruct $entryAddStruct`</br>`CartInterface $cartResult`|
|`BeforeAddEntryEvent`|`CartService::addEntry`|`CartInterface $cart`</br>`EntryAddStruct $entryAddStruct`</br>`?CartInterface $cartResult = null`|
|`BeforeCreateCartEvent`|`CartService::createCart`|`CartCreateStruct $cartCreateStruct`</br>`?CartInterface $cartResult = null`|
|`BeforeDeleteCartEvent`|`CartService::deleteCart`|`CartInterface $cart`|
|`BeforeEmptyCartEvent`|`CartService::emptyCart`|`CartInterface $cart`|
|`BeforeMergeCartsEvent`|`CartService::mergeCarts`|`CartInterface $targetCart`</br>`array $cartsToMerge`</br>`bool $deleteMergedCarts`|
|`BeforeRemoveEntryEvent`|`CartService::removeEntry`|`CartInterface $cart`</br>`EntryInterface $entry`</br>`?CartInterface $cartResult = null`|
|`BeforeUpdateCartMetadataEvent`|`CartService::updateCartMetadata`|`CartInterface $cart`</br>`CartMetadataUpdateStruct $cartUpdateStruct`</br>`?CartInterface $cartResult = null`|
|`BeforeUpdateEntryEvent`|`CartService::updateEntry`|`CartInterface $cart`</br>`EntryInterface $entry`</br>`EntryUpdateStruct $entryUpdateStruct`</br>`?CartInterface $cartResult = null`|
|`CreateCartEvent`|`CartService::createCart`|`CartCreateStruct $cartCreateStruct`</br>`CartInterface $cartResult`|
|`DeleteCartEvent`|`CartService::deleteCart`|`CartInterface $cart`|
|`EmptyCartEvent`|`CartService::emptyCart`|`CartInterface $cart`|
|`MergeCartsEvent`|`CartService::mergeCarts`|`CartInterface $cartResult`|
|`RemoveEntryEvent`|`CartService::removeEntry`|`CartInterface $cart`</br>`EntryInterface $entry`</br>`CartInterface $cartResult`|
|`UpdateCartMetadataEvent`|`CartService::updateCartMetadata`|`CartInterface $cart`</br>`CartMetadataUpdateStruct $cartUpdateStruct`</br>`CartInterface $cartResult`|
|`UpdateEntryEvent`|`CartService::updateEntry`|`CartInterface $cart`</br>`EntryInterface $entry`</br>`EntryUpdateStruct $entryUpdateStruct`</br>`CartInterface $cartResult`|
