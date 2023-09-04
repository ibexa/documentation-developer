---
description: Use PHP API and REST API to work with carts in Commerce, manage cart entries, or validate products.
edition: commerce
---

# Cart API

!!! tip "Cart REST API"

    To learn how to manage carts with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-ecommerce-carts).

To get carts and work with them, use the `Ibexa\Contracts\Cart\CartServiceInterface` interface.

`CartService` uses two storage methods and handles switching between storages:

- carts of registered users use database-based storage
- anonymous user carts are stored in the PHP session

From the developer's perspective, carts and entries are referenced with a UUID identifier. 

## Get single cart by identifier

To access a single cart, use the `CartServiceInterface::getCart` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 76) =]]
```

## Get multiple carts

To fetch multiple carts, use the `CartServiceInterface::findCarts` method. 
It follows the same search Query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 9, 10) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 59, 67) =]]
```

## Create cart

To create a cart, use the `CartServiceInterface::createCart` method and provide 
it with `Ibexa\Contracts\Cart\Value\CartCreateStruct` that contains metadata (name, currency, owner):

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 7, 8) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 80, 88) =]]
```

## Update cart metadata

You can update cart metadata after the cart is created. 
You could do it to support a scenario when, for example, the user changes a currency 
and the cart should recalculate all item prices to a new currency. 
To update cart metadata, use the `CartServiceInterface::updateCartMetadata` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 8, 9) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 92, 99) =]]
```

You can also use this method to change cart ownership:

``` php
use Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct;

// ...

$updateMetadataStruct = new CartMetadataUpdateStruct();
$updateMetadataStruct->setOwner($userService->loadUserByLogin('user'));

$cart = $cartService->updateCartMetadata($cart, $updateMetadataStruct);
```

## Delete cart

To delete a cart permanently, use the `CartServiceInterface::deleteCart` method 
and pass the `CartInterface` object:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 134, 135) =]]
```

## Empty cart

To remove all products from the cart in a single operation, use the 
`CartServiceInterface::emptyCart` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 101, 102) =]]
```

## Check cart validity

Items in cart can become invalid, for example, when item price is unavailable 
in cart currency, or the product is no longer available. 
To prevent checking out a cart with invalid items, check cart validity first. 
To validate the cart, use the `CartServiceInterface::validateCart` method. 
Validation is done with help from the `symfony/validator` component, and the method 
returns a `Symfony\Component\Validator\ConstraintViolationListInterface` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 104, 105) =]]
```

## Add entry to cart

To add entries (products) to the cart, create an `Ibexa\Contracts\Cart\Value\EntryAddStruct`, 
where you specify the requested quantity of the product.
Then pass it to the `CartServiceInterface::addEntry` method: 

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 10, 11) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 109, 116) =]]
```

## Remove entry from cart

To remove an entry from the cart, use the `CartServiceInterface::removeEntry` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 10, 11) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 119, 122) =]]
```

## Update entry metadata

Entries have their own metadata, for example, quantity. 
To change entry metadata, use the `CartServiceInterface::updateEntry` method 
and provide it with `Ibexa\Contracts\Cart\Value\EntryUpdateStruct`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 11, 12) =]]
// ...

[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 73, 74) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 119, 120) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 124, 132) =]]
```

## Merge carts

To combine the contents of multiple shopping carts into a target cart, you can use the `CartServiceInterface::mergeCarts` method. 
This operation is helpful when you want to consolidate items from a reorder cart and a current cart into a single order.

```php
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 138, 142) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 142, 149) =]]
[[= include_file('code_samples/api/commerce/src/Command/CartCommand.php', 149, 152) =]]
```