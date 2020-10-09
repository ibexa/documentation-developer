# Price engine constants

The shop uses constants for consistent naming of price-related request and response values.

All constants for price engine are stored in the final class `Silversolutions\Bundle\EshopBundle\Model\Price\PriceConstants`.

## Types of constants

|Type|Description|
|--- |--- |
|`PRICE_ENGINE_SOURCE_*`|Source of price calculation e.g. `ERP`, `Shop`, `Request`|
|`PRICE_REQUEST_PRICE_TYPE_*`|Type of price e.g. `list`, `custom`, `base`|
|`PRICE_RESPONSE_LINE_TYPE_*`|Type of price line e.g. `product`, `shipping`|
|`PRICE_RESPONSE_TOTALS_*`|Type of total value e.g. `sum`, `lines`, `additional_lines`|
|`PRICE_RESPONSE_SOURCE_TYPE_*`|Indicates which price provider calculates the prices|
