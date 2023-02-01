---
description: Use PHP API to work with checkouts in Commerce.
edition: commerce
---

# Checkout API

To get checkouts and manage them, use the `\Ibexa\Contracts\Checkout\CheckouterviceInterface` interface.

To manipulate checkouts that are stored in sessions, you use `CheckoutService`. 
Checkouts are containers for the `Ibexa\Contracts\Cart\Value\CartInterface` object 
and all the data provided at each step of the [configurable checkout process](configure_checkout.md). 
The dataset is flexible but minimized due to session size restrictions. 
Therefore, objects cannot contain too much data and must be serializable. 

The checkout process relies on Symfony Workflow, and you can customize each of its steps. 
Each checkout step has its own controller that allows adding forms and external API calls 
that process data and pass them to `CheckoutService`. 
Completing a step results in submitting a form and updating the current checkout object. 
At this point Symfony Workflow advances, the next controller takes over, and the 
whole process continues.

From the developer's perspective, checkouts are referenced with the UUID identifier. 

## Get single checkout by identifier

To access a single checkout, use the `CheckoutServiceInterface::getCheckout` method:

``` php
[[= include_file('code_samples/api/commerce/src/Controller/CustomCheckoutController.php', 31, 32) =]]
```

## Get single checkout for specific cart

To fetch checkout for a cart that already exists, use the `CheckoutServiceInterface::getCheckoutForCart` method. 
It can come in handy when you want to initiate the checkout process right after 
products are completed within a cart.

``` php
[[= include_file('code_samples/api/commerce/src/Controller/CustomCheckoutController.php', 25, 29) =]]
```

## Create checkout

To create a checkout, use the `CheckoutServiceInterface::createCheckout` method and 
provide it with `Ibexa\Contracts\Checkout\Value\CheckoutCreateStruct` that contains  `Ibexa\Contracts\Cart\Value\CartInterface`.

``` php
[[= include_file('code_samples/api/commerce/src/Controller/CustomCheckoutController.php', 34, 40) =]]
```

## Update checkout

You can update the collected data after the checkout is created.
The data is stored within the `Ibexa\Contracts\Checkout\Value\CheckoutInterface::context` object. 
The last update time and status are also identified. 

To update the checkout, use the `CheckoutServiceInterface::updateCheckout` method 
and provide it with `CheckoutUpdateStruct` that contains data collected at each 
step of the workflow, as well as a transition name to identify what step will follow. 

All data is placed in session storage.

``` php
[[= include_file('code_samples/api/commerce/src/Controller/CustomCheckoutController.php', 42, 44) =]]
```

## Delete checkout

To delete a checkout from the session, use the `CheckoutServiceInterface::deleteCheckout` method:

``` php
[[= include_file('code_samples/api/commerce/src/Controller/CustomCheckoutController.php', 46, 47) =]]
```
