# AjaxCheckoutController

`AjaxCheckoutController` (`Siso\Bundle\CheckoutBundle\Controller\AjaxCheckoutController`) is the subcontroller responsible for Phalanx calls in the one-page checkout process.

`AjaxCheckoutController` first calls `validateStepAction()` to calculate the current possible step depending on:

- form validation
- submitted data (checkboxes)
- customer data
- basket (e.g. calling `#summary` when no delivery address is filled redirects to the delivery step)

## How the steps are handled?

The `Siso/Bundle/CheckoutBundle/Api/CheckoutStepServiceInterface` interface defines steps for handling the checkout process.

``` php
/**
 * Returns the next valid checkout step for $currentStep.
 * The $requestedStep is preferred, but could be skipped due to some
 * implemented validation rules.
 *
 * The result must be one of CheckoutSources::STEP_* constants
 * @see \Siso\Bundle\CheckoutBundle\Model\CheckoutSources
 *
 * @param string $currentStep   One of CheckoutSources::STEP_* constants
 * @param string $requestedStep One of CheckoutSources::STEP_* constants
 * @param string $userStatus    One of CheckoutSources::USER_* constants
 * @param Basket $basket
 * @return null|string  One of CheckoutSources::STEP_* constants
 */
public function getNextValidStep($currentStep, $requestedStep, $userStatus, Basket $basket);
```

The default implementation of this interface is `DefaultCheckoutStepService` (`Siso/Bundle/CheckoutBundle/Service/DefaultCheckoutStepService.php`)
which ensures that the user is forwarded to the correct step and all necessary data is stored in the basket.
It checks whether the user is able to see the requested step. If they do not have the proper permissions,
they are forwarded to the last possible step.

The checkout steps are defined in the following method:

``` php
public static final function getAllCheckoutSteps()
{
    return array(
        CheckoutSources::STEP_LOGIN,
        CheckoutSources::STEP_INVOICE,
        CheckoutSources::STEP_DELIVERY,
        CheckoutSources::STEP_SHIPPING_PAYMENT,
        CheckoutSources::STEP_SUMMARY
    );
}
```

`validateStepAction()` uses this service to determine the correct step.

``` php
/** @var CheckoutStepServiceInterface $checkoutStepService */
$checkoutStepService = $this->get('siso_checkout.default_checkout_step_service');

$requestedStep = isset($data[0]['step']) && $data[0]['step'] ? $data[0]['step'] : $currentStep;
$currentStep = $checkoutStepService->getNextValidStep($currentStep, $requestedStep, $userStatus, $basket);
```

If you want to skip a step in the checkout process, override `DefaultCheckoutStepService`.
When skipping steps, make sure that you store all required data in the basket.

``` xml
<parameter key="siso_checkout.default_checkout_step_service.class">Siso\Bundle\CheckoutBundle\Service\DefaultCheckoutStepService</parameter>

<service id="siso_checkout.default_checkout_step_service" class="%siso_checkout.default_checkout_step_service.class%">
    <argument type="service" id="ses.customer_profile_data.ez_erp" />
    <argument type="service" id="silver_basket.basket_service" />
</service>
```

In the `validateStepAction()` checkout events are thrown that enable you to interrupt the checkout process.

### `validateLogin()`

|||||
|---|---|---|---|
|form valid||||
|submitted data||||
|customer data|anonymous|customer without number|customer with number|
|current step|login|delivery|shippingPayment|

This method displays the login form with possible options for registration and ordering as a guest. 

### `validateInvoice()`

form valid: true

||||
|---|---|---|
|submitted data|invoiceAsDelivery checked|invoiceAsDelivery not checked|
|customer data|||
|current step|shippingPayment|delivery|

form valid: false

||||
|---|---|---|
|submitted data|-|-|
|customer data|	customer without no|else|
|current step|delivery|invoice|

On success this method stores the invoice address in the basket.
If the `invoiceAsDelivery` checkbox is ticked, the method also stores the delivery address. 

### `validateDelivery()`

||||
|---|---|---|
|form valid|true|false|
|submitted data|-|-|
|customer data|||
|current step|shippingPayment|delivery|

This method creates the form based on configuration and determines which `addressStatus` radio button option should be chosen.
There are different scenarios for anonymous users, users without and with a customer number.   
When the user has no default delivery address, the option to display existing addresses is disabled.  
On success, the method stores the delivery address in the basket. If `saveAddress` was checked it stores the address in `CustomerProfileData`.  

### `validateShippingPayment()`

||||
|---|---|---|
|form valid|true|false|
|submitted data|-|-|
|customer data|||
|current step|summary|shippingPayment|

On success the method stores the shipping/payment method in the basket.  

### `validateSummary()`

||||
|---|---|---|
|form valid|true|false|
|submitted data|||
|customer data|||
|current step|summary|summary|

On success this method  stores data in basket and copies the basket with state `confirmed`.
Next, it redirects the user to order confirmation.

In this step, the total gross amount may be rounded to two decimal digits.
This is because the amount is used to process the payment later on and nearly all payment transaction don't allow values with more than two decimal digits.
You can disable this behavior by setting `round_totals` to `false`:

`siso_checkout.default.payment.round_totals: false`

### Delivery step

Phalanx performs the following actions during the delivery step:

1. `getExistingDelivery()` is triggered with the delivery `addressStatus` option. It looks for customer delivery parties and fills the form with them. Sets the default address if no data set. Returns delivery template form.  
2. `getEmptyDelivery()` is triggered with delivery `addressStatus` option. It returns an empty delivery template form.
3. `getDeliveryFromInvoice()` is triggered with delivery `addressStatus` option. It returns a delivery template form based on a previously filled invoice form.

### Validation step

`validateStep()` validates the step for which the request was made and returns the current step.
This prevents the user from reaching steps they shouldn't have access to.
Additionally, if the user is logged in with a customer number, the request to the ERP takes place to get the latest invoice address.
This prevents showing incorrect addresses in the basket for the user.

### Overriding the controller

To override actions from `AjaxCheckoutController`, create a new controller which extends `AjaxCheckoutController`.
In the new controller you can reimplementend the actions.
Then, register the new controller as the controller for Ajax requests with the type `checkout`:

``` yaml
parameters:
    siso_eshop.ajax_controller.checkout: "YourBundle:NewAjaxCheckout"
```
