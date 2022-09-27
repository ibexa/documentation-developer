---
description: The customer can store products in a wishlist, or in a number of stored, named baskets, for future purchasing.
edition: commerce
---

# Wishlist and stored baskets

The logged-in customer can save selected products in a list and easily access them or add them to the shopping basket.

Two different types of lists are available:

- wishlists
- stored baskets

The difference between a wishlist and a stored basket is that a user has only one wishlist,
but can have many stored baskets with different names. 

A stored basket can also contain the quantity of products and prices.

You can deactivate the stored basket feature in configuration:

``` yaml
twig:
    globals:
        stored_baskets_active: false
```

## Twig functions

`ibexa_commerce_get_stored_baskets()` returns stored baskets for the current user:

``` html+twig
{% set storedBaskets = ibexa_commerce_get_stored_baskets() %}
{% if storedBaskets|default is not empty %}
    {% for storedBasket in storedBaskets %}
        {{ storedBasket.basketName }}
    {%  endfor %}
{% endif %}
```
