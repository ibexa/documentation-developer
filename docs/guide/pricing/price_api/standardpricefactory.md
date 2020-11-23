# StandardPriceFactory

Depending on the configuration, `StandardPriceFactory` creates a Price instance including or excluding VAT.
The configuration can be overridden by method parameters.

The default fallback price source depends on the content of the price fields.

- If one of the fields is empty (zero or null), the fallback price source is `PriceConstants::PRICE_ENGINE_SOURCE_INCOMPLETE`
- Otherwise, the price source is `PriceConstants::PRICE_ENGINE_SOURCE_LOCAL`

## Creating price

|Method|Description|
|---|---|
| `createPriceFromResponseLine()` | Creates Price from `PriceLine` in `PriceRequest`. Uses the content of a `PriceLine` and the given currency code. |
| `createPrice()` | Creates price from given properties. The necessary values are passed directly within an array. |

## PriceFactoryInterface

The `PriceFactoryInterface` service creates Price instances.

!!! caution

    Do not create a Price Field directly. 
    Use Price Factory instead.
