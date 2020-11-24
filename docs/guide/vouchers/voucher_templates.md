# Voucher templates [[% include 'snippets/commerce_badge.md' %]]

Vouchers are rendered in the `vouchers` Twig block that is included in `Silversolutions/Bundle/EshopBundle/Resources/views/Basket/show.html.twig`.

## Twig functions

### ses_contains_basket_vouchers

`ses_contains_basket_vouchers` returns true if the basket contains any vouchers.
	
``` html+twig
{% if ses_contains_basket_vouchers(basket) %}
  <a class="button" href="{{ path('siso_remove_voucher') }}">
    <i class="fa fa-times"></i> {{ 'button.remove_vouchers'|st_translate }}
  </a>
{% endif %}
```

### ses_get_basket_vouchers

`ses_get_basket_vouchers` returns a list of vouchers from the basket.

``` html+twig	
{% set vouchers = ses_get_basket_vouchers(basket) %}
{% for voucher in vouchers %}   
  <p>{{ 'common.voucher_redeemed'|st_translate }} {{ voucher }}</p>
  <a class="button" href="{{ path('siso_remove_voucher', {'voucherNumber' : voucher}) }}">
    <i class="fa fa-times"></i> {{ 'button.remove_voucher'|st_translate }}
  </a>  
{% endfor %}
```
