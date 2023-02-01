---
description: Customize templates for the storefront.
edition: commerce
---

# Customize storefront layout

The built-in storefront offers a set of templates covering all functionalities of a shop,
divided into smaller components.

To customize your shop, you can override either whole templates, or specific components.

The built-in templates belong to the `storefront` [theme](design_engine.md).

To override any of them, copy its directory structure in your template directory.

## Template customization example

As an example, to change the cart display when it contains no products,
you need to override [`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart_empty_cart.html.twig`](https://github.com/ibexa/storefront/blob/4.4.0/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart_empty_cart.html.twig) template.

To do it, create your own template in `templates/theme/storefront/cart/component/maincart/maincart_empty_cart.html.twig`.

You can customize it, for example, to remove a "Continue shopping button" in the following way:

``` html+twig
{% trans_default_domain 'ibexa_cart' %}

{% block empty_content %}
    <h3 class="ibexa-store-maincart__empty-cart-headline">
        {{ 'cart_view.empty.headline'|trans|desc('Your shopping cart is empty') }}
    </h3>
{% endblock %}
```

## Available templates

All the storefront templates are located in `vendor/ibexa/storefront/src/bundle/Resources/view/themes/storefront`.

The most important templates are:

|Template|Component|
|---|---|
|`storefront/layout.html.twig`|main layout of the storefront|

### User

|Template|Component|
|---|---|
|`storefront/security/layout.html.twig`|main layout for the login and registration pages|
|`storefront/security/login.html.twig`|user login page|
|`storefront/security/register.html.twig`|user registration page|

### General components

|Template|Component|
|---|---|
|`component/logo.html.twig`|shop logo|
|`component/region_switcher.html.twig`|switcher for regions|
|`component/currency_switcher.html.twig`|switcher for currencies|

### Cart

|Template|Component|
|---|---|
|`cart/component/maincart/maincart.html.twig`|general view of the main cart|
|`cart/component/minicart/minicart.html.twig`|minicart (cart icon displayed at the top of the page)|
|`cart/component/add_to_cart/add_to_cart.html.twig`|"add to cart" element|
|`cart/component/summary/summary.html.twig`|cart summary|

### Checkout

|Template|Component|
|---|---|
|`checkout/layout.html.twig`|main checkout layout|
|`checkout/component/step.html.twig`|individual checkout step|
|`checkout/component/quick_summary.html.twig`|checkout summary|

!!! tip

    For templates related to product rendering, see [Customize product view](customize_product_view.md#available-templates).
