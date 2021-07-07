# Embed product

To render a product embedded in an article in the form of a product card,
first, you need to [override the existing shop templates](../templates/overriding_shop_templates.md):

``` yaml
[[= include_file('code_samples/front/shop/override_navigation/config/packages/design.yaml') =]]
```

Next, in the view configuration, override the default `embed` view for products:

``` yaml
[[= include_file('code_samples/front/shop/embed_product/config/packages/views.yaml', 13, 23) =]]
```

Create a `templates/themes/my_theme/embed/product_card.html.twig` template that renders the product's name, image and price wrapped in a link:

``` html+twig
[[= include_file('code_samples/front/shop/embed_product/templates/themes/my_theme/embed/product_card.html.twig') =]]
```

This template uses the Catalog controller to render the product price.
To modify the way the controller displays the price,
override the built-in `Catalog/Subrequests/product.html.twig` template to render the price only,
without additional information such as stock.

To do it, create a `templates/themes/my_theme/Catalog/Subrequests/product.html.twig` file:

``` html+twig
[[= include_file('code_samples/front/shop/embed_product/templates/themes/my_theme/Catalog/Subrequests/product.html.twig') =]]
```
