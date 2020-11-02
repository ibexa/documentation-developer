# Basket templates

## Template list

|Path|Description|
|--- |--- |
|`SilversolutionsEshopBundle:Basket:show.html.twig`|Main basket template|
|`SilversolutionsEshopBundle:Basket:messages.html.twig`|Renders a message when the basket is modified|
|`SilversolutionsEshopBundle:Fieldtypes:StockField.html.twig`|Renders the stock Field representing product availability|
|`SilversolutionsEshopBundle:parts:stock_legend.html.twig`|Renders the legend of symbols used to indicate product availability|
|`ezcommerce-base-design/Resources/views/themes/standard/basket/widget.html.twig`|Renders the basket preview in the upper right corner of the shop screen|
|`ezcommerce-base-design/Resources/views/themes/standard/basket/row.html.twig`|Renders one row of basket preview|
|`SilversolutionsEshopBundle:Basket:stored_basket_preview_wish_list.html.twig`|Renders the wishlist row with  the number of products in the "My Shop" menu|
|`SilversolutionsEshopBundle:Basket:stored_basket_preview_comparison.html.twig`|Renders the comparison row with the number of products in the "My Shop" menu|

## Display the content of a basket

The `BasketController` provides the [`basket`](basket_api/basket_data_model.md) variable containing the content of the current basket.

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

To get the catalog element from a basket line, use `line.catalogElement`.

If a basket line does not provide product data (e.g. the caching life time of a product has been exceeded) the product can be fetched using the `ses_product` function, providing it with the product SKU ibtained through `line.sku`.

``` html+twig
{% if line.catalogElement|default is not empty %}
    {% set product = line.catalogElement %}
{% else %}
    {% set product = ses_product({'sku': line.sku, 'variantCode': line.variantCode }) %}
{% endif %}
```

## Adding a product to the basket

To create a button which adds the current product to the basket, use the following form:

``` html+twig
<form method="post" action="{{ path('silversolutions_add_to_basket') }}">
    <div class="js-add-to-basket-parent">
        <input type="text" name="ses_basket[0][quantity]" class="tooltip" data-placement="e">
        <input type="hidden" name="ses_basket[0][sku]" value="{{ catalogElement.sku }}" >
        <input type="submit" class="button js-add-to-basket float_right" value="{{ 'Add to basket'|trans }}">
    </div>
</form>
```

You can add more than one product to the basket (e.g. in a product list) by using the index:

```
ses_basket[0]
ses_basket[1]
...
```

!!! note

    If you want to add more products to the basket (e.g. from the wishlist),
    you need one form around all lines that adds all lines to the basket at once,
    but you might also need to add only one single product from the list.

    To add a single product to the basket, you need to define parent elements with the class `.js-product-line`.
