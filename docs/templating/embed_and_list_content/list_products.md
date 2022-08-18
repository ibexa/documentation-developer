---
description: Render a list of products from your product catalog.
---

# List products

To render a list of products, for example for the catalog of your site,
you need to create a custom controller and a template.

In this example the controller renders all products that exist in the catalog.

[[% include 'snippets/catalog_permissions_note.md' %]]

## Create product list controller

Create a controller file in `src/Controller/ProductListController` that uses the [ProductService](product_api.md#products)
to query for all products:

``` php hl_lines="22"
[[= include_file('code_samples/front/shop/list_products/src/Controller/ProductListController.php') =]]
```

Register the controller as a service:

``` yaml
[[= include_file('code_samples/front/shop/list_products/config/custom_services.yaml') =]]
```

## Content view configuration

Next, add view configuration to identify when to display the product list.
In this example you match on the `ses_productcatalog` Content Type, which is the Content Type of the built-in Product Catalog.

``` yaml
[[= include_file('code_samples/front/shop/list_products/config/packages/views.yaml') =]]
```

## Template

Finally, create a template for rendering the product.

The following template renders the product name, price, main image, and an "Add to basket" button.

``` html+twig
[[= include_file('code_samples/front/shop/list_products/templates/full/catalog.html.twig') =]]
```

!!! tip

    For more information about rendering product details, see [Render product](render_product.md).

!!! caution

    To enable adding a product to basket, you must first configure all necessary information for the product.
    See [Enable purchasing products](enable_purchasing_products.md) for more information.
