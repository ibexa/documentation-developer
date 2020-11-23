# LocalVatService

Typically, the ERP can provide the VAT percent during a price request.
If that does not happen, `LocalVatService` can be used as a fallback.

If the ERP does not provide the VAT percent, the VAT code stored in the product node can be used to determine the current VAT percent, based on configuration.

## Configuration

VAT configuration is SiteAccess-aware. It also considers the country code (of the buyer or the delivery destination).
If the country is not found in the SiteAccess configuration, `default` is used as a fallback.

If no VAT value is found, an exception is thrown, because the default VAT rate cannot be displayed.

``` yaml
siso_core.default.standard_price_factory.fallback_country: DE

siso_core.<siteaccess>.vat:
    <country_code>:
        print: 7
        9: 9
        19: 19
    default:
        print: 19
        9: 9
        19: 19
```

## VatServiceInterface

`VatServiceInterface` does VAT calculations and returns the VAT percent as float value.

|Method|Description|
|--- |--- |
|`getVatPercentForPriceRequest()`|Returns the VAT percent value for `priceRequest` according to a specific logic.|
|`getVatPercent()`|Returns the VAT percent value for a given `country` and `vatCode`.|
