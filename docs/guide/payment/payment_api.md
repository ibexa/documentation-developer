# Payment API

## Payment bundle

Additional payment providers can be implemented as described below. See [Building new payment plugins](building_new_payment_plugins.md) as well.

`SisoPaymentBundle` defines and implements an interface to the `JMSPaymentCoreBundle`. 
The main interface is represented by the `PaymentServiceInterface`, which is the public access point to payment processing.

## PaymentServiceInterface

`PaymentServiceInterface::processPayment()` starts all payment processes.
It tries to completely process the payment and throws a `RedirectionRequiredException`
if the payment method represented by `$paymentMethodIdentifier` needs an HTTP redirection to a payment portal site in order to progress in the payment
(for example for an input of critical data like a credit card number).
The calling instance must take responsibility for this exception and handle the redirection accordingly.

The following data is necessary to start the payment process:

- `$orderId` is a valid identifier for the instance which holds the order data
- `$paymentMethodIdentifier` is a string which uniquely identifies a payment plugin implementation (e.g. for PayPal Express Checkout)
- `$amount` holds the amount to be paid (in the lowest available unit of currency, e.g. euro cents)
- `$currency` holds a string which identifies the currency of the `$amount`
- `$extendedData` (optional) can be used for specific configuration of the given `$paymentMethodIdentifier` and thus the respective payment plugin

If more user interaction is needed (e.g. to authorize the transaction at a payment gateway),
the `finalizePayment()` method ends the payment process.
This method can also throw the `RedirectionRequiredException`.
The `$orderId` parameter must pass the identifier of the order instance that was also passed to `processPayment()`.
The optional `$additionalData` parameter can be used to pass further information to the payment external data. For example, it can extract important fields from the payment gateways response.

After the payment process is successfully processed, you can get the respective transaction ID
that was provided by the payment gateway. For this, the interface provides the `determinePaymentTransactionId()` method.

### Example of starting the payment process

``` php
/** @var PaymentServiceInterface $paymentService */
$paymentService = $this->get('siso_payment.payment_service');
$copiedBasket = $basketService->copyBasket($basket);
try {
    $copiedBasket->setState(BasketService::STATE_OFFERED);
    $basketService->storeBasket($copiedBasket);
    $paymentService->processPayment(
        $copiedBasket->getBasketId(),
        $copiedBasket->getPaymentMethod(),
        $copiedBasket->getTotalsSum()->getTotalNet(),
        $copiedBasket->getTotalsSum()->getCurrency()
    );
    // Store the transaction ID where it is available for the ERP communication
    $this->storeTransactionId(
        $paymentService->determinePaymentTransactionId($orderId)
    );
    $copiedBasket->setState(BasketService::STATE_PAYED);
} catch (RedirectionRequiredException $ex) {
    $redirectUrl = $ex->getUrl();
    // Invoke an HTTP redirect to the payment portal on the Users HTTP-client 
    $this->performHttpRedirect($redirectUrl);
}
```

### Example of finalizing the payment process

``` php
$additionalData = array(
    'notify_data' => $request->request->all(),
);
$paymentService->finalizePayment($orderReference, $additionalData);
$transactionId = $paymentService->determinePaymentTransactionId($orderReference);
/** @var Basket $order */
$order = $this->fetchOrderEntity($orderReference);
$order->setPaymentTransactionId($transactionId);
$order->setState(BasketService::STATE_PAYED);
$this->storeOrder($order);
$orderSucessfull = $this->submitOrderToErp($order);
if ($orderSucessfull) {
    $order->setState(BasketService::STATE_CONFIRMED);
    $this->storeOrder($order);
}
```

## PluginConfigurationInterface

Payment plugin `telecash_connect` (and most payment gateways) requires storing the return URLs in the extended data of the `PaymentInstruction` entity.
This is because the related basket/order ID needs to be appended to the URL to determine the basket
and the related payment instruction for further processing in the returning URL requests.
It is impossible to configure the URLs via the Symfony container, as the basket ID is determined dynamically.

This interface is used to provide an adaptable way to integrate the various data fields which can be used by the different payment plugins for storing e.g. URL information.
You must implement this interface for every payment plugin that should be available in the [[= product_name_com =]],
if more than the standard fields like amount, are necessary for the payment process.

The interface defines a single method, `createExtendedDataForOrder($orderReference)`,
which builds and returns the respective configuration data within an associative PHP array.

### Service definition

To register an implementation of this interface to `StandardPaymentService` you need to define it as a service and tag it.
The tag name is `payment.plugin.config` and it needs an attribute named `paymentMethod`,
which must be the same as the plugin form `alias`, for example:

``` xml
<service id="payment.plugin.telecash_connect.config"
         class="%payment.plugin.telecash_connect.config.class%">
    <tag name="payment.plugin.config" paymentMethod="telecash_connect" />
</service>
```

## StandardPaymentService

`StandardPaymentService` implements the `PaymentServiceInterface`.
The `PaymentInstructionBasketMap` entity stores the relation between the shop's basket entities and the payment entities.
The service also uses `PluginConfigurationInterface` to inject the respective payment configuration into `PaymentInstruction`.

The service's standard definition is the following:

``` xml
<parameters>
    <parameter key="siso_payment.payment_service.class">Siso\Bundle\PaymentBundle\Api\StandardPaymentService</parameter>
</parameters>
<services>
    <service id="siso_payment.payment_service"
             class="%siso_payment.payment_service.class%">
        <argument type="service" id="doctrine.orm.entity_manager" />
        <argument type="service" id="payment.plugin_controller" />
    </service>
</services>
```
