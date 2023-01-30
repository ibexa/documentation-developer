---
description: The checkout component covers providing shipping and billing addresses, and selecting payment and shipping methods.
edition: commerce
---

# Checkout

Checkout is a crucial component of the Commerce offering delivered as part 
of [[= product_name =]].
In a course of a multi-step process, it collects necessary transaction data, such 
as billing and shipping addresses, and payment and shipping information.

![Address selection stage](img/checkout.png)

Depending on the model of commerce presence that you decide upon, the checkout 
process can range between a straightforward and extremely complicated one.

To allow for this variation, the component is highly configurable and extensible:

- Like the editorial workflow, it relies on [Symfony Workflow](../../content_management/workflow/workflow.md). 
- It exposes [PHP API](checkout_api.md) that allows for workflow manipulation.
- It exposes TWIG functions used for checkout rendering.

For more information, see [Configure checkout](configure_checkout.md).
