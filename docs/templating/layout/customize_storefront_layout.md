---
description: Customize templates for the storefront.
edition: commerce
---

# Customize storefront layout

The built-in storefront offers a set of templates covering all functionalities of a shop, divided into smaller components.

To customize your shop, you can override either whole templates, or specific components.
The built-in templates belong to the `storefront` [theme](design_engine.md).
To override any of them, copy its directory structure in your template directory.

## Customize with Twig Components

You can customize parts of the storefront by using [Twig components](components.md).
This allows you to inject your own widgets, extending the storefront behavior.

The available groups for the storefront are:

| Group name | Template file |
|---|---|
| `storefront-before-maincart` | `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart.html.twig` |
| `storefront-after-maincart` | `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart.html.twig` |
| `storefront-before-minicart` | `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/minicart/minicart.html.twig` |
| `storefront-after-minicart` | `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/minicart/minicart.html.twig` |
| `storefront-before-add-to-cart` | `vendor/ibexa/cart/src/bundle/Resources/views/themes/standard/cart/component/add_to_cart/add_to_cart.html.twig` |
| `storefront-after-add-to-cart` | `vendor/ibexa/cart/src/bundle/Resources/views/themes/standard/cart/component/add_to_cart/add_to_cart.html.twig` |
| `storefront-before-summary` | `vendor/ibexa/cart/src/bundle/Resources/views/themes/standard/cart/component/summary/summary.html.twig` |
| `storefront-after-summary` | `vendor/ibexa/cart/src/bundle/Resources/views/themes/standard/cart/component/summary/summary.html.twig` |


## Template customization example

