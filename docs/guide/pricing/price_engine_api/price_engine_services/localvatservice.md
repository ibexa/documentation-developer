# LocalVatService

`LocalVatService` can be used as a fallback if `PriceRequest` does not provide the VAT value.
Typically the ERP can provide the VAT percent during a price request. 

If not provided, the VAT code stored in the product node can be used to determine the current VAT percent using a configuration.

The configuration considers:

- SiteAccess
- country code (country code for the buyer or in some cases the country code of the delivery destination)
If the country is not found in the SiteAccess configuration, `default` is used as a fallback. In this case an entry is added to log file
- VAT code

Because of legal reasons, if no VAT value is found, an exception is thrown. The default VAT percent cannot be displayed in this case.

In the standard implementation the VAT code for calculation is provided by the `ProductNode` attribute `vatCode` (`catalogElement->vatCode`).

## Configuration

``` yaml
// if there is no information for country code in the priceRequest use fallback
siso_core.default.standard_price_factory.fallback_country: DE

// vat configuration (siteaccess, country code and vat code)
siso_core.engl.vat:
    EN:
        vegetable: 7
        print: 7
        #some NAV special vat code naming
        9: 9
    #default is not a country code, but used as a fallback configuration
    default:
        vegetable: 7
        print: 7
        9: 9

siso_core.default.vat:
    DE:
        vegetable: 7
        print: 7
        #some NAV special vat code naming
        9: 9
    #default is not a country code, but used as a fallback configuration
    default:
        vegetable: 7
        print: 7
        9: 9
```

## VatServiceInterface

`VatServiceInterface` does VAT calculations and returns the VAT percent as float value.

|Method|Description|
|--- |--- |
|`public function getVatPercentForPriceRequest($lineId, PriceRequest $priceRequest);`|Returns the VAT percent value for `priceRequest` according to a specific logic.|
|`public function getVatPercent($country, $vatCode);`|Returns the VAT percent value for a given `$country` and `$vatCode`.|
