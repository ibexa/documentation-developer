---
description: The cart component covers adding items to the shopping cart, as well as previewing and modifying the cart information.
edition: commerce
---

# Cart

The cart component is a foundation of the Commerce offering delivered as part 
of [[= product_name =]].
It covers actions related to the creation and handling of a list of products 
that the buyer intends to purchase.

The component exposes the following:

- [PHP API](cart_api.md) that allows for managing carts and cart entries, or checking cart validity
- [REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-ecommerce-carts) that helps get cart and products information over HTTP
- [Twig functions](cart_twig_functions.md) that enable checking whether product can be added to cart and formatting the price

There is no specific configuration related to the cart component.
All configuration is done at the checkout and storefront level.

## Cart data handling

Cart data is handled by two storages, depending on whether the buyer is anonymous 
or has been authenticated.
Information that relates to anonymous users is stored in the PHP session, while 
registered user data is stored in a database.

By default, anonymous users can add items to cart, but to display the cart view, 
they have to log in and transition into an authenticated user.

!!! note 

    For information about roles and permissions that control access to the cart, 
    see [Permission use cases](permission_use_cases.md#commerce).

### Cart data merging

When a buyer browses the storefront anonymously and fills the cart with items, 
anonymous cart data is stored in the PHP session storage.
Then, when an anonymous user logs into the storefront, cart data from the PHP session 
storage is persisted and merged with any cart information that might already exist in the database for this authenticated user.

If no previous cart data exists, a new cart is created.

### Cart data validation

When a buyer tries to add products to the cart, increase cart item quantity or proceed to checkout, the cart component performs cart item validation and checks whether:

- the product is available 
- the requested quantity of product is available 
- the product is available at a price in the currency selected for the cart 

## Front-end perspective

From the front-end perspective, the cart consists of a main `Cart` object 
and several widgets.
`Cart` is a standalone JavaScript object that manages cart data and has no user interface, 
while widgets consist of JavaScript code and accompanying Twig templates.

### Cart service object

The `Cart` service object stores cart entry data and a cart summary, which contains additional entry data, like, for example, formatted gross price or validation errors.
The object exposes several methods, which you can use to get and modify cart entries.
Only one instance of a `Cart` service object can be created.

### Widgets

To customize your store, you can override the Twig templates and extend their logic.
For more information, see [Customize storefront layout](customize_storefront_layout.md).

#### Main cart

Main cart is the main user interface component of the cart.
By default, it lists items selected for purchase and requested cart item quantities. 

Users who visit the Main cart can remove individual items.

#### Add to cart

By default, the Add to cart component consists of a quantity input field and a button.

#### Minicart

By default, the Minicart component consists of a counter that displays a total number of cart items.

#### Cart summary 

By default, the Cart summary component displays a subtotal net value of cart lines, 
a shipping cost disclaimer, a series of tax values applicable to products 
added in cart, a composition of different taxes, and a total cart value (gross, shipping 
and taxes included) in the selected currency.

You could extend the Cart summary widget to let buyers navigate from this view, 
for example, to checkout, or back to shopping, by adding respective buttons.

### Cart service 

The Cart package provides `Ibexa\Contracts\Cart\CartServiceInterface` Symfony service, 
which is the entrypoint for calling the [backend API](cart_api.md).

You can import services using the following code:

```js
import * as cartService from '@ibexa-cart/src/bundle/Resources/public/js/service/cart';
```

Next, use in the code as following example:

```js
cartService.deleteCartEntry(cartIdentifier, entryIdentifier);
```

Every cart service function returns a Promise with a parsed response.
When the request is not `OK`, it can throw an error with the response statusText.

- `loadUserCarts(ownerId)` - loads 10 user carts
- `loadCartSummary(cartIdentifier)` - load cart summary data
- `createCart(currencyCode)` - creates a new cart
- `deleteCart(cartIdentifier)` - deletes the cart
- `createCartEntry(cartIdentifier, productCode, quantity)` - creates a new cart entry for the specified product
- `updateProductQuantity(cartIdentifier, entryIdentifier, quantity)` - updates product quantity to a new value
- `deleteCartEntry(cartIdentifier, entryIdentifier)` - deletes cart entry
- `emptyCart(cartIdentifier)` - empties cart by removing all entries

### Change request before sending

Before the request `ibexa-cart:prepare-request` is sent, an event is triggered on `document`, so you can interchange request objects:

```js
document.addEventListener(
    'ibexa-cart:prepare-request',
    (event) => {
        event.detail.request = modifiedRequest;
    },
    false,
);
```