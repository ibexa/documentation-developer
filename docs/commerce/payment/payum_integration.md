---
description: Add new payment methods through Payum such as Stripe or PayPal.
edition: commerce
---

# Payment gateways

[Payum](https://payum.gitbook.io/payum/) simplifies the integration of various payment gateways like Stripe and PayPal into your application.
These gateways are vital for secure online transactions, allowing you to accept multiple payment methods and ensure a seamless experience for customers.
By configuring gateways and translating payment methods, Payum streamlines the process, enabling you to offer a diverse payment experience.

## Payum configuration

In your Payum configuration file (`payum.yaml` or similar), set up the payment gateway by specifying its factory and required credentials:

```yaml
payum:
    gateways:
        <method_identifier>:
            factory: <gateway_factory>
            # Add specific configuration fields for the chosen gateway
            credential_1: <credential_1_value>
            credential_2: <credential_2_value>
            # Add more credentials or settings as required by the chosen gateway

```

Replace `<method_identifier>` with a unique identifier for the payment method.
Define the factory based on the supported gateway.
Include the necessary credentials and settings required by the specific gateway.

## Translations for payment methods

For language translations of payment method names, structure your translation files as follows:

```yaml
ibexa:
    payment_method:
        type:
            <method_identifier>:
                name: "Translated Payment Method Name"

```

Replace `<method_identifier>` with the identifier used in the Payum configuration.
Add translations for each payment method identifier within the ibexa_payment_type namespace in your translation files.

## Implementation

Refer to the specific documentation for each payment gateway to obtain the necessary credentials and configuration settings.
Ensure the accuracy of provided credentials and settings within the Payum configuration.

