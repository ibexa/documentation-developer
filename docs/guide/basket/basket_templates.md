---
edition: commerce
---

# Basket templates

## Template list

|Path|Description|
|--- |--- |
|`basket/page.html.twig `|Main basket template|
|`basket/widget.html.twig`|Basket preview in the upper right corner of the shop screen|
|`basket/row.html.twig`|Single row of basket preview|
|`basket/basket_summary.html.twig`|Basket summary|
|`SilversolutionsEshopBundle:Basket:stored_basket_preview_wish_list.html.twig`|Wishlist row with a number of products in the "My Shop" menu|
|`SilversolutionsEshopBundle:Basket:stored_basket_preview_comparison.html.twig`|Comparison row with a number of products in the "My Shop" menu|

## Display the content of a basket

The `BasketController` provides the [`basket`](basket_api/basket_data_model.md) variable that contains the content of the current basket.

You can access all basket attributes from a template.

The count of basket lines:

``` html+twig
{{ basket.lines.count }}
```

Access to basket lines:

``` html+twig
{% for line in basket.lines %}
    {{ line.sku }} 
    {{ line.linePriceAmountGross }} 
{% endfor %}
```

You can access the basket total value (net or gross) using `basket.totalsSum`:

``` html+twig
{{ basket.totalsSum.totalGross }}
```

To get the catalog element from the basket line, use `line.catalogElement`.

If a basket line does not provide product data (for example, the caching life time of a product has been exceeded), the product can be fetched with the `ses_product` function, by providing it with the product SKU obtained through `line.sku`.

``` html+twig
{% if line.catalogElement|default is not empty %}
    {% set product = line.catalogElement %}
{% else %}
    {% set product = ses_product({'sku': line.sku, 'variantCode': line.variantCode }) %}
{% endif %}
```

## Adding a product to the basket

To create a button that adds the current product to the basket, use the following form:

``` html+twig
<form method="post" action="{{ path('silversolutions_add_to_basket') }}">
    <div class="js-add-to-basket-parent">
        <input type="text" name="ses_basket[0][quantity]" class="tooltip" data-placement="e">
        <input type="hidden" name="ses_basket[0][sku]" value="{{ catalogElement.sku }}" >
        <input type="submit" class="button js-add-to-basket float_right" value="{{ 'Add to basket'|trans }}">
    </div>
</form>
```

You can add more than one product to the basket (for example, in a product list) by using the index:

```
ses_basket[0]
ses_basket[1]
...
```

!!! note

    If you want to add more products to the basket (for example, from the wishlist),
    you need one form around all the lines.
    The form adds all the lines to the basket at once.
    However, you might also need to add only one product from the list.

    To add a single product to the basket, you need to define parent elements with the class `.js-product-line`.
