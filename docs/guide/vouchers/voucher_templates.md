# Voucher templates [[% include 'snippets/commerce_badge.md' %]]

Vouchers are rendered in the `vouchers` Twig block that is included in `commerce-shop/src/bundle/Eshop/Resources/views/Basket/show.html.twig`.

## Twig functions

### ibexa_commerce_contains_basket_vouchers

`ibexa_commerce_contains_basket_vouchers` returns true if the basket contains any vouchers.
	
``` html+twig
{% if ibexa_commerce_contains_basket_vouchers(basket) %}
  <a class="button" href="{{ path('siso_remove_voucher') }}">
    <i class="fa fa-times"></i> {{ 'button.remove_vouchers'|ibexa_commerce_translate }}
  </a>
{% endif %}
```

### ibexa_commerce_get_basket_vouchers

`ibexa_commerce_get_basket_vouchers` returns a list of vouchers from the basket.

``` html+twig	
{% set vouchers = ibexa_commerce_get_basket_vouchers(basket) %}
{% for voucher in vouchers %}   
  <p>{{ 'common.voucher_redeemed'|ibexa_commerce_translate }} {{ voucher }}</p>
  <a class="button" href="{{ path('siso_remove_voucher', {'voucherNumber' : voucher}) }}">
    <i class="fa fa-times"></i> {{ 'button.remove_voucher'|ibexa_commerce_translate }}
  </a>  
{% endfor %}
```
