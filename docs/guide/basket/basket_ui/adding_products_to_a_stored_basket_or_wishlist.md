# Adding products to a stored basket or wishlist

## How to add a product to a wishlist

The following example shows how to offer a link which adds a product to the wishlist:

``` html+twig
<a href="#" class="u-block u-text-small js-add-to-wishlist" data-text-swap="Already on your wishlist" data-sku="40960">
    <i class="fa fa-heart fa-lg fa-fw"></i> <span class="js-text-swap-wrapper">Add product to my wishlist
</a>
```

## How to add a product to a stored basket

The following example opens a modal window providing the option to add a product to an existing stored basket or a new one:

``` html+twig
<a href="#" class="u-block u-text-small js-add-to-stored-basket">
    <i class="fa fa-upload fa-lg fa-fw"></i> Store product in a stored basket
</a>
```
