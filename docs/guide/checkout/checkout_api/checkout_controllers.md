# Checkout controllers

## CheckoutController

`CheckoutController` (`Siso\Bundle\CheckoutBundle\Controller\CheckoutController`) is the entry point for the checkout process.

Before the user enters the checkout process, [Checkout Events](checkout_events.md) are thrown
that enable you to interrupt the checkout process if required.

Calling `indexAction()` triggers `validateStepAction()`.
Depending on which step the user is in, it forwards the call to the relevant `AjaxController` method. 

## AjaxCheckoutController

`AjaxCheckoutController` (`Siso\Bundle\CheckoutBundle\Controller\AjaxCheckoutController`)
is the subcontroller responsible for calls in the checkout process.

`AjaxCheckoutController` first calls `validateStepAction()` to calculate the current possible step depending on:

- form validation
- submitted data (checkboxes)
- customer data
- basket (for example, calling `#summary` when no delivery address is filled redirects to the delivery step)
