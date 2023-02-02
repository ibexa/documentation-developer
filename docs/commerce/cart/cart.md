---
description: The Cart component covers adding items to the shopping cart, as well as previewing and modifying the cart information.
edition: commerce
---

# Cart

The Cart component is a foundation of the Commerce offering delivered as part 
of [[= product_name =]].
It covers actions related to the creation and handling of a list of products 
that the buyer intends to purchase.


The Cart component exposes the following:

- [PHP API](cart_api.md) that allows for managing carts and cart entries, or validating products
- [REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-ecommerce-carts) that helps get cart and products information over HTTP
- [Twig functions](../../templating/twig_function_reference/cart_twig_functions.md) that enable checking whether product can be added to cart and formatting the price

There is no specific configuration related to the Cart component.
All configuration is done at the Checkout and Storefront level.

## Cart data handling

Cart data is handled by two storages, depending on whether the buyer is anonymous 
or has been authenticated.
Information that relates to anonymous users is stored in the PHP session, while 
registered user data is stored in a database.

By default, anonymous users can add items to cart, but to display the cart view, 
they have to log in and transition into an authenticated user.

!!! note 

    For information about roles and permissions that control access to the cart, 
    see [Permission use cases](../../permissions/permission_use_cases.md#commerce).

### Cart data merging

When a buyer browses the storefront anonymously and fills the cart with items, 
anonymous cart data is stored in the PHP session storage.
Then, when an anonymous user logs into the storefront, cart data from the PHP session 
storage is persisted and merged with any cart information that might already exist in the database for this authenticated user.

If no previous cart data exists, a new cart is created.

### Cart data validation

When a buyer tries to add products to the cart, increase cart item quantity or proceed to checkout, the Cart component performs cart item validation and checks whether:

- the product is available 
- the requested quantity of product is available 
- the product is available at a price in the currency selected for the cart 

## Front-end perspective

From the front-end perspective, the Cart consists of a main component 
and several widgets.
Each of these components consists of JavaScript code and accompanying Twig templates.

### Main cart

Main cart is the main UI component of the Cart module.
Among other things, it lists all items selected for purchase, displays 
product/variant images, availability information, requested cart item quantities, 
cart item net prices and subtotals for each cart line. 

Users who visit the Main cart page can change cart line quantities, remove individual items, remove all items and see the total number of products in cart.

### Add to cart

By default, the Add to cart component consists of a quantity input field and a button.

### Minicart

By default, the Minicart component consists of a counter that displays a total number of cart lines.

### Cart summary 

The Cart Summary component displays a subtotal net value of cart lines, a shipping 
cost disclaimer, a series of tax values applicable to products 
added in cart, different taxes composition, and a total cart value (gross, shipping 
  and taxes included) in the selected currency.

Users who visit the Cart summary widget can proceed to checkout or continue shopping 
by clicking one of the buttons.

## Cart object

The `Cart` object stores cart entry data and a cart summary, which contains data from additional entries, like, for example, formatted gross price or validation errors.
The object exposes several methods, which you can use to get and modify cart entries.
Only one instance of a `Cart` object can be created.

## Cart service 

The Cart package provides a cart service, which is a module with functions used for calling the backend API. 
