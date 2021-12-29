# Price templates

| Path     | Description       |
| -------- | ----------------- |
| `Catalog/Subrequests/product.html.twig` | Renders the price on product detail page. Defines the parameters for price rendering and includes the `product_price.html.twig` template.|
| `Catalog/listProductNode.html.twig` | Renders the price on product list page. Defines the parameters for price rendering and includes the `product_price.html.twig` template.|
| `Catalog/Subrequests/product_price.html.twig` | Displays a label with the price type (e.g. list price) and the price source (e.g. ERP). Includes `PriceField.html.twig` to render the price.
| `Fieldtypes/PriceField.html.twig` | Renders the given price from a catalog element. |

## Custom Twig functions

|Twig filter|Description|Usage|
|--- |--- |--- |
|`shipping`|Gets a list of shipping costs from the basket|`{% set shippingCosts = basket|shipping %}`|
|`basket_discounts`|Gets a list of discounts from the basket|`{% set discounts = basket|basket_discounts %}`|
|`basket_add_costs`|Gets a list of additional costs from the basket|`{% set addCosts = basket|basket_add_costs %}`|
|`basket_add_lines`|Gets a list of additional lines from the basket|`{% set addLines = basket|basket_add_lines %}`|

|Twig function|Description|Usage|
|--- |--- |--- |
|`ibexa_commerce_price_format`|Formats a price value|`{{ priceValue|ibexa_commerce_price_format(currency, locale) }}`|
|`ibexa_commerce_render_price`|Renders a PriceField from a catalog element|`{{ ibexa_commerce_render_price(catalogElement, minPrice, { 'outputPrice': {'cssClass': 'price price_med'} }) }}`|

## PriceField rendering

The `customerPrice` of a catalog element is an instance of `PriceField`.
Render it using the `ibexa_commerce_render_field()` Twig function:

``` html+twig
{{ ibexa_commerce_render_field(catalogElement, 'customerPrice') }}
```

The following optional rendering parameters are available:

### outputPrice

`outputPrice` enables actions on the output of the price value.

|Parameter|Description|Default|
|--- |--- |--- |
|`id`|Optional string with ID to use for price|`""` (undefined)|
|`cssClass`|Optional string with CSS class(es) to use for price|`""` (undefined)|
|`locale`|Two-digit locale code (e.g.: "en", "us", "de")|`"en"`|
|`currency`|Three-digit currency code (e.g.: EUR, GBP, USD)|`price.currency`|
|`property`|Property of price field used for the output value|`price.price`|
|`raw`|If true, price is output without any HTML tags|`false` (undefined)|

### vatLabel

`vatLabel` enables actions on the optional VAT label.

|Parameter|Description|Default|
|--- |--- |--- |
|`id`|Optional string with ID to use for VAT label|`""` (undefined)|
|`show`|If true, VAT label is shown|`false` (undefined)|
|`cssClass`|Optional string with CSS class(es) to use for VAT label|`""` (undefined)|
|`text`|Override of the output text|Default text depending on `price.isVatPrice` ("Including VAT" or "Excluding VAT")|
|`raw`|If true, VAT label is output without any HTML tags|`false` (undefined)|

### schema

`schema` enables outputting schema information.

If set, schema `itemprop="price"` is used:

```
<span itemprop="price" content="1865.00">1.865,00&nbsp;€</span>
```

The following example outputs the value of the `priceExclVat` property from the price field in German standard format (locale: `de`),
with enforced use of the Euro sign (currency: `EUR`). 
The CSS class `price_med` is added to the price `<p>` tag.
A VAT label is shown below the price (`show: true`) with defined text `Excluding VAT` and CSS classes `price_info` and `smaller` added to the VAT `<p>` tag:

``` html+twig
{{ ibexa_commerce_render_field(
    catalogElement,
    'customerPrice',
    {
        'outputPrice': {'property': 'priceExclVat', 'cssClass': 'price_med', 'currency': 'EUR', 'locale': 'de'},
        'vatLabel': {'show': true, 'cssClass': 'price_info smaller', 'text': 'Excluding VAT'|trans}
    }
)
}}
```
