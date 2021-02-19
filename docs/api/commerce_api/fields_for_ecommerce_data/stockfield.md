# StockField

`StockField` is the representative implementation of `AbstractField` for stock information.

The `stockNumeric` information must be either an int or a float.

A new `StockField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\StockField;
  
// Usage: 
$stockField = new StockField(array('stockNumeric' => 15));
```

### StockField rendering

The StockField can be rendered with the `ses_render_stock` [Twig helper](../../../guide/shop_templates/shop_twig_functions.md).

This method renders the StockField from a central template:

`Silversolutions/Bundle/EshopBundle/Resources/views/Fieldtypes/StockField.html.twig`

The availability is displayed depending on the given parameters.
If the StockField is not defined (e.g. ERP is not responding), no availability information for this product is displayed.

``` html+twig
{# display availability for the basket line, pass additionally the requested quantity in order to find out if the product is available in required amount #}
{% set field = line.remoteDataMap.stock is defined ? line.remoteDataMap.stock : null %}
    {{ ses_render_stock(field, {
                        'outputStock': {
                        'numeric': false,
                        'cssClass': 'availability'
                         },
                        'quantity' : line.quantity
     }) }}
{# display availability for the product detail page, set numeric to true, so the stock information will be displayed as a number: e.g. 54 items on Stock #}
{% set field = catalogElement.stock is defined ? catalogElement.stock : null %}
    {{ ses_render_stock(field, {
        'outputStock': {
        'numeric': true,
        'cssClass': 'availability'
        }
        })
    }}

```
