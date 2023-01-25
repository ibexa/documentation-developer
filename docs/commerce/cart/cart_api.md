---
description: Use PHP API to work with carts in Commerce, manage cart entries, or validate products.
---

# Cart API

!!! tip "Cart REST API"

    To learn how to manage carts with the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html).

To get cart and work with the, use the `\Ibexa\Contracts\Cart\CartServiceInterface` interface.

`CartService` uses two storage methods and handles switching between storages:

- carts of registered users use database-based storage
- anonymous user carts are stored in the PHP session

From the developer's perspective, carts and entries are referenced with the UUID identifier. 
Numeric ID is used internally with database access optimization in mind but it is not used by the public API.

## Get single cart by identifier

To access a single cart, use the `CartServiceInterface::getCart` method:


``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 2, 5) =]]
```

## Get multiple carts

To fetch multiple carts, use the `CartServiceInterface::findCarts` method. 
It follows the same search Query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 8, 20) =]]
```

## Create cart

To create a cart, use the `CartServiceInterface::createCart` method and provide 
it with `Ibexa\Contracts\Cart\Value\CartCreateStruct` that contains metadata (name, currency):

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 23, 35) =]]
```

## Update cart metadata

You can update the cart metadata even after the cart is created. 
You could do it support a scenario when, for example, the user changes a currency 
and the cart should recalculate all item prices to a new currency. 
To update cart metadata, use the `CartServiceInterface::updateCartMetadata` method:

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 38, 49) =]]
```

## Delete cart

To delete a cart permanently, use the `CartServiceInterface::deleteCart` method 
and pass the `CartInterface` object:

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 52, 57) =]]
```

## Empty cart

To remove all products from the cart in a single operation, use the 
`CartServiceInterface::emptyCart` method:

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 60, 65) =]]
```

## Check cart validity

Items in cart can become invalid, for example, when item price is unavailable 
in cart currency, or the product is no longer available. 
To prevent checking out cart with invalid items, check cart validity first. 
To  validate the cart, use the `CartServiceInterface::validateCart` method. 
Validation is done with help from the `symfony/validator` component, and the method 
returns the `Symfony\Component\Validator\ConstraintViolationListInterface` object.

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 68, 72) =]]
```

## Add entry to cart

To add entries (products) to the cart, encapsulate the product in `Ibexa\Contracts\Cart\Value\EntryAddStruct`, where you specify the requested quantity.
Then pass it to the `CartServiceInterface::addEntry` method: 

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 75, 92) =]]
```

## Remove entry from cart

To remove an entry from the cart, use the `CartServiceInterface::removeEntry` method.

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 95, 106) =]]
```

## Update entry metadata

Entries have their own metadata, for example, quantity. 
To change entry metadata, use the `CartServiceInterface::updateEntry` method 
and provide it with `Ibexa\Contracts\Cart\Value\EntryUpdateStruct`.

``` php
[[= include_file('code_samples/api/commerce/cart/CartService.php', 109, 127) =]]
```
