# CheckoutController

`CheckoutController` (`Siso\Bundle\CheckoutBundle\Controller\CheckoutController`) is the entry point for the checkout process.

## indexAction()

Before the user enters the checkout process (`indexAction()`), [Checkout Events](checkout_events.md) are thrown
that enable you to interrupt the checkout process if required.

Calling `indexAction()` triggers `validateStepAction()`.
Depending on which step the user is in, it forwards the call to that `AjaxController` method. 
