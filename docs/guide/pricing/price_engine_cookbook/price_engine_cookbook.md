# Price engine cookbook

## Using the price engine

The entry point to the price engine is [`ChainPriceService`](../price_engine_api/price_engine_services/chainpriceservice/chainpriceservice.md).
If you want to get prices from the price engine, you have to use this service.
See [Working with PriceRequest and PriceResponse](recipe_how_to_work_with_pricerequest_and_priceresponse.md) to find out how to work with PriceRequest and PriceResponse.

Example:

``` php
public function getPricesAction()
{
    //create new PriceRequest instance with appropriate data
    $priceRequest = $this->createPriceRequest(array($catalogElement), array(1));
    $contextId = 'product_detail';

    try {
        $priceService = $this->get('siso_price.price_service.chain');
        /** @var PriceResponse $priceResponse **/
        $priceResponse = $priceService->getPrices($priceRequest, $contextId);
    } catch(Siso\Bundle\PriceBundle\Exception\PriceRequestFailedException $e) {
        //...no prices were provided by any price provider
    }

    //@todo - evaluate the $priceResponse, e.g. assign the prices to your catalog element
    
}
```

## Getting prices for catalog elements

To get the prices and stock information for your catalog element(s),
use the `CatalogService` that contains helper methods to create the PriceRequest.

It also assigns the correct prices and stock back to catalog element(s).

``` php
public function getPricesForCatalogElement($catalogElement)
{
    /** @var CatalogService $catalogService */
    $catalogService = $this->container->get('silver_catalog.catalog_service');
    /** @var CustomerProfileDataServiceInterface $customerProfileDataService */
    $customerProfileDataService = $this->get('ses.customer_profile_data.ez_erp');

    $productNodeArray = array($catalogElement);
    $quantity= 1;
    $contextId = 'product_detail';
    $customerProfileData = $customerProfileDataService->getCustomerProfileData();
    $customerCurrency = $customerProfileData->sesUser->customerCurrency;

    $catalogService->addPricesToProductNodes($productNodeArray, $customerCurrency, $contextId,
        array($quantity));

    //catalog element has correct prices and stock
    return $catalogElement;
}
```

## Checking which price provider is used in the basket

It can be useful to know which price provider is used to calculate a price (e.g. in the basket).
Thanks to this you can, for example, enable special payment methods if you can be sure that the ERP was able to provide real-time prices
or even disable the checkout if the ERP is not able to provide prices. 

The basket contains a `priceResponseSourceType` attribute which contains the source type of the price provider:

![](../../img/price_engine_2.png)

`remote` means that the ERP provided the prices for the current basket. 

## Configuring chain of price providers

To use different providers depending on the context (e.g. basket page, product detail page), set up the following configuration:

``` yaml
siso_price.default.price_service_chain.product_list:
    - siso_price.price_provider.local

siso_price.default.price_service_chain.product_detail:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.slider_product_list:
    - siso_price.price_provider.local

siso_price.default.price_service_chain.basket:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.stored_basket:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.wish_list:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.quick_order:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.comparison:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local
```

In this example if the context in which you want to calculate prices, is product detail page,
the price engine calls the remote price provider to get proper prices first.

If the remote price provider fails to deliver, local price provider calculates the prices.

Other scenarios could be added, like a cache price provider, which could first check if prices are available in cache.

#### Configure the service ID of the remote price provider

Remember to configure the service ID of the remote price provider.
This configuration is used to set an error message in the basket if the remote price provider is not able to calculate the prices.

``` yaml
parameters:
    siso_price.default.price_service_chain_remote: siso_price.price_provider.remote
```

## Passing additional information to priceRequest from catalogElement

You can use an event listener to enhance the `priceRequest` with additional information,
which could be required to correctly calculate the price.

The `PriceLineRequestListener` listener that works with `PriceLineRequestEvent` adds additional information from catalog element to each attribute specified in configuration:

``` yaml
siso_price.default.price_request_extended_data: [ 'path', 'otherAttribute']
```

For every `PriceLine` object inside `PriceRequest` the listener searches both in `catalogElement` attributes and `dataMap` for those attributes.
If they are available, it adds them to `ExtendedData` of every `PriceLine` object.

You can also add information to `PriceRequest` itself, not only for every `PriceLine` object.
To do this, implement an event listener for `PriceRequestEvent`.

For reference on how to write a listener see the implementation for `PriceLineRequestListener`.

## Price calculation events

``` php
/**
 * Defines constants for price events.
 */
final class PriceEvents
{
    /**
     * This event must be dispatched before price line request is sent
     *
     * Events in the standard implementation:
     * - After a price request line was completely constructed in the basket
     *   price calculation (in the BasketService)
     * - After a price request line was completely constructed in the catalog
     *   price calculation (in the CatalogService)
     *
     * @see Siso\Bundle\PriceBundle\Event\PriceLineRequestEvent
     * @var string
     */
    const PRICE_LINE_REQUEST = 'siso_price.price_line_request';

    /**
     * This event must be dispatched before price request is sent
     *
     * Events in the standard implementation:
     * - After a price request was completely constructed in the basket
     *   price calculation (in the BasketService)
     * - After a price request was completely constructed in the catalog
     *   price calculation (in the CatalogService)
     *
     * @see Siso\Bundle\PriceBundle\Event\PriceRequestEvent
     * @var string
     */
    const PRICE_REQUEST = 'siso_price.price_request';
}
```

Example listener service definition:

``` xml
<service id="custom.price_line_request_listener" class="%custom.price_line_request_listener.class%">
    <tag name="kernel.event_listener" event="siso_price.price_line_request" method="onPriceLineRequest" />
</service>
```

Example listener implementation:

``` php
namespace Example\EventListener;

use Silversolutions\Bundle\EshopBundle\Catalog\CatalogElement;
use Siso\Bundle\PriceBundle\Event\PriceLineRequestEvent;

/**
 * Example listener
 */
class PriceLineRequestListener
{

    /**
     * @param PriceLineRequestEvent $event
     */
    public function onPriceLineRequest(PriceLineRequestEvent $event)
    {
        $catalogElement = $event->getCatalogElement();
        $priceLine = $event->getPriceLine();

        $priceLine->setExtendedData(
            array(
                'new_field' => $catalogElement->getField('new_field')->toString(),
            )
        );
    }
}
```
