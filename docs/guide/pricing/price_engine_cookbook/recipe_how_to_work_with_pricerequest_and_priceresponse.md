# Working with PriceRequest and PriceResponse

## Creating a price request

To create a price request you need to set all necessary data:

``` php
private function createPriceRequest(array $catalogElements, array $catalogElementQuantities = array())
{
    $priceRequest = new PriceRequest();

    //get customer data
    /** @var CustomerProfileDataServiceInterface $customerProfileDataService */
    $customerProfileDataService = $this->get('ses.customer_profile_data.ez_erp');
    $customer = $customerProfileDataService->getCustomerProfileData();
    $hasToPayVat = (is_bool($customer->sesUser->hasToPayVat)) ? $customer->sesUser->hasToPayVat : true;

    $priceRequestLines = array();
    //loop over your catalog elements and set appropriate data
    foreach ($catalogElements as $key => $catalogElement) {
        if ($catalogElement instanceof ProductNode) {
            // if quantity is not provided in the array of quantities, assume that it is 1
            $quantity = isset($catalogElementQuantities[$key]) ? $catalogElementQuantities[$key] : 1;
            $priceRequestLines[] = $this->createRequestPriceLine($catalogElement, $key, $quantity);
        }       
    }
    $priceRequest->setLines($priceRequestLines);

    //set parties
    $priceRequest->setBuyerParty($this->customerProfileDataService->getDefaultBuyerParty());
    $priceRequest->setInvoiceParty($this->customerProfileDataService->getDefaultInvoiceParty());
    $priceRequest->setDeliveryParty($this->customerProfileDataService->getDefaultDeliveryParty());

    //set customer data
    $priceRequest->setContactNumber($customer->sesUser->contactNumber);
    $priceRequest->setCustomerNumber($customer->sesUser->customerNumber);
    $priceRequest->setCustomerVatRequired($hasToPayVat);
    $priceRequest->setCustomerCurrency($customer->sesUser->customerCurrency);

    return $priceRequest;
}

private function createRequestPriceLine(ProductNode $catalogElement, $lineNumber, $quantity = 1)
{
    $priceLine = new PriceLine();
    //use the imported list price as base price
    $listPrice = $catalogElement->price->price;

    $priceLine->setId($lineNumber);
    $priceLine->setSku($catalogElement->sku);
    if ($catalogElement instanceof OrderableVariantNode) {
        $priceLine->setVariantCode($catalogElement->variantCode);
    }
    $priceLine->setQuantity($quantity);
    $priceLine->setVatCode($catalogElement->vatCode);
    $priceLine->setVatPercent($listPrice->vatPercent);
    if ($catalogElement->stock instanceof StockField) {
        $priceLine->setStockNumeric($catalogElement->stock->stockNumeric);
    }

    $basePrice = new PriceLineAmounts();
    if ($listPrice->isVatPrice) {
        $basePrice->setUnitPriceGross($listPrice->price);
    } else {
        $basePrice->setUnitPriceNet($listPrice->price);
    }
    $priceLine->setPrices(array(PriceConstants::PRICE_REQUEST_PRICE_TYPE_BASE => $basePrice));
        
    //set some extended data, like scaled prices
    $extendedData = array(
        Ez5ScaledPriceService::SCALED_PRICES_IDENTIFIER => $catalogElement->scaledPrices
    );

    $priceLine->setExtendedData($extendedData);

    return $priceLine;
}
```

## Evaluating the price response

The price response contains all necessary information, for example list and customer prices, additional costs and totals.
It is up to you to handle it. The following example assigns prices back to catalog elements (but does not handle totals or additional costs).

``` php
public function getPricesForProductNodes(
    array $productNodes,
    array $productNodesQuantities = array()
) {
    $priceService = $this->get('siso_price.price_service.chain');

    /** @var PriceFactoryInterface $priceFactoryService */
    $priceFactoryService = $this->get('siso_price.price_factory.standard');
    /** @var CustomerProfileDataServiceInterface $customerProfileDataService */
    $customerProfileDataService = $this->get('ses.customer_profile_data.ez_erp');
    $customer = $customerProfileDataService->getCustomerProfileData();
    $customerCurrency = $customer->sesUser->customerCurrency  

    //see above
    $priceRequest = $this->createPriceRequest($productNodes, $productNodesQuantities);

    try {

        $contextId = 'product_list';
        $priceResponse = $priceService->getPrices($priceRequest, $contextId);

        // set product prices from price response
        foreach ($priceResponse->getLines() as $priceLine) {            
            $productNode = isset($productNodes[$priceLine->getId()]) ? $productNodes[$priceLine->getId()] : null;

            if ($productNode instanceof ProductNode) {
                //set list price
                $priceField = new PriceField(
                    array(
                        'price' =>
                        $priceFactoryService->createPriceFromResponseLine(
                            $priceLine,
                            $customerCurrency,
                            PriceConstants::PRICE_RESPONSE_PRICE_TYPE_LIST,
                            true
                        )
                    )
                );
                $productNode->setPrice($priceField);

                //set customer price
                $customerPriceField = new PriceField(
                    array(
                        'price' =>
                         $priceFactoryService->createPriceFromResponseLine(
                            $priceLine,
                            $customerCurrency,
                            PriceConstants::PRICE_RESPONSE_PRICE_TYPE_CUSTOM,
                            true
                        )
                    )
                );
                $productNode->setCustomerPrice($customerPriceField);

                //set stock
                $stockNumeric = $priceLine->getStockNumeric();
                if (isset($stockNumeric)) {
                    $stock = new StockField(array('stockNumeric' => $stockNumeric));
                    $productNode->setStock($stock);
                } else {
                    $productNode->setStock(StockField::getEmptyValue());
                } 
            }
        }

    } catch(PriceCalculationFailedException $p) {
       //TODO handle exception
    } catch(\Exception $e) {
       //TODO handle exception
    }
}
```
