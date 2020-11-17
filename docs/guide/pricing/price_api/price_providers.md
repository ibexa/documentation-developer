# Price providers

A price provider fetches or calculates the prices for the price request. If an error occurs or the prices cannot be calculated properly,
the price provider throws a `PriceCalculationFailedException`, which passes the price calculation to the [price service](#chainpriceservice).

Every price provider must return both `list_price` and `custom_price`.

All price providers must use the `siso_price.price_provider` tag.

## PriceProviderInterface

|Method|Description|
|--- |--- |
|`calculatePrices()`|Returns an instance of `PriceResponse` or throws `PriceCalculationFailedException`.|

## ChainPriceService

`ChainPriceService` (service ID: `siso_price.price_service.chain`) is the base entry point to the price engine. This service gets prices depending on the `contextId`.
`contextId` is a parameter that indicates the context in which prices should be calculated, e.g. basket, product list or product detail.

`ChainPriceService` does not calculate the prices by itself. It calls price providers in a chain depending on the configuration.

If an error occurs, the price provider throws an exception and the next provider in the chain is used.
If the first provider returns prices, they are returned back to the caller. The next price provider is not executed.

If none of the price providers return prices, an exception is thrown and empty prices and empty stock are set.

### Configuration

Chain configuration example for basket:

``` yaml
siso_price.default.price_service_chain.basket:
    - siso_price.price_provider.remote
    - siso_price.price_provider.local 
```

### PriceServiceInterface

|Method|Description|
|--- |--- |
|`getPrices()`|Returns an instance of `PriceResponse` or throws `PriceRequestFailedException`. The price service determines the price provider that performs the price calculations depending on the context. If no provider is able to properly calculate the prices, it throws a `PriceRequestFailedException`.|

## LocalPriceProvider

The local price provider can calculate prices based on imported product data.
It uses the information provided by the catalog element.

The local price provider supports the following price models:

|||
| -------------------------------------------- | ------------------- |
| List price                                   | The price from the catalog element is used.  |
| Customer group based prices                  | The local price provider can use group-based prices. A customer can be part of one or more groups. |
| Volume discount prices                       | Prices can be defined with a minimum quantity.            |
| Prices defined for given date and time range | Prices can be defined for a given time range. It is possible to add a start or end date including a time.   |

The base price is used to calculate the list price and customer price.

The local price provider performs the best price search. The customer price is always the best price.

### VAT and currency

`LocalPriceProvider` uses [VatServiceInterface](localvatservice.md#vatserviceinterface) to get the `vatPercent` for the given `vatCode`.
Customer currency is used (set in the price request).

Prices (and currency) are usually set up per country and provided during the import from the ERP or PIM system.

## Checking which price provider is used

It can be useful to know which price provider is used to calculate a price (e.g. in the basket).
Thanks to this you can, for example, enable special payment methods if you can be sure that the ERP was able to provide real-time prices,
or disable the checkout if the ERP is not able to provide prices. 

The basket contains a `priceResponseSourceType` data map attribute which contains the source type of the price provider.
`remote` type means that the ERP provided the prices for the current basket. 
