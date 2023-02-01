---
description: Cart covers all actions related to the purchase process.
edition: commerce
---

# Cart

The cart component is a foundation of the commerce solution, it covers all actions related to the purchase process.

- It exposes [PHP API](cart_api.md) that allows for managing carts and cart entries, or validating products
- It exposes TWIG functions used for checkout rendering

## Cart data handling logic

Cart data is handled by two storages, depending on whether the buyer is anonymous 
or has been authenticated.
Information that relates to registered users is stored in a database, while anonymous 
user information is stored in the PHP session.

By default, anonymous users can add items to cart, but to display the cart view, 
they have to log in and transition into an authenticated user.

When an anonymous user logs into the storefront, the data is persisted and merged 
with any cart information that might already exist in the database.

!!! note 

    For information about roles and permissions that control access to the cart, 
    see [Permission use cases](../../permissions/permission_use_cases.md#commerce)
