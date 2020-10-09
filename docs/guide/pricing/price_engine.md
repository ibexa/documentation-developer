# Price engine

The price engine is responsible for calculating prices in the shop.
It can, for example, calculate prices based on imported prices and rules,
and use the business logic of the ERP system which is connected to the eZ Commerce. 

It can combine the logic of an ERP system and a local price provider
to get the best compromise between real-time data and shop performance.
In addition it offers a failover concept if ERP is not available. 

The entry point for price engine is [`ChainPriceService`](price_engine_api/price_engine_services/chainpriceservice/chainpriceservice.md),
which is used to fetch prices.

It determines a chain of price providers which are responsible for calculating the prices. 

The configuration decides which set of price providers is used.
Depending on the page (product listing, product detail, checkout etc.), different requirements have to be solved:

- a product list requires calculating a lot of prices. This can cause problems when using the business logic of the ERP.
In this case a local price provider can provide e.g. list prices quickly
- on a product detail page the customer expects to get their individual price from the ERP
- in the basket the price is always be provided by the ERP

`ChainPriceService` uses `ContextId` (e.g. `basket`, `product_list`). For each context a prioritized list of price providers can be defined.
If for example the ERP is not available, a fallback is possible.
The response for a price request contains a source so that the shop can display e.g. a warning
if the price and stock is not provided by the ERP but by a fallback price provider. 

In addition to prices, `ChainPriceService` can retrieve stock information,
since the ERP systems usually provide this information in the price request. 

## Available price providers

|Provider|Logic|Note|
|--- |--- |--- |
|Local price provider|A simple provider which gets the price from the product itself|Do not use this provider for eZ Commerce. Use ShopPriceEngine instead|
|Shop price provider|A more sophisticated price provider. Offers currency and customer group support||
|Remote price engine|Gets prices from the ERP||

## Getting prices from the price engine

This example shows how to get a price from the ERP for a given SKU `D4142`.

First, the `productNode` is fetched by the `fetchElementBySku()` method.
Afterwards, the price engine is called using the price context `basket`.
The `addPricesToProductNodes()` method enriches the product node with customer-specific prices and stock information.

For the basket a real-time request to the ERP is configured:

``` yaml
siso_price.default.price_service_chain.basket:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local
```

``` php
$skuList = array('D4142');
$catalogService = $this->getContainer()->get('silver_catalog.data_provider_service');
foreach ($skuList as $sku) {
    /** @var $catalogElement \Silversolutions\Bundle\EshopBundle\Product\ProductNode */
    $catalogElement = $catalogService->getDataProvider()->fetchElementBySku(
        $sku,
        array()
    );

    if ($catalogElement instanceof \Silversolutions\Bundle\EshopBundle\Catalog\CatalogElement) {
        $productNodeArray[] = $catalogElement;
    }
}

$catalogService = $this->getContainer()->get('silver_catalog.catalog_service');
$catalogService->addPricesToProductNodes($productNodeArray, "EUR", "basket",
    array(1));
$price = $productNodeArray[0]->customerPrice->price->price;
$isOnStock =$productNodeArray[0]->stock->isOnStock();
echo "Price: $price";
echo "OnStock: ".$isOnStock;
```

If you do not want to fetch the SKU using the data provider, you have to create a `ProductNode` manually:

``` php
$price = new \Siso\Bundle\PriceBundle\Model\Price(
    array(
        'price' => 12.00,   // Fallback price
        'isVatPrice' => true,
        'vatPercent' => (float)19,
        'currency' => 'EUR',
        'source' => 'ERP',
    )
);
$priceField = new \Silversolutions\Bundle\EshopBundle\Content\Fields\PriceField(array('price' => $price));
$attributes = array(
    'sku'     => 'D4142',
    'vatCode' => 'VATNORMAL',
    'price'   => $priceField
);
$catalogElement = new \Silversolutions\Bundle\EshopBundle\Product\OrderableProductNode($attributes, $urlService);
## If a variant is used
$variantCode = "001";
$variantService = $this->get('silver_catalog.variant_service');
$catalogElement = $variantService->createOrderableProductFromVariant($catalogElement, $variantCode);
```
