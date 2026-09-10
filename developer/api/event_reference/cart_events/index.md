# Cart events

Events that are triggered when working with carts.

Editions: Commerce

| Event                           | Dispatched by                     | Properties                                                                                                               |
| ------------------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `AddEntryEvent`                 | `CartService::addEntry`           | `CartInterface $cart` `EntryAddStruct $entryAddStruct` `CartInterface $cartResult`                                       |
| `BeforeAddEntryEvent`           | `CartService::addEntry`           | `CartInterface $cart` `EntryAddStruct $entryAddStruct` `?CartInterface $cartResult = null`                               |
| `BeforeCreateCartEvent`         | `CartService::createCart`         | `CartCreateStruct $cartCreateStruct` `?CartInterface $cartResult = null`                                                 |
| `BeforeDeleteCartEvent`         | `CartService::deleteCart`         | `CartInterface $cart`                                                                                                    |
| `BeforeEmptyCartEvent`          | `CartService::emptyCart`          | `CartInterface $cart`                                                                                                    |
| `BeforeMergeCartsEvent`         | `CartService::mergeCarts`         | `CartInterface $targetCart` `array $cartsToMerge` `bool $deleteMergedCarts`                                              |
| `BeforeRemoveEntryEvent`        | `CartService::removeEntry`        | `CartInterface $cart` `EntryInterface $entry` `?CartInterface $cartResult = null`                                        |
| `BeforeUpdateCartMetadataEvent` | `CartService::updateCartMetadata` | `CartInterface $cart` `CartMetadataUpdateStruct $cartUpdateStruct` `?CartInterface $cartResult = null`                   |
| `BeforeUpdateEntryEvent`        | `CartService::updateEntry`        | `CartInterface $cart` `EntryInterface $entry` `EntryUpdateStruct $entryUpdateStruct` `?CartInterface $cartResult = null` |
| `CreateCartEvent`               | `CartService::createCart`         | `CartCreateStruct $cartCreateStruct` `CartInterface $cartResult`                                                         |
| `DeleteCartEvent`               | `CartService::deleteCart`         | `CartInterface $cart`                                                                                                    |
| `EmptyCartEvent`                | `CartService::emptyCart`          | `CartInterface $cart`                                                                                                    |
| `MergeCartsEvent`               | `CartService::mergeCarts`         | `CartInterface $cartResult`                                                                                              |
| `RemoveEntryEvent`              | `CartService::removeEntry`        | `CartInterface $cart` `EntryInterface $entry` `CartInterface $cartResult`                                                |
| `UpdateCartMetadataEvent`       | `CartService::updateCartMetadata` | `CartInterface $cart` `CartMetadataUpdateStruct $cartUpdateStruct` `CartInterface $cartResult`                           |
| `UpdateEntryEvent`              | `CartService::updateEntry`        | `CartInterface $cart` `EntryInterface $entry` `EntryUpdateStruct $entryUpdateStruct` `CartInterface $cartResult`         |
