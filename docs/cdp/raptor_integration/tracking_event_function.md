---
description: Raptor tracking event function.
---

# Raptor tracking event function

This module introduces visit tracking functionality for collecting user interactions with products and content.
The implementation includes product visit tracking with mapping to tracking parameters and automatic price formatting, as well as Twig functions for straightforward integration.
It supports multi-currency setups with automatic decimal formatting (0, 2, or 3 decimals) based on configuration, and integrates with taxonomy to extract and format category paths for product categorization.

## Initialize Raptor tracking script

First, initialize the Raptor tracking script in your base layout template, typically within the <head> section or before the closing <body> tag:

``` html+twig
{# templates/base.html.twig #}
<!DOCTYPE html>
<html>
<head>
    {# ... other head content ... #}

    {# Initialize Raptor tracking - must be called before any tracking events #}
    {{ ibexa_tracking_script() }}
</head>
<body>
    {# ... page content ... #}
</body>
</html>
```

## Tracking events

### Product Visit Event

This event tracks product page visits by users.
This is the most common e-commerce tracking event used to capture product views for analytics, recommendation models, and user behavior processing.

Required Data:

- Product object (implements `ProductInterface`)

Example:

``` html+twig
{# templates/product/view.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <div class="product-details">
        <h1>{{ product.name }}</h1>
        <p>{{ product.description }}</p>
        <div class="price">{{ product.price }}</div>
    </div>

    {# Track product visit #}
    {{ ibexa_tracking_track_event('visit', product) }}
{% endblock %}
```

### Basket Event

This event tracks when a product is added to the shopping basket.
It catches user interest and helps with conversion tracking and product recommendations.

Required Data:
- Product object (the product being added to cart)
- Context array with basket information

Example:

``` html+twig
{# templates/cart/add_confirmation.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <div class="cart-notification">
        <p>Product "{{ product.name }}" has been added to your cart!</p>
        <p>Quantity: {{ addedQuantity }}</p>
    </div>

    {# Build basket content string: "SKU:quantity;SKU:quantity" #}
    {% set basketContent = [] %}
    {% for item in basket.items %}
        {% set basketContent = basketContent|merge([item.product.code ~ ':' ~ item.quantity]) %}
    {% endfor %}

    {# Track basket addition #}
    {% set basketContext = {
        'basketContent': basketContent|join(';'),
        'basketId': basket.id,
        'quantity': addedQuantity
    } %}

    {{ ibexa_tracking_track_event('basket', product, basketContext) }}

    <a href="{{ path('cart_view') }}">View Cart</a>
{% endblock %}
```

Simplified example with Twig filter:

``` html+twig
{# If you have a custom Twig filter to format basket content #}
{% set basketContext = {
    'basketContent': basket|format_basket_content,  {# Returns "SKU-1:2;SKU-2:1;SKU-3:5" #}
    'basketId': basket.id,
    'quantity': addedQuantity
} %}

{{ ibexa_tracking_track_event('basket', product, basketContext) }}
```

### Custom Templates

You can override the default tracking templates by providing a custom template path:

``` bash
{{ ibexa_tracking_track_event(
    'visit',
    product,
    {},
    '@MyBundle/tracking/custom_visit.html.twig'
) }}
```
