# Payment API [[% include 'snippets/commerce_badge.md' %]]

## Payment bundle

`SisoPaymentBundle` defines and implements an interface to the `JMSPaymentCoreBundle`. 
The main interface is represented by `PaymentServiceInterface`, which is the public access point to payment processing.

## PaymentServiceInterface

`PaymentServiceInterface::processPayment()` starts all payment processes.
It tries to process the payment and throws a `RedirectionRequiredException`
if the payment method represented by `paymentMethodIdentifier` needs an HTTP redirection to a payment portal site to advance the payment
(for example for an input of critical data like a credit card number).
The calling instance must take responsibility for this exception and handle the redirection accordingly.

The following data is necessary to start the payment process:

- `orderId` is a valid identifier for the instance that holds the order data
- `paymentMethodIdentifier` is a string that uniquely identifies a payment plugin implementation
- `amount` holds the amount to be paid (in the lowest available unit of currency, e.g. euro cents)
- `currency` holds a string that identifies the currency of the `amount`
- `extendedData` (optional) can be used for specific configuration of the given `paymentMethodIdentifier` and thus the respective payment plugin

If more user interaction is needed (e.g. to authorize the transaction at a payment gateway),
the `finalizePayment()` method ends the payment process.
This method can also throw the `RedirectionRequiredException`.
The `orderId` parameter must pass the identifier of the order instance that was also passed to `processPayment()`.
The optional `additionalData` parameter can be used to pass further information to the payment external data.
For example, it can extract important fields from the payment gateway's response.

After the payment process is successfully processed, you can get the respective transaction ID
that was provided by the payment gateway. For this, the interface provides the `determinePaymentTransactionId()` method.

## PluginConfigurationInterface

A payment plugin (and most payment gateways) requires storing the return URLs in the extended data of the `PaymentInstruction` entity.
This is because the related basket/order ID needs to be appended to the URL to determine the basket
and the related payment instruction for further processing in the returning URL requests.
It is impossible to configure the URLs via the Symfony container, as the basket ID is determined dynamically.

You must implement this interface for every payment plugin,
if more than the standard fields like amount are necessary for the payment process.

The interface defines a single method, `createExtendedDataForOrder($orderReference)`,
which builds and returns the respective configuration data in an associative array.

### Service definition

To register an implementation of this interface to `StandardPaymentService` you need to define it as a service and tag it.
The tag name is `payment.plugin.config` and it needs an attribute named `paymentMethod`,
which must be the same as the plugin form `alias`, for example:

``` xml
<service id="payment.plugin.custom_payment.config"
         class="%payment.plugin.custom_payment.config.class%">
    <tag name="payment.plugin.config" paymentMethod="custom_payment" />
</service>
```

## StandardPaymentService

`StandardPaymentService` implements the `PaymentServiceInterface`.
The `PaymentInstructionBasketMap` entity stores the relation between the shop's basket entities and the payment entities.
The service also uses `PluginConfigurationInterface` to inject the respective payment configuration into `PaymentInstruction`.
