---
description: Assigning users to customer groups allows defining user-specific pricing rules.
---

# Customer groups

You can assign users to different customer groups to enable [custom pricing](prices.md).
This enables you to give specific prices or price discounts (global or per product) to specific groups of users.

For example, you can offer a 10% discount for all products in the catalog to users who belong to the Resellers customer group.

By using the [Discounts LTS Update](discounts_guide.md), you can create even more complex rules that apply to only selected customer groups or to all customers.

!!! tip

    Customer groups aren't the same as [user groups](user_registration.md#user-groups).
    User groups concern all users in the system and can be used, for example, to handle permissions.
    Customer groups refer specifically to the commerce functionalities and enable handling prices.

## Enabling customer groups

To enable the use of customer groups, you need to modify the user content type's definition by adding a [customer group field](customergroupfield.md).

With this field you can add a user to any of the predefined customer groups.
