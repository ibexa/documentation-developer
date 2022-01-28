# Render a product

To customize the template for a product, first, you need to [override the existing shop templates](../templates/overriding_shop_templates.md):

``` yaml
[[= include_file('code_samples/front/shop/override_navigation/config/packages/design.yaml') =]]
```

The built-in templates that are responsible for rendering a product are stored in
`vendor/ibexa/commerce-shop-ui/src/bundle/Resources/views/themes/standard/Catalog`.
You can override any partial template in the folder.

For example, to modify the general layout of the product page, create a 
`templates/themes/my_theme/Catalog/product_layout.html.twig` file:

``` html+twig
[[= include_file('code_samples/front/shop/render_product/templates/themes/my_theme/Catalog/product_layout.html.twig') =]]
```

In the template you can access the product via the `catalogElement` object.
