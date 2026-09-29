# Cart API

Use PHP API and REST API to work with carts in Commerce, manage cart entries, or validate products.

Editions: Commerce

> **Tip: Cart REST API**
>
> To learn how to manage carts with the REST API, see the [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Cart).

To get carts and work with them, use the `Ibexa\Contracts\Cart\CartServiceInterface` interface.

`CartService` uses two storage methods and handles switching between storages:

- carts of registered users use database-based storage
- anonymous user carts are stored in the PHP session

From the developer's perspective, carts and entries are referenced with a UUID identifier.

## Get single cart by identifier

To access a single cart, use the `CartServiceInterface::getCart` method:

```php
$cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

$output->writeln($cart->getName());
```

## Get multiple carts

To fetch multiple carts, use the `CartServiceInterface::findCarts` method. It follows the same search Query pattern as other APIs:

```php
use Ibexa\Contracts\Cart\Value\CartQuery;

// ...

        $cartQuery = new CartQuery();
        $cartQuery->setOwnerId(14); // carts created by User ID: 14
        $cartQuery->setLimit(20); // fetch 20 carts

        $cartsList = $this->cartService->findCarts($cartQuery);

        $cartsList->getCarts(); // array of CartInterface objects
        $cartsList->getTotalCount(); // number of matching carts regardless of the limit
```

## Create cart

To create a cart, use the `CartServiceInterface::createCart` method and provide it with `Ibexa\Contracts\Cart\Value\CartCreateStruct` that contains metadata (name, currency, owner):

```php
use Ibexa\Contracts\Cart\Value\CartCreateStruct;

// ...

        $cartCreateStruct = new CartCreateStruct(
            'Default cart',
            $currency // Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface
        );

        $cart = $this->cartService->createCart($cartCreateStruct);

        $output->writeln($cart->getName()); // prints 'Default cart' to the console
```

## Update cart metadata

You can update cart metadata after the cart is created. You could do it to support a scenario when, for example, the user changes a currency and the cart should recalculate all item prices to a new currency. To update cart metadata, use the `CartServiceInterface::updateCartMetadata` method:

```php
use Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct;

// ...

        $cartUpdateMetadataStruct = new CartMetadataUpdateStruct();
        $cartUpdateMetadataStruct->setName('New name');
        $cartUpdateMetadataStruct->setCurrency($newCurrency);

        $updatedCart = $this->cartService->updateCartMetadata($cart, $cartUpdateMetadataStruct);

        $output->writeln($updatedCart->getName()); // prints 'New name' to the console
```

You can also use this method to change cart ownership:

```php
use Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct;

// ...

/**
 * @var \Ibexa\Contracts\Core\Repository\UserService $userService
 * @var \Ibexa\Contracts\Cart\CartServiceInterface $cartService
 * @var \Ibexa\Contracts\Cart\Value\CartInterface $cart
 */
$updateMetadataStruct = new CartMetadataUpdateStruct();
$updateMetadataStruct->setOwner($userService->loadUserByLogin('user'));

$cart = $cartService->updateCartMetadata($cart, $updateMetadataStruct);
```

## Delete cart

To delete a cart permanently, use the `CartServiceInterface::deleteCart` method and pass the `CartInterface` object:

```php
        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $this->cartService->deleteCart($cart);
```

## Empty cart

To remove all products from the cart in a single operation, use the `CartServiceInterface::emptyCart` method:

```php
        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $this->cartService->emptyCart($cart);
```

## Check cart validity

Items in cart can become invalid, for example, when item price is unavailable in cart currency, or the product is no longer available. To prevent checking out a cart with invalid items, check cart validity first. To validate the cart, use the `CartServiceInterface::validateCart` method. Validation is done with help from the `symfony/validator` component, and the method returns a `Symfony\Component\Validator\ConstraintViolationListInterface` object.

```php
        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $violationList = $this->cartService->validateCart($cart); // Symfony\Component\Validator\ConstraintViolationListInterface
```

## Add entry to cart

