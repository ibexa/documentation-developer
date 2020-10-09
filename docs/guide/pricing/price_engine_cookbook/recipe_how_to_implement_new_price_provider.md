# Implementing new price provider

See [Price Providers](../price_engine_api/price_engine_services/chainpriceservice/price_providers/price_providers.md)
for more information.

## 1. Implement a class

Implement a new price provider class. It needs to implement `PriceProviderInterface`.
Extend `AbstractPriceProvider` if you want to use common code for calculating totals.

The provider must implement the `calculatePrices` method. This method provides a `PriceResponse` object,
the way to get the data and calculate the prices is up to you.
You can inject other services or use the data provided in the `PriceRequest`.

The example below uses the provided data and [`VatService`](../price_engine_api/price_engine_services/localvatservice.md#vatserviceinterface) to get `vatPercent`.

??? note "CustomPriceProvider"

    ``` php
    class CustomPriceProvider extends AbstractPriceProvider implements PriceProviderInterface
    // ...
        
    public function calculatePrices(PriceRequest $priceRequest)
    {
        $priceResponseLines = array();
        $additionalLines = array();

        $priceLines = $priceRequest->getLines();
        /** @var PriceLine $priceLine */
        foreach ($priceLines as $priceLine) {
            //use vat service to get the vatPercent, may return something like 19.0
            $vatPercent = $this->vatService->getVatPercentForPriceRequest($priceLine->getId(), $priceRequest);
            $vatCode = $priceLine->getVatCode();
     
            $priceResponseLines[] = $this->createResponsePriceLine(
                $priceLine,
                $vatCode,
                $vatPercent,
                $priceRequest->getCustomerVatRequired()           
            );
        }

        $responseTotals = array();
        //if you extends the AbstractPriceProvider, you can use some build-in functions 
        $totalsLines = $this->calculateTotalsForLines($priceResponseLines);
        $totalsAdditional = $this->calculateTotalsForLines($additionalLines);
        $totalsSum = $this->calculateTotalsSum(array($totalsLines, $totalsAdditional));

        $responseTotals[PriceConstants::PRICE_RESPONSE_TOTALS_LINES] = $totalsLines;
        $responseTotals[PriceConstants::PRICE_RESPONSE_TOTALS_ADDITIONAL_LINES] = $totalsAdditional;
        $responseTotals[PriceConstants::PRICE_RESPONSE_TOTALS_SUM] = $totalsSum;

        $priceResponse = new PriceResponse();
        $priceResponse->setGeneralCurrencyCode($priceRequest->getCustomerCurrency());
        $priceResponse->setSourceType(PriceConstants::PRICE_RESPONSE_SOURCE_TYPE_LOCAL);
        $priceResponse->setTotals($responseTotals);
        $priceResponse->setAdditionalLines($additionalLines);
        $priceResponse->setLines($priceResponseLines);

        return $priceResponse;
    }

    private function createResponsePriceLine(
        PriceLine $priceLine,
        $vatCode,
        $vatPercent,
        $customerVatRequired
    ) {
        $priceLineAmounts = $priceLine->getPrices();

        //get the imported base price
        /** @var PriceLineAmounts $basePrice */
        $basePrice = $priceLineAmounts[PriceConstants::PRICE_REQUEST_PRICE_TYPE_BASE];

        //calculate the prices - this is up to you...
        $unitPriceGross = $basePrice->getUnitPriceGross;
        $unitPriceNet = $basePrice->getUnitPriceNet;
        $unitPriceVat = $unitPriceGross - $unitPriceNet;
        $lineAmountGross = $unitPriceGross * $priceLine->getQuantity();
        $lineAmountNet = $unitPriceNet * $priceLine->getQuantity();
        $lineAmountVat = $lineAmountGross - $lineAmountNet;

        //set the prices
        $price = new PriceLineAmounts();
        $price->setLineAmountGross((float) $lineAmountGross);
        $price->setLineAmountNet((float) $lineAmountNet);
        $price->setLineAmountVat((float) $lineAmountVat);
        $price->setUnitPriceGross((float) $unitPriceGross);
        $price->setUnitPriceNet((float) $unitPriceNet);
        $price->setUnitPriceVat((float) $unitPriceVat);

        $listPrice = price;
        $customerPrice = price;

        //each provider must provider both - list and customer price!
        $priceResponseLinePrices[PriceConstants::PRICE_RESPONSE_PRICE_TYPE_CUSTOM] = $customerPrice;
        $priceResponseLinePrices[PriceConstants::PRICE_RESPONSE_PRICE_TYPE_LIST] = $listPrice;

        $priceResponseLine = new PriceLine();
        $priceResponseLine->setType(PriceConstants::PRICE_RESPONSE_LINE_TYPE_PRODUCT);
        $priceResponseLine->setId($priceLine->getId());
        $priceResponseLine->setQuantity($priceLine->getQuantity());
        $priceResponseLine->setSku($priceLine->getSku());
        $priceResponseLine->setVariantCode($priceLine->getVariantCode());
        $priceResponseLine->setStockNumeric($priceLine->getStockNumeric());
        $priceResponseLine->setVatCode($vatCode);
        if (!$customerVatRequired) {
            $vatPercent = 0.0;
        }
        $priceResponseLine->setVatPercent($vatPercent);
        $priceResponseLine->setPrices($priceResponseLinePrices);
        $priceResponseLine->setExtendedData($priceLine->getExtendedData());

        return $priceResponseLine;
    }
    ```

## 2. Add service definition

Add new service definition and tag it with `siso_price.price_provider`.

`vendor/silversolutions/silver.e-shop/src/Siso/Bundle/PriceBundle/Resources/config/services.xml`:

``` xml
<parameter key="siso_price.price_provider.custom.class">Siso\Bundle\PriceBundle\Service\CustomPriceProvider</parameter>
 
<service id="siso_price.price_provider.custom" class="%siso_price.price_provider.custom.class%">
    <argument type="service" id="..." />
    <tag name="siso_price.price_provider" />
</service>
```

### 3. Inject the service

Inject your service into the chain of price providers

`vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/config/silver.eshop.yml`:

``` yaml
siso_price.default.price_service_chain.basket:
    - siso_price.price_provider.custom
    - siso_price.price_provider.remote
    - siso_price.price_provider.local
```
