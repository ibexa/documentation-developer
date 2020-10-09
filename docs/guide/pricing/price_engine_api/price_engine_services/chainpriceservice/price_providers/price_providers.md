# Price providers

A price provider fetches or calculates the prices for the price request. If an error occurs or the prices cannot be calculated properly,
price provider throws a `PriceCalculationFailedException`, which passes the price calculation to the [price service](../chainpriceservice.md).

When providing the prices, every price provider must return both `list_price` and `custom_price`.

All price providers must use the `siso_price.price_provider` tag.

## PriceProviderInterface

|Method|Description|
|--- |--- |
|`public function calculatePrices(PriceRequest $priceRequest);`|This method always returns an instance of `PriceResponse` or throws `PriceCalculationFailedException`.|