To add entries (products) to the cart, create an `Ibexa\Contracts\Cart\Value\EntryAddStruct`, where you specify the requested quantity of the product. Then pass it to the `CartServiceInterface::addEntry` method:

```php
use Ibexa\Contracts\Cart\Value\EntryAddStruct;

// ...

        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $entryAddStruct = new EntryAddStruct($product);
        $entryAddStruct->setQuantity(10);

        $cart = $this->cartService->addEntry($cart, $entryAddStruct);

        $entry = $cart->getEntries()->first();
        $output->writeln($entry->getProduct()->getName()); // prints product name to the console
```

## Remove entry from cart

To remove an entry from the cart, use the `CartServiceInterface::removeEntry` method.

```php
        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $entry = $cart->getEntries()->first();

        $cart = $this->cartService->removeEntry($cart, $entry); // updated Cart object
```

## Update entry metadata

Entries have their own metadata, for example, quantity. To change entry metadata, use the `CartServiceInterface::updateEntry` method and provide it with `Ibexa\Contracts\Cart\Value\EntryUpdateStruct`.

```php
use Ibexa\Contracts\Cart\Value\EntryUpdateStruct;

// ...

        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $entry = $cart->getEntries()->first();

        $entryUpdateStruct = new EntryUpdateStruct(5);
        $entryUpdateStruct->setQuantity(10);

        $cart = $this->cartService->updateEntry(
            $cart,
            $entry,
            $entryUpdateStruct
        ); // updated Cart object
```

## Adding context data

Context data is an extra information that you can attach to the cart or cart entries to provide additional details or attributes related to the shopping experience. It can include any relevant information that you want to associate with a particular cart or cart entry, for example, coupon codes, custom products attributes, or user preferences.

### Adding context data to cart

To add context data to a cart, follow this example:

```php
use Ibexa\Contracts\Cart\Value\CartCreateStruct;
use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface;

/**
 * @var \Ibexa\Contracts\Cart\CartServiceInterface $cartService
 * @var CurrencyInterface $currency
 */
$createStruct = new CartCreateStruct('My Cart', $currency);
$createStruct->setContext(new ArrayMap([
    'coupon_code' => 'X1MF7699',
]));

$cart = $cartService->createCart($createStruct);
```

In the above example, you create a cart with the `CartCreateStruct` method, and set the context data with `setContext`. You also add "X1MF7699" coupon code as context data to the cart.

### Adding context data to cart entry

To attach context data to a cart entry, proceed as follows:

```php
use Ibexa\Contracts\Cart\Value\EntryAddStruct;
use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\ProductCatalog\Local\Repository\Values\Product;

/**
 * @var \Ibexa\Contracts\Cart\CartServiceInterface $cartService
 * @var \Ibexa\Contracts\Cart\Value\CartInterface $cart
 * @var Product $product
 */
$entryAddStruct = new EntryAddStruct($product);
$entryAddStruct->setContext(new ArrayMap([
    'tshirt_text' => 'EqEqEqEq',
]));

 $cartService->addEntry($cart, $entryAddStruct);
```

In the above example, you create a cart entry by using the `EntryAddStruct` method. The `setContext` method allows you to attach context data to the cart entry. In this case, you attach a "tshirt_text" attribute to the cart entry, which might represent custom text for a T-shirt.

## Merge carts

To combine the contents of multiple shopping carts into a target cart, use the `CartServiceInterface::mergeCarts` method. This operation is helpful when you want to consolidate items from a reorder cart and a current cart into a single order.

```php
// Get the order with items that should be reordered
$orderIdentifier = '2e897b31-0d7a-46d3-ba45-4eb65fe02790';
$order = $this->orderService->getOrderByIdentifier($orderIdentifier);

// Get the cart to merge
$existingCart = $this->cartResolver->resolveCart();

$reorderCart = $this
    ->reorderService
    ->addToCartFromOrder($order, $this->reorderService->createReorderCart($order));

// Merge the carts into the target cart and delete the merged carts
$reorderCart = $this->cartService->mergeCarts($reorderCart, true, $existingCart);
```
