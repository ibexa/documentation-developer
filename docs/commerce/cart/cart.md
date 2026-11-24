---
description: The Cart component covers adding products to the cart and handling the list of products that the buyer intends to purchase, also in bulk with quick order.
page_type: landing_page
edition: commerce
month_change: false
---

# Cart

The Cart component covers the creation and handling of a list of products that the buyer intends to purchase.
With the quick order form, buyers can add multiple products to the cart at once.

## Getting started

[[= cards([
    "commerce/cart/cart_overview",
    "commerce/cart/quick_order",
    ("permissions/policies#cart", "Policies", "Learn about the available cart policies"),
], columns=2) =]]

## Development

[[= cards([
    "commerce/cart/cart_api",
    ("api/php_api/php_api_reference/namespaces/ibexa-contracts-cart.html", "PHP API Reference", "<code>Ibexa\\Contracts\\Cart</code>"),
    ("https://doc.ibexa.co/en/6.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart", "REST API Reference", "See the available endpoints for the cart"),
    "api/event_reference/cart_events",
    "templating/twig_function_reference/cart_twig_functions",
], columns=3) =]]
