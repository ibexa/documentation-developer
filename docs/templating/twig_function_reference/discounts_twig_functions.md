---
description: Discounts Twig Functions allow you to operate on discounts in your templates.
page_type: reference
month_change: true
editions:
    - lts-update
    - commerce
---

# Discounts Twig functions

Discounts Twig Functions allow you to operate on discounts in your templates.

## Filters

### `ibexa_render_discount_rule_type`

This filter transforms the discount type (`fixed_amount` or `percentage`) into a human-friendly and translated label.

``` html+twig
{% set rule_type = discount.getRule().getType() %}

<span class="ibexa-icon-tag">
    <svg class="ibexa-icon ibexa-icon--small">
        <use xlink:href="{{ ibexa_icon_path('discount-coupon') }}"></use>
    </svg>
    {{ rule_type|ibexa_render_discount_rule_type }}
</span>
```

## Functions

### `ibexa_discounts_render_discount_badge()`

Use the `ibexa_discounts_render_discount_badge` to render a badge indicating the discounted amount, for example on product cards.

``` html+twig
{% if ibexa_storefront_are_discounts_enabled() %}
    {% block product_discount_price_info %}
        <div class="ibexa-store-product__discount-price-info">
            {% include '@ibexadesign/storefront/component/discount/discount_price.html.twig' with {
                original_price: original_price,
            } %}
            {% embed '@ibexadesign/storefront/component/discount/discount_badge.html.twig' with {
                size: 'small',
            } %}
                {% block content %}
                    {{- ibexa_discounts_render_discount_badge(discount, price_money) -}}
                {% endblock %}
            {% endembed %}
        </div>
    {% endblock %}
{% endif %}
```

### `ibexa_get_original_price()`

Displays the product price before the discount was applied.

``` html+twig
{{ ibexa_get_original_price(product)|ibexa_format_price ?: '-' }}
```

### `ibexa_format_discount_value()`

Formats the discount value for each discount type, for example, by displaying `-10 EUR` or `-10%`.

``` html+twig
content: ibexa_format_discount_value(discount),
```

### `ibexa_discounts_is_active()`

Helper function returning whether the discount is currently active.

``` html+twig
{% if ibexa_discounts_is_active(discount) %}
    <div>The discount is active</div>
{% endif %}
```

### `ibexa_discounts_form_themes()`

The `ibexa_discounts_form_themes` function serves as an extension point to provide new [form themes]([[= symfony_doc =]]/form/form_themes.html) for the discount form.

To add new ones, create a class implementing the [FormThemeProviderInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-FormThemeProviderInterface.html) interface and provide them in the `getFormThemes` method.

### `ibexa_discounts_can_edit()`

Helper function returning whether the current user has permissions to edit discounts.

### `ibexa_discounts_can_enable()`

Helper function returning whether the current user has permissions to enable discounts.

### `ibexa_discounts_can_disable()`

Helper function returning whether the current user has permissions to disable discounts.

### `ibexa_discounts_can_delete()`

Helper function returning whether the current user has permissions to delete discounts.
