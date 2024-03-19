---
description: The payment component covers defining and managing payment methods as well as managing payments and their lifecycle.
edition: commerce
---

# Payment

With the Payment component users can define and manage payment methods, create and manage payments, search for payment methods and payments, and filter payment search results.
Depending on their role, users can also enable or disable payment methods, modify payment information, as well as cancel payments.

Available payment method types:

- offline – out of the box
- online payment services – through [integration with Payum](payum_integration.md)

From the development perspective, the component enables [customization of the payment workflow](configure_payment.md#custom-payment-workflows).

The component exposes the following APIs:

- [Payment method PHP API](payment_method_api.md) that allows for managing payment methods
- [Payment method REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#payment-methods) that helps manage payment methods over HTTP
- [Payment PHP API](payment_api.md) that allows for managing payments

### Services

The Payment package provides the following services, which are entry points for calling backend APIs:

- `Ibexa\Contracts\Payment\PaymentMethodServiceInterface`
- `Ibexa\Contracts\Payment\PaymentServiceInterface`