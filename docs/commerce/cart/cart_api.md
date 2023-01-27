---
description: Use PHP API to work with carts in Commerce, manage cart entries, or validate products.
edition: commerce
---

# Cart API

!!! tip "Cart REST API"

    To learn how to manage carts with the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-ecommerce-carts).

To get carts and work with them, use the `\Ibexa\Contracts\Cart\CartServiceInterface` interface.

`CartService` uses two storage methods and handles switching between storages:

- carts of registered users use database-based storage
- anonymous user carts are stored in the PHP session

From the developer's perspective, carts and entries are referenced with the UUID identifier. 
Numeric ID is used internally with database access optimization in mind but it is not used by the public API.

## Get single cart by identifier

To access a single cart, use the `CartServiceInterface::getCart` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 69) =]]
```

## Get multiple carts

To fetch multiple carts, use the `CartServiceInterface::findCarts` method. 
It follows the same search Query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 7, 8) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 52, 60) =]]
```

## Create cart

To create a cart, use the `CartServiceInterface::createCart` method and provide 
it with `Ibexa\Contracts\Cart\Value\CartCreateStruct` that contains metadata (name, currency):

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 5, 6) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 81) =]]
```

## Update cart metadata

You can update cart metadata after the cart is created. 
You could do it to support a scenario when, for example, the user changes a currency 
and the cart should recalculate all item prices to a new currency. 
To update cart metadata, use the `CartServiceInterface::updateCartMetadata` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 6, 7) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 85, 92) =]]
```

## Delete cart

To delete a cart permanently, use the `CartServiceInterface::deleteCart` method 
and pass the `CartInterface` object:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 126, 127) =]]
```

## Empty cart

To remove all products from the cart in a single operation, use the 
`CartServiceInterface::emptyCart` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 94, 95) =]]
```

## Check cart validity

Items in cart can become invalid, for example, when item price is unavailable 
in cart currency, or the product is no longer available. 
To prevent checking out cart with invalid items, check cart validity first. 
To  validate the cart, use the `CartServiceInterface::validateCart` method. 
Validation is done with help from the `symfony/validator` component, and the method 
returns the `Symfony\Component\Validator\ConstraintViolationListInterface` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 97, 98) =]]
```

## Add entry to cart

To add entries (products) to the cart, encapsulate the product in `Ibexa\Contracts\Cart\Value\EntryAddStruct`, where you specify the requested quantity.
Then pass it to the `CartServiceInterface::addEntry` method: 

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 8, 9) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 102, 109) =]]
```

## Remove entry from cart

To remove an entry from the cart, use the `CartServiceInterface::removeEntry` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 8, 9) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 112, 115) =]]
```

## Update entry metadata

Entries have their own metadata, for example, quantity. 
To change entry metadata, use the `CartServiceInterface::updateEntry` method 
and provide it with `Ibexa\Contracts\Cart\Value\EntryUpdateStruct`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 9, 10) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 66, 67) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 112, 113) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 117, 125) =]]
```
