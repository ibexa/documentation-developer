---
description: The Checkout component collects billing and shipping addresses, and payment and shipping information, to turn a cart into an order.
page_type: landing_page
edition: commerce
month_change: false
---

# Checkout

Checkout is a multi-step process that collects the transaction data necessary to create an order, such as billing and shipping addresses, payment and shipping information.
With reorder, buyers can recreate their past orders.

## Getting started

[[= cards([
    "commerce/checkout/checkout_overview",
    "commerce/checkout/configure_checkout",
    "commerce/checkout/reorder",
    ("permissions/policies#checkout", "Policies", "Learn about the available checkout policies"),
], columns=2) =]]

## Development

[[= cards([
    "commerce/checkout/customize_checkout",
    "commerce/checkout/checkout_api",
    ("api/php_api/php_api_reference/namespaces/ibexa-contracts-checkout.html", "PHP API Reference", "<code>Ibexa\\Contracts\\Checkout</code>"),
    "templating/twig_function_reference/checkout_twig_functions",
], columns=2) =]]
