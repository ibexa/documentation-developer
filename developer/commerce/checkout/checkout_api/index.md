# Checkout API

Use PHP API to work with checkouts in Commerce.

Editions: Commerce

To get checkouts and manage them, use the `Ibexa\Contracts\Checkout\CheckoutServiceInterface` interface.

With `CheckoutServiceInterface`, you manipulate checkouts that are stored in sessions. Checkouts are containers for the `Ibexa\Contracts\Cart\Value\CartInterface` object and all the data provided at each step of the [configurable checkout process](../configure_checkout/index.md).

The checkout process relies on Symfony Workflow, and you can customize each of its steps. Each checkout step has its own controller that allows adding forms and external API calls that process data and pass them to `CheckoutService`. Completing a step results in submitting a form and updating the current checkout object. At this point Symfony Workflow advances, the next controller takes over, and the whole process continues.

From the developer's perspective, checkouts are referenced with an UUID identifier.

## Get single checkout by identifier

To access a single checkout, use the `CheckoutServiceInterface::getCheckout` method:

```php
$checkout = $this->checkoutService->getCheckout($checkoutIdentifier);
```

## Get single checkout for specific cart

To fetch checkout for a cart that already exists, use the `CheckoutServiceInterface::getCheckoutForCart` method. You can use it when you want to initiate the checkout process right after products are successfully added to a cart.

```php
$cart = $this->cartService->getCart('d7424b64-7dc1-474c-82c8-1700f860d55e');

$checkoutForCart = $this->checkoutService->getCheckoutForCart($cart);
$checkoutIdentifier = $checkoutForCart->getIdentifier();
```

## Create checkout

To create a checkout, use the `CheckoutServiceInterface::createCheckout` method and provide it with a `CheckoutCreateStruct` struct that contains a `CartInterface` object.

```php
$newCart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

$checkoutCreateStruct = $this->checkoutService->newCheckoutCreateStruct($newCart);
$newCheckout = $this->checkoutService->createCheckout($checkoutCreateStruct);

$newCheckoutIdentifier = $newCheckout->getIdentifier();
```

## Update checkout

You can update the collected data after the checkout is created. The data is stored within the `CheckoutInterface::context` object. The last update time and status are also stored.

To update the checkout, use the `CheckoutServiceInterface::updateCheckout` method and provide it with the `CheckoutUpdateStruct` struct that contains data collected at each step of the workflow, and a transition name to identify what step follows.

All data is placed in session storage.

```php
$checkoutUpdateStruct = $this->checkoutService->newCheckoutUpdateStruct('select_address');
$this->checkoutService->updateCheckout($newCheckout, $checkoutUpdateStruct);
```

## Delete checkout

To delete a checkout from the session, use the `CheckoutServiceInterface::deleteCheckout` method:

```php
$this->checkoutService->deleteCheckout($newCheckout);
```
