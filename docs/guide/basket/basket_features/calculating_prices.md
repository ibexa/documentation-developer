# Calculating prices

The basket recalculates the prices after each change of the basket. The request to the price engine is sent when the basket is stored. This avoids the price engine being triggered several times (e.g. if more than one product has been updated or added). The prices provided by the price engine (and ERP) will be stored in the basket for each line.

By default the attributes from the `ProductNode` entity will be used. The price engine will set the following fields:

|Field|Value|
|--- |--- |
|LinePriceAmount|The customer price for the given quantity|
|IsIncVat|Whether `LinePriceAmount` includes VAT or not|
|Price|Price for one piece. This price may be calculated if the ERP doesn't provide a price for one piece. This is standard approach due to complex price rules.|
|Vat|VAT in %|
|Currency|The currency provided by the ERP/price engine|

The price engine will set stock information as well since the ERP often provides information about the availability in a price request as well:

- `remoteDataMap['stockNumeric']` - number of items in stock
- `remoteDataMap['onStock']` - boolean

### Price recalculation

The price engine will also be triggered when the basket is fetched from the database and the last price calculation is older than a given time.
In addition, the prices will be calculated each time the basket is changed.

The time is set in the configuration in minutes:

``` yaml
parameters:
    ses_basket.default.recalculatePricesAfter: 60
```
