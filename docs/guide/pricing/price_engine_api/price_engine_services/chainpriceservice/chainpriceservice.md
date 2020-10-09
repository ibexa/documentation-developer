# ChainPriceService

`ChainPriceService` is the base entry point to the price engine. This service gets prices depending on the `$contextId`.
`$contextId` is a parameter that indicates the context in which the prices should be calculated, e.g. basket, product list or product detail.

`ChainPriceService` does not calculate the prices by itself. It calls [price providers](price_providers/price_providers.md) in a chain depending on the configuration.

If an error occurs, the price provider throws an exception and the next provider in the chain is used.
If the first provider returns prices, they are returned back to the caller. The next price provider is not executed.

If none of the price providers return prices, an exception is thrown and empty prices and empty stock must be set.

## Configuration

Service ID: `siso_price.price_service.chain`

Chain configuration example for basket:

``` yaml
#the last part of the parameter name (here basket) must match the $contextId!
siso_price.default.price_service_chain.basket:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local 
```

# PriceServiceInterface

|Method|Description|
|--- |--- |
|`public function getPrices(PriceRequest $priceRequest, $contextId);`|This method always returns an instance of `PriceResponse` or throws `PriceRequestFailedException`. The price service determines a price provider that performs the price calculations depending on the context. If no provider is able to properly calculate the prices, it throws a `PriceRequestFailedException`.|
