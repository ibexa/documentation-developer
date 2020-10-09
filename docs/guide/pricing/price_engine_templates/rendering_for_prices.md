# Rendering for prices

## Rendering PriceField

To render the `customerPrice` (instance of `PriceField`) of the `ProductNode`,
use the Twig function `ses_render_field()` within the template `MyTestBundle::product.html.twig.`

``` html+twig
{{ ses_render_field(catalogElement, 'customerPrice') }}
```

The following optional rendering parameters are available for a `PriceField`:

### outputPrice

`outputPrice` enables actions on the output of the price value

|Parameter|Description|Default|
|--- |--- |--- |
|`id`|Optional string with ID to use for price|`""` (undefined)|
|`cssClass`|Optional string with CSS class(es) to use for price|`""` (undefined)|
|`locale`|Two-digit locale code (e.g.: "en", "us", "de")|`"en"`|
|`currency`|Three-digit currency code (e.g.: EUR, GBP, USD)|`price.currency`|
|`property`|Property of price field used for the output value|`price.price`|
|`raw`|Price is output without any HTML tags, if true|`false` (undefined)|

### vatLabel

`vatLabel` enables actions on the optional VAT label

|Parameter|Description|Default|
|--- |--- |--- |
|`id`|Optional string with ID to use for VAT label|`""` (undefined)|
|`show`|VAT label is shown if `true`|`false` (undefined)|
|`cssClass`|Optional string with CSS class(es) to use for VAT label|`""` (undefined)|
|`text`|Override of the output text|Default text depending on `price.isVatPrice` ("Including VAT" or "Excluding VAT")|
|`raw`|Output VAT label without any HTML tags, if `true`|`false` (undefined)|

### schema

`schema` enables outputting schema information.

If set, schema `itemprop="price"` is used:

```
<span itemprop="price" content="1865.00">1.865,00&nbsp;€</span>
```

The following example outputs the value of property `priceExclVat` from the price field in German (locale: `de`) standard format
with enforced used of the Euro sign (currency: `EUR`). The CSS class `price_med` is added to the price `<p>` tag.
A VAT label is shown below the price (`show: true`) with defined text `Excluding VAT` and CSS classes `price_info` and `smaller` added to the VAT `<p>` tag:

``` html+twig
{{ ses_render_field(
    catalogElement,
    'customerPrice',
    {
        'outputPrice': {'property': 'priceExclVat', 'cssClass': 'price_med', 'currency': 'EUR', 'locale': 'de'},
        'vatLabel': {'show': true, 'cssClass': 'price_info smaller', 'text': 'Excluding VAT'|trans}
    }
)
}}
```