As an example, to change the cart display when it contains no products, you need to override [`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart_empty_cart.html.twig`](https://github.com/ibexa/storefront/blob/main/src/bundle/Resources/views/themes/storefront/cart/component/maincart/maincart_empty_cart.html.twig) template.

To do it, create your own template in `templates/theme/storefront/cart/component/maincart/maincart_empty_cart.html.twig`.

You can customize it, for example, to remove a "Continue shopping" button in the following way:

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
|`component/language_switcher.html.twig`|switcher for regions|
|`component/currency_switcher.html.twig`|switcher for currencies|

### Cart

|Template|Component|
|---|---|
|`cart/component/maincart/maincart.html.twig`|general view of the main cart|
|`cart/component/minicart/minicart.html.twig`|minicart (cart icon displayed at the top of the page)|
|`cart/component/add_to_cart/add_to_cart.html.twig`|"add to cart" element|
|`cart/component/summary/summary.html.twig`|cart summary|
|`cart/component/quick_order/quick_order.html.twig`|quick order|

#### Extend Twig template

```html+twig
{% extends '@IbexaCart/themes/standard/cart/component/minicart/minicart.html.twig' %}

{% block content %}
    <img
        class="ibexa-store-minicart__image"
        src="{{ asset('bundles/ibexastorefront/img/icons/cart.svg') }}"
        alt="{{ 'minicart.icon.alt'|trans|desc('Cart') }}"
    />
    {{ parent() }}
{% endblock %}
```

To avoid self-reference, `@IbexaCart` is used instead of `@ibexadesign`.

Built-in components aren't styled, so you can freely customize them according to your needs.
You can add CSS classes to the base Twig by using attribute objects.
For example, to add custom CSS classes to quantity input in the "Add to Cart" component, use the following:

```html+twig
{% set quantity_input_attr = {
    class: 'ibexa-store-input ibexa-store-input--number ibexa-store-add-to-cart__quantity-input',
} %}
```

Every element is also inside its own block so you can override the whole block.

#### Extending JavaScript

In case of the JavaScript component, you should import the original class and extend it:

```js
import Minicart from '@ibexa-cart/src/bundle/Resources/public/js/component/minicart';

export default class StorefrontMinicart extends Minicart {}
```

The example below shows how to add a "Clear" button support to the maincart:

```js
import Maincart from '@ibexa-cart/src/bundle/Resources/public/js/component/maincart';

export default class StorefrontMaincart extends Maincart {
    constructor(options) {
        super(options);

        this.clearCartBtn = this.container.querySelector('.ibexa-store-maincart__clear-cart-btn');

        this.onCartClear = this.onCartClear.bind(this);
    }

    attachStorefrontMaincartListeners() {
        this.clearCartBtn.addEventListener('click', this.onCartClear, false);
    }

    onCartClear() {
        this.cart.empty();
    }
}
```

Next, add the button in the Twig file.

### Main cart

You must customize the base widget for the main cart view, because out-of-the-box it consists only of the container with items.
Each item consists of `<div>` wrappers with quantity input and remove item button.
With customization you can add layout containers and items' data such as title or price.

Available Twigs:

- `@IbexaCart/themes/standard/cart/component/maincart/maincart.html.twig`

with parameters:

- `attr`
- `item_template_attr`
- `items_container_attr`
- `item_template_params`
- `item_template_path`
- `net_price_template`

- `@IbexaCart/themes/standard/cart/component/maincart/maincart_item.html.twig`

with parameters:

- `cart_entry_quantity`
- `item_attr`
- `quantity_input_attr`
- `remove_item_btn_attr`

JavaScript class:

- `@ibexa-cart/src/bundle/Resources/public/js/component/maincart`

### Add to Cart

You could extend this widget by adding variant selectors.

Available Twig:

- `@IbexaCart/themes/standard/cart/component/add_to_cart/add_to_cart.html.twig`

with parameters:

- `is_disabled`
- `attr`
- `product_code`
- `quantity_input_attr`
- `add_to_cart_btn_attr`

JavaScript class:

- `@ibexa-cart/src/bundle/Resources/public/js/component/summary`


### Minicart

You could modify the minicart widget by changing its icon, title or other elements.

Available Twig:

- `@IbexaCart/themes/standard/cart/component/minicart/minicart.html.twig`

with parameters:

- `count`
- `attr`
- `counter_attr`

### Checkout

|Template|Component|
|---|---|
|`checkout/layout.html.twig`|main checkout layout|
|`checkout/component/step.html.twig`|individual checkout step|
|`checkout/component/quick_summary.html.twig`|checkout summary|

!!! tip

    For templates related to product rendering, see [Customize product view](customize_product_view.md#available-templates).


### Summary

You could extend the summary widget to let buyers navigate from this view, for example, to checkout, or back to shopping, by adding respective buttons.

|Template|Component|
|---|---|
|`cart/component/summary/summary.html.twig`|main summary layout|
|`cart/component/summary/summary_item.html.twig`|item summary layout|

### Quick order

You can modify the quick order page by changing its form, title or other elements.

Available Twigs:

- `@IbexaCart/themes/standard/cart/component/quick_order/quick_order.html.twig` with parameters:
    - `form_themes`
    - `form_start_attr`
    - `form_start_vars`
    - `main_widget_vars`
    - `add_to_cart_btn_attr`
    - `form_end_vars`

- `@IbexaCart/themes/standard/cart/component/quick_order/quick_order_form_fields.html.twig` with parameters per block, block's names are generated based on fields in Symfony form:
    - `quick_order_widget` block
        - `main_attr`
        - `widget_attr`
    - `quick_order_file_row` block
        - `file_attr`
        - `file_vars`
    - `quick_order_entries_row` block
        - `entries_wrapper_attr`
        - `add_entry_btn_attr`
    - `quick_order_entries_widget` block
        - `entries_attr`
        - `form_widget_vars`
    - `quick_order_entry_row` block
        - `entry_attr`
        - `delete_entry_btn_attr`
        - `code_attr`
        - `code_vars`
        - `quantity_attr`
        - `quantity_vars`
        - `errors_vars`

JavaScript class:

- `@ibexa-cart/src/bundle/Resources/public/js/component/quick.order`
