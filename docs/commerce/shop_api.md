---
edition: commerce
---

# Shop API

Shop business API is the layer between the application entry points (like controllers or CLI commands) and the particular shop-related services.

To access the Shop business API, you have to use the Business API invocation service.
This service is the access point to the Business API and is defined by a service with the ID `Ibexa\Bundle\Commerce\Eshop\Services\BusinessLayer\BusinessApi`.

To call the operation service, use the `call()` method.

The method takes two parameters:

- `string $operationIdentifier`
- `ValueObject $operationInput`

The following example shows how to use the Business API basket operation service.

``` php
use Ibexa\Commerce\Checkout\Entities\BusinessLayer\InputValueObjects\GetBasket as InputGetBasket;
use Ibexa\Commerce\Checkout\Entities\BusinessLayer\OutputValueObjects\GetBasket as OutputGetBasket;

/** @var InputGetBasket $input */
$input = new InputGetBasket(array('request' => $request));

/** @var OutputGetBasket $output */
$output = $this->get('Ibexa\Bundle\Commerce\Eshop\Services\BusinessLayer\BusinessApi')->call('basket.get_basket', $input);
```

## Methods

| Method | Parameters  | Returns    | Description  | Operation identifier |
| ------ | ----------- | ---------- | -------- | -------------------- |
| [`addProducts`](#addproducts) | `InputAddItemToBasket $operationInput` | `OutputAddItemToBasket $operationOutput` | Adds products to the basket. | `basket.add_products` |
| [`getBasket`](#getbasket) | `InputGetBasket $input` | `OutputGetBasket $output` | Returns current basket. | `basket.get_basket` |
| [`loadProducts`](#loadproducts) | `InputLoadList $input` | `OutputLoadList $input` | Loads products from catalog. | `catalog.load_products` |

## addProducts

`basket.add_products` adds one or more products to the basket.

### Example

``` php
$outputGetBasket = $this->getBusinessApi()->call('basket.get_basket', $inputGetBasket);
// Clear all messages for each request
$outputGetBasket->basket->clearAllMessages();
$itemData = new ItemData(
    array(
        'quantity'    => '1',
        'isVariant'   => '',
        'variantCode' =>  '',
        'sku'         => '1000',
    )
);

/** @var InputAddItemToBasket $inputAddItemToBasket */
$inputAddItemToBasket = new InputAddItemToBasket(
   array(
       'itemData' => $itemData,
       'basket'   => $outputGetBasket->basket,
   )
);

try {
    $outputGetBasket = $this->getBusinessApi()->call('basket.add_products', $inputAddItemToBasket);
} catch (\InvalidArgumentException $e) {
    // ....
}

$message = $this->getBasketMessage($outputGetBasket->basket);
```

## getBasket

`basket.get_basket` gets the current basket.

### Example

``` php
use Ibexa\Commerce\Checkout\Entities\BusinessLayer\InputValueObjects\GetBasket as InputGetBasket;
use Ibexa\Commerce\Checkout\Entities\BusinessLayer\OutputValueObjects\GetBasket as OutputGetBasket;

/** @var InputGetBasket $inputGetBasket */
$inputGetBasket = new InputGetBasket(array('request' => $request));

/** @var OutputGetBasket $outputGetBasket */
$outputGetBasket = $this->getBusinessApi()->call('basket.get_basket', $inputGetBasket);

$message = $this->getBasketMessage($outputGetBasket->basket);
```

## loadProducts

`catalog.load_products` loads products from storage.

### Example call to Business API

``` php
/** @var InputLoadList $input */
$input = new InputLoadList(
    array(
        'locationId' => 136,
        'limit' => 3,
        'offset' => 3,
        'language' => 'de_DE',
        'filterType' => 'productList',
    )
);

/** @var OutputLoadList $output */
$output = $this->getBusinessApi()->call('catalog.load_products', $input);

$html = $this->renderView(
    '@Eshop/Catalog/listProductNodes.html.twig',
    array(
        'catalogList' => $output->catalogList,
        'params' => $data,
        'locationId' => $output->locationId,
    )
);
```
