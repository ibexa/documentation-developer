# Product variant API [[% include 'snippets/commerce_badge.md' %]]

## VariantService

`VariantService` returns an [`OrderableVariantNode`](#orderablevariantnode)
based on [`VariantProductNode`](#variantproductnode) and `variantCode`.
It also returns all available variant codes for the `VariantProductNode`.

### Service methods

|Method|Usage|Parameters|Returns|
|--- |--- |--- |--- |
|`createOrderableProductFromVariant`|Returns `OrderableVariantNode` from `VariantProductNode`, so it can be added to a basket.|`VariantProductNode $node`</br>`string $variantCode`|`OrderableVariantNode`|
|`getVariantInformation`|Returns available variant codes for each given characteristic. If a variant is orderable it also returns its code.|`VariantProductNode $variantProduct`</br>`array $variants = array()`|`array()`|

### VariantProductNode

`VariantProductNode` is the virtual product which contains the data for all variants that can be ordered. 
Since this product has no specific price or stock which is assigned to its SKU, it cannot be added to the basket directly. 
It inherits from [`ProductNode`](../catalog_api/productnode.md) and contains additional properties. 
These properties are automatically validated within the constructor by using the `validateProperties()` method.

| Identifier             | Type          | Description                          |
| ---------------------- | ------------ | ------------------------------------ |
| `priceRange`             | `PriceField[2]`        | Contains the min and max `PriceField`  |
| `variantCharacteristics` | `VariantCharacteristicsInterface` | Contains all variant characteristics |

### OrderableVariantNode

`OrderableVariantNode` represents one specific, orderable variation. 
It is defined by its unique `VariantCode` or by the deterministic set of `VariantCharacteristics`. 
An `OrderableVariantNode` is intended to be added to a basket.

### Variant characteristics

One `VariantCharacteristic` is a specific attribute of a `VariantProduct` that is distinctive and describes one aspect of the variant. 
A `VariantProduct` must have at least one `VariantCharacteristic`.

A characteristic has a class-unique identifier and a label that is a readable name for a characteristic, for example `color` with label `Color`.

Each possible characteristic value also has a code and a label, for example `grn` and `Green` respectively.

`VariantPriceRange` is a set of two prices which represent the lowest and the highest price of all variants.
`AjaxCatalogController:getPriceAction` fetches real prices when a variant is fully specified
(that is, all options are selected and `variantCode` is in place).

## VariantSortService

`VariantSortService` returns the product variants in an ordered form, so they can be displayed in a template.

### Service methods

|Method|Usage|Parameters|Return|Twig method|
|--- |--- |--- |--- |--- |
|`sortCharacteristicCodes`|Sorts the characteristic codes|`array $characteristicCodes`</br>``$characteristicIndex`|`array()`|`sort_characteristic_codes()`|
|`sortCharacteristics`|Sorts characteristics|`array $characteristics`</br>`$type`</br>`$order`|`array()`|`sort_characteristics()`|
|`getCharacteristicsForB2B`|Gets information for B2B variant table|`VariantProductNode $catalogElement`</br>`array $order`|`array()`||
