---
description: Add new payment methods through Payum such as Stripe or PayPal.
edition: commerce
---

# Payum integration

[Payum](https://payum.gitbook.io/payum/) is a payment processing solution that simplifies the integration of various payment services like Stripe and PayPal into your application.
These services provide security of online transactions, and allow you to accept multiple payment methods while ensuring a seamless experience for the customers.
By configuring service gateways, mapping workflow actions and translating payment service names, you streamline the online payment process, and can offer a diverse payment experience.

## General Payum configuration

In your Payum configuration file, for example, `payum.yaml`, set up a payment service gateway by specifying the factory, credentials and other necessary settings.
Replace `<payment_method_identifier>` with a unique identifier of the method provided by the payment service.

```yaml
payum:
    gateways:
        <payment_method_identifier>:
            factory: <gateway_factory>
            # Add specific configuration fields for the gateway
            credential_1: <credential_1_value>
            credential_2: <credential_2_value>
```

## Workflow mapping

In [[= product_name =]], the default payment workflow has certain places, such as `pending`, `failed`, `paid`, or `cancelled`, and their corresponding transitions.

However, for your application to use other transitions and places, for example, `authorized`, `notified`, `refunded` etc., and to present them in the user interface, you need to:

- override the default payment workflow
- create a custom workflow and enable it by using semantic configuration

For more information, see [Custom payment workflows](configure_payment.md#custom-payment-workflows).

For these places to be supported by the Payum integration, you have to map Payum statuses on the existing or additional places in the workflow, for example:

```yaml
ibexa_connector_payum:
    status_mapping:
        refunded: cancelled
        captured: pending
        authorized: authorized
[...]
```

## Payment service name translations

Within the `ibexa_payment_type` namespace in your translation files, add translations for each payment service that you configure.
For language translations of payment service names, structure the translation files as follows:

```yaml
ibexa:
    payment_method:
        type:
            <service_identifier>:
                name: "Translated payment service name"

```

!!! note

    Replace `<service_identifier>` with the identifier used in the Payum configuration.

## Implementation

When you implement the online payment solution, take the following consideration into account:

- To learn what credentials must be provided and what specific settings must be made, refer to the each payment service gateway's specific documentation.
- To customize the online payment UI, see [Creating custom views](https://github.com/Payum/Payum/blob/master/docs/symfony/custom-payment-page.md) in Payum documentation.
- When you modify the payment process, you may need to subscribe to events dispatched by Payum.
For a list of events, see [Event dispatcher](https://github.com/Payum/Payum/blob/master/docs/event-dispatcher.md) in Payum documentation.


!!! caution

    In certain cases, depending on the payment processing service, when a customer closes the payment page in a browser and the bank has not processed the payment yet, the payment status can remain unchanged.
    Depending on how your checkout process is configured, it may result in unwanted effects, for example, cause that the cart does not purge after the purchase.
    Make sure that you account for this fact in your implementation.
