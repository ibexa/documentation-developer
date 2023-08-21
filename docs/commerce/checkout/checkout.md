---
description: The checkout component covers providing shipping and billing addresses, and selecting payment and shipping methods.
edition: commerce
---

# Checkout

Checkout is a crucial component of the Commerce offering delivered as part 
of [[= product_name =]].
In a course of a multi-step process, it collects necessary transaction data, such 
as billing and shipping addresses, and payment and shipping information.

From the front-end perspective, it is a reusable component that provides access 
to the workflow and allows buyers to place an order for cart items.

![Address selection stage](checkout.png "Checkout stages")

Depending on the model of shopping process that you need to use, the checkout 
process can range between a straightforward and extremely complicated one. 
To allow for this variation, the component is highly configurable and extensible:

- Like the editorial workflow, it relies on [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html) 
- It exposes [PHP API](checkout_api.md) that allows for workflow manipulation
- It exposes Twig functions used for checkout rendering

In a default implementation, users go through a series of steps.
They first select a billing and shipping address, then select shipping and payment 
methods, later they review summary and confirm their choices, to finally receive 
a simulated order confirmation.

Until the checkout process is complete, at any point of the process, users can 
go back to the cart and modify cart information, for example, cart item quantities.
They can also navigate back and forth between checkout steps, with an exception 
of the "Checkout complete" step, which always ends the process.

You can modify these steps according to your needs.
For more information, see [Configure checkout](configure_checkout.md).

## Shipping and billing address assignment logic 

As far as shipping details are concerned, checkout can behave differently, depending 
on whether the buyer is a corporate account member, a registered customer, or 
an individual.

- Corporate account members will see a company's billing address, and several shipping addresses to pick from, as predefined in the company profile.
- Registered customers will be able see and modify the addresses that they defined at registration
- Individuals will be able to enter both addresses at checkout

For more information about shipping and billing addresses, see [Configure checkout](configure_checkout.md#shipping-and-billing-address-field-format-configuration).

## Virtual Products checkout

Virtual product is a special type of a [product](products.md). Virtual products are non-tangible items such as memberships, services, warranties. 
They can be sold individually, or as part of a product bundle.

Virtual products don’t require shipment when they're purchased individually.
While purchasing virtual product, you only have to fill in the billing address and select relevant payment method. 

![`Virtual product purchasing`](virtual_product_purchase.png "Virtual product purchasing")

## Reorder

Reorder functions as the variant for the checkout workflow and is accessible solely to logged-in users.
It initiates from the user's order history, where they can click **Reorder** and trigger the flow. 
Next, the user is moved to cart where the system validates the order against existing stock.  
If everything is available, customer can move to payment and summary.
The system pre-fills address, shipping method, and payment details using information from the past order.

For more information, see [reorder documentation](reorder.md).