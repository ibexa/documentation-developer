---
description: Shopping list feature allows to store potential purchases, recurrent product set, and other whish lists for later use into carts.
editions: lts-update commerce
month_change: true
---

# Shopping list feature guide

Shopping lists give customers a simple yet powerful way to manage future purchases.
It can cover many purchase planning cases.

## Use case examples

### Recurrent purchases

Every quarter, almost the same consumables must be bought.
Thanks to a dedicated shopping list, the cart can be quickly drafted, filled with all the necessary products.
Only quantities need to be input, it's time adjust the amount of each product, depending on what's left from previous quarter.

### Project wishlist

Every purchase needed by an incoming project can be stored,
even several products fulfilling the same purpose to decide latter wish ones to keep in the final cart.

## Shopping list management overview

Policies can give the rights to create, view, edit, and delete shopping lists.
Authenticated customers can be granted with those rights on their own shopping lists.

Such customer can

- Create a shopping list
    - from catalog when adding a product to a shopping list and choosing to create a new one instead of targeting an existing one
    - in shopping lists management interface
    - TODO: when saving for later from cart to shopping list, does it create the shopping list?
- Add product (or product variant) to a shopping list while browsing a product catalog
- Rename a shopping list (except the default "My Wishlist")
- List existing shopping lists
- View a shopping list product list
- Remove product from a shopping list
- Copy product from a shopping list to cart (products are kept in shopping list while added to the cart)
- Move product from cart to a shopping list (product are removed from cart and added to the shopping list)
- Delete a shopping list

A shopping list only stores product codes.
A shopping list doesn't store quantities.
