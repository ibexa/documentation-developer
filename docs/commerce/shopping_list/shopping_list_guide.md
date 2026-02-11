---
description: Shopping list feature allows to store potential purchases, recurrent product set, and other whish lists for later use into carts.
editions: lts-update commerce
month_change: true
---

# Shopping list feature guide

Shopping lists give customers a simple yet powerful way to manage future purchases.
It can cover many purchase planning cases.

## Use cases

Shopping lists can be used in various ways, depending on the customer's needs and preferences.
Here are some examples.

### Recurrent purchases

Every quarter, almost the same consumables must be bought.
Thanks to a dedicated shopping list, the cart can be quickly drafted, filled with all the necessary products.
Only quantities need to be input, the amount of each product is adjusted depending on what's left from previous quarter and known consumption for the same period from previous years.

### Project wishlist

Every purchase needed by an incoming project can be stored in a dedicated shopping list,
even several products fulfilling the same purpose to decide latter wish ones to keep in the final cart.

## Shopping list management overview

Policies can give the rights to create, view, edit, and delete shopping lists.
Authenticated customers can be granted with those rights on their own shopping lists.

Such customer can

- Create a shopping list
    - in shopping lists management interface
    - from catalog when adding a product to a shopping list
    - from cart when saving for later into a shopping list
- Add product (or product variant) to a shopping list
- Rename a shopping list (except the default "My Wishlist")
- List existing shopping lists
- View a shopping list product list
- Move products from a shopping list to another shopping list
- TODO: Copy products from a shopping list to another shopping list
- Remove product from a shopping list
- Clear all products from a shopping list
- Copy product from a shopping list to cart (products are kept in shopping list while added to the cart)
- Copy a whole shopping list to cart (products are kept in shopping list while added to the cart)
- Move products from cart to a shopping list (product are removed from cart and added to the shopping list)
- Move a whole cart to a shopping list (products are removed from cart and added to the shopping list)
- Delete a shopping list

A shopping list only stores product codes.
A shopping list doesn't store quantities.

TODO: illustrate with storefront screenshots?
