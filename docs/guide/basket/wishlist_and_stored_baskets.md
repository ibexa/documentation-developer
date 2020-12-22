# Wishlist and stored baskets [[% include 'snippets/commerce_badge.md' %]]

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

## Basket type

Wishlists and stored baskets are baskets with a special type `wishlist` or `storedBasket`. 

No events are thrown when adding products to a wishlist or a stored basket.
However, there is no data validation in the background.
Data validation, such as for the minimum order amount or for mixing of downloads with normal products,
is done when adding those items into the shopping basket.

One template is used for both wishlists and stored baskets. The attributes that are shown can be handled through the basket type:

``` php
const TYPE_STORED_BASKET = 'storedBasket';
const TYPE_WISH_LIST = 'wishList';
```

## Template list

|Path|Description|
|--- |--- |
|`Basket/stored_baskets_list.html.twig`|List of all stored baskets|
|`Basket/show_stored_basket.html.twig`|Entry page for both wishlists and stored baskets. Based on the basket type it loads one of the templates listed below|
|`Basket/show_stored_basket_part.html.twig`|Partial page responsible for rendering a stored basket page|
|`Basket/show_wishlist_part.html.twig`|Partial page responsible for rendering the wishlist|
|`Basket/messages.html.twig`|Template with success/error/notice messages for baskets|

## Twig functions

`get_stored_baskets()` returns stored baskets for the current user:

``` html+twig
{% set storedBaskets = get_stored_baskets() %}
{% if storedBaskets|default is not empty %}
    {% for storedBasket in storedBaskets %}
        {{ storedBasket.basketName }}
    {%  endfor %}
{% endif %}
```
