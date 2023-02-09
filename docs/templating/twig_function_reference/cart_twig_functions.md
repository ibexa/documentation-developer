---
description: Cart Twig functions enable checking whether product can be added to cart and formatting the price.
---

# Cart Twig functions

### `ibexa_can_be_added_to_cart()`

The `ibexa_can_be_added_to_cart()` checks whether the provided product can be added to cart. It eliminates products that are not available, products that do not have a price that corresponds to a currency selected for the cart, and products, for which VAT category is not set. It also eliminates products that have variants but are not one of those variants. 

``` html+twig
{% set is_disabled = (is_disabled or ibexa_can_be_added_to_cart(product) == false)|default(false) %}
```

### `ibexa_format_price`

The `ibexa_format_price` filter formats the price value by placing currency code 
either on the left or on the right from the numerical value.

``` html+twig
{% for product.price in product.attributes %}
    {{ product.price.getMoney()|ibexa_format_price }}
{% endfor %}
```
