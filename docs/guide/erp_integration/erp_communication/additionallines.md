# Additional lines [[% include 'snippets/experience_badge.md' %]]

A response sent to the shop from ERP can contain more information about product than was requested.
This additional information can include additional shipping costs, vouchers, another product for free, promotions, etc.
This information is handled by the service which adds the proper lines to basket or basket line.

Additional lines in the basket are stored as `$additionalLines[]`.
Additional lines in a basket line are stored as `$assignedLines[]`.

## WebConnectorService

`WebConnectorService` passes the whole ERP response object to the [RemotePriceProvider](../remotepriceprovider.md).
`RemotePriceProvider` creates additional lines in the price response, if it gets additional price information from ERP that has not been requested.

## AdditionalLine

`AdditionalLine` defines the class for additional lines that can be related to the basket or basket line.
Additional lines can increase or decrease the order sum.

|Attribute|Type|Usage|
|--- |--- |--- |
|`sku`|string|SKU or resource number of the cost|
|`name`|string|Name of the cost e.g. 'Shipping costs DHL standard'|
|`identifier`|string|Identifier of the cost e.g. `shippingCosts`|
|`price`|PriceField|Price of the cost including and excluding VAT|
|`characteristic`|string|Characteristic of the cost. Allowed values:</br>- `expense`: increases the total amount, has a price</br>- `voucher`: decreases the total amount, has a price</br>- `addOn`: doesn't have a price|

## Storing additional lines

Additional lines can be stored in the basket and/or basket line, for example:

``` html+twig
{% for line in basket.additionalLines  %}
    Name: {{ line.name }}
    Price: {{ ses_render_price(null, line.price,
            {
                'outputPrice': {'property': 'priceInclVat', 'raw' : true}
            }) }}
{% endfor %}
```

## AdditionalLinesService

`AdditionalLinesService` (service ID: `siso_basket.additional_lines_service`) is used to calculate the additional lines and store and fetch them from basket/basket line.

It implements all methods from `AdditionalLinesServiceInterface`.
