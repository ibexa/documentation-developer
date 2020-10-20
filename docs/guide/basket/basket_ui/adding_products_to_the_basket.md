# Adding products to the basket

To successfully add products to the basket you need to provide the required parameters.

## Required parameters

|Fixed parameters|Required|Value|Description|
|--- |--- |--- |--- |
|ses_basket[0][quantity]|YES||The quantity to be ordered. If empty the [[= product_name_com =]] will use 1 instead, as long as the parameter ses_basket[0][ses_ignore_quantity] is not set.|
|ses_basket[0][ses_ignore_quantity]||1|If set, [[= product_name_com =]] will not use 1 instead of empty quantity.|
|ses_basket[0][sku]|YES||The SKU to be ordered. A valid `CatalogElement` must exist for the given SKU.|
|ses_basket[0][isVariant]|YES FOR VARIANTS|isVariant|Should be set if product is a variant.|
|ses_basket[0][ses_variant_code]|YES FOR VARIANTS||Variant code of the ordered variant.|
|ses_basket[0][updateNotPermitted]||1|Can be passed optionally, if you want to avoid updating the line with the given SKU.</br>If set, a new basket line is created every time the user adds a product with the same SKU to the basket.|

## Additional parameters

Any other parameter that is set correctly will be passed to the basket and stored in the `basketLine.remoteDataMap`.

Example: `ses_basket[0][remark]`

The values are forwarded to the `priceRequest`/ERP as well.

### Template

The form tag which is used for the basket box has to be moved to the `product.twig.html` template.
`<div class="js_add_to_basket_parent">` must also be added in order to tell JavaScript to collect this data as well.

``` html+twig
<form method="post" action="{{ path('silversolutions_add_to_basket') }}">
    <div class="js_add_to_basket_parent">
        <input type="hidden" name="ses_basket[0][set_18508050]" value="18508050">
  
    </div>
</form>
```

### Data sent to the ERP

```
<LineItem>
    ....
    <SesExtension>
        <set_18508050>18508050</set_18508050>
    </SesExtension>
```

!!! caution

    - It is not possible to use arrays in this case (e.g. `ses_basket[0][list][0]`).
    - The key (here `remark`) must be a string and follow the rules for tag names, because the key is converted to a tag during a price request.

### How to add one product to the basket?

Add to basket POST form:

``` html+twig
<form method="post" action="{{ path('silversolutions_add_to_basket') }}">
<div class="js-add-to-basket-parent"> 
    <div class="space_top space_bottom">{{ 'Quantity:'|trans }}<span class="float_right">
        <input size="10" type="text" name="ses_basket[0][quantity]" class="tooltip" data-powertip="Minimum 1 piece" data-placement="e">
    <input type="hidden" name="ses_basket[0][sku]" value="{{ catalogElement.sku }}" >
    <input type="submit" class="button js-add-to-basket float_right" value="{{ 'Add to basket'|trans }}">
</form>
```

### How to add more products to the basket?

It is possible to add more than one product to the basket (e.g. in a product list) by using the index:

```
ses_basket[0]
ses_basket[1]
...
```

!!! note

    If you want to add more products to the basket (e.g. from the wishlist), you need one form around all lines that will add all lines to the basket at once, but you might also need to add only one single product from the list.

    To add a single product to the basket, you need to define parent elements with the class `.js-product-line`.

### Example for using Ajax

You need to define one parent element with the class `.js-add-to-basket-parent`.

!!! note "Important"

    One of these elements have to be placed inside a form!
    
    `.js-add-to-basket` - use if you want to add one product to the basket.

    `.js-add-all-to-basket` - use if you want to add more products to the basket at once

``` php
{% extends "SilversolutionsEshopBundle::pagelayout.html.twig"|st_resolve_template %}

{% block all_content %}

   Name: {{ catalogElement.name }} <br/>
   Name: {{ catalogElement.sku }}

   <div class="js-add-to-basket-parent">
       <input type="hidden" name="ses_basket[0][quantity]" value="1">
       <input type="hidden" name="ses_basket[0][sku]" value="{{ catalogElement.sku }}">
       <button class="button tiny js-add-to-basket" type="submit" data-sku="{{ catalogElement.sku }}">
        <i class="fa fa-cart-plus fa-lg fa-fw"></i>
      </button>

{% endblock %}
```

### Adding additional attributes to the basketline

Please note that an additional parameters should be a scalar value. Arrays are not supported. 

``` 
Attendee 1 (email)<input type="text" name="ses_basket[0][email_1]" value="" /><br/>
Attendee 2 (email)<input type="text" name="ses_basket[0][email_2]" value="" /><br/>
```

Display the values in the basket template:

``` 
Attendee 1 {{ line.remoteDataMap.email_1 }}<br>
Attendee 2 {{ line.remoteDataMap.email_2 }}
```
