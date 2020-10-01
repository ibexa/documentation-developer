# Basket API

## How to work with the API

### Get current basket

``` php
/** @var BasketService $basketService */
$basketService = $this->getBasketService();
/** @var Basket $basket */
$basket = $basketService->getBasket($request);
```

### Get all baskets with a confirmed payment

**Request all orders**

``` php
/** @var Basket[] $baskets_payed_all */
$baskets_payed_all = $this->get('silver_basket.basket_repository')->findByState(BasketService::STATE_PAYED);
$baskets_payed = array();

// filter baskets that already have an ERP id
foreach ($baskets_payed_all as $basket) {
    // is order already stored in the ERP?
    $erpOrderId = $basket->getErpOrderId();
    if (!empty($erpOrderId)) {
        $baskets_payed[] = $basket;
    }
}
```

### How to add products to the current basket:

**Add a product to the basket**

``` php
/** @var BasketService $basketService */
$basketService = $this->getBasketService();

/** @var Basket $basket */
$basket = $basketService->getBasket($request);
 
// Define products to be added 
$itemData = new ItemData(
    array(
        'quantity' => '1',
        'isVariant' => '',
        'variantCode' => '',
        'sku' => trim($product)
    )
);

/** @var InputAddItemToBasket $inputAddItemToBasket */
$inputAddItemToBasket = new InputAddItemToBasket(
    array(
        'itemData' => $itemData,
        'basket' => $basket
    )
);
try {
    /** @var OutputAddItemToBasket $outputAddItemToBasket */
    $outputAddItemToBasket = $this->getBusinessApi()->call('basket.add_products', $inputAddItemToBasket);
} catch (\Exception $e) {
    // error handling 
}
 
$basketService->storeBasket($basket);
```

### Get stored baskets for a given user

``` php
/** @var BasketRepository $basketRepository */
$basketRepository = $this->getBasketRepository();
$storedBasketsList = $basketRepository->getAllStoredBasketsByUserId($customerProfileData->sesUser->sesUserObjectId);
```
