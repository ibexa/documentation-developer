# Calculating prices [[% include 'snippets/commerce_badge.md' %]]

The basket recalculates the prices after each change of its content.
The request to the price engine is sent when the basket is stored.
This avoids the price engine being triggered several times (for example, if more than one product has been updated or added).
The prices provided by the price engine (and ERP) are stored in the basket for each line.

The price engine is also triggered when the basket is fetched from the database and the last price calculation is older than the provided time.

The time is set in the configuration in minutes:

``` yaml
ses_basket.default.recalculatePricesAfter: 60
```

By default, the attributes from the `ProductNode` entity are used. 
The price engine sets the following fields:

|Field|Value|
|--- |--- |
|`LinePriceAmount`|The customer price for the given quantity|
|`IsIncVat`|Whether `LinePriceAmount` includes VAT or not|
|`Price`|Price for one piece. This price may be calculated if the ERP doesn't provide a price for one piece|
|`Vat`|VAT in %|
|`Currency`|The currency provided by the ERP/price engine|

The price engine sets stock information as well because the ERP often provides information about the availability in a price request as well:

- `remoteDataMap['stockNumeric']` - number of items on stock
- `remoteDataMap['onStock']` - boolean
