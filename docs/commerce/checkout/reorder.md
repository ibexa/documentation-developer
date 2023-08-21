---
description: Reorder allows users to easily recreate their past orders.
edition: commerce
---

# Reorder

The reorder feature allows customers to streamline the process of repurchasing previously bought items.
Based on a past order identifier, cart is recreated and validated to be eligible for reordering.

## Reorder workflow

Reorder is a variant of the checkout workflow accessible exclusively to logged-in users.
It has the same [configuration](configure_checkout.md) and [customization](customize_checkout.md) options as checkout.

Customers can use the following workflow to specify orders they want to reorder and complete the purchase.

1\. Logged in customer clicks **Orders** on their personal menu.

2\. Selects order they want to repurchase from the list.

3\. On the order details site customer clicks **Reorder**.

![Order details site - reorder](img/reorder_button.png)

4\. A new cart is created based on the past order identifier, and the availability of the products in the cart is validated.

5\. Customer clicks **Checkout**.

6\. The system pre-fills address, shipping method, and payment details using information from the past order.

7\. The customer is redirected to Payment and summary section where they can edit the specified address and the payment method by clicking steps on the workflow timeline.

![Reorder workflow timeline](img/reorder_timeline.png)

8\. The customer pays for the order and completes the workflow.

## Validation



## Configuration

Reorder is part of checkout and as such has the same configuration.
Below you 

### Workflow

You can modify workflow under the `framework.workflows` [configuration key](configuration.md#configuration-files).
Each workflow definition consists of a series of steps as well as a series of transitions between the steps. 


```yaml
framework:
    workflows:
        ibexa_order:
            metadata:
                cancel_status: !php/const Ibexa\OrderManagement\Value\Status::CANCELLED_PLACE
                cancel_transition: !php/const Ibexa\OrderManagement\Value\Status::CANCEL_TRANSITION
```