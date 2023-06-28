---
description: The payment component covers defining and managing payment methods as well as managing payments and their lifecycle.
edition: commerce
---

# Payment

The Payment component enables users to define and manage payment methods, as well as create and manage payments, search for payment methods and payments and filter payment search results. 
Depending on their role, users can also enable or disable payment methods, modify payment information, as well as cancel payments.

Only one payment method type is available: `offline`.

From the development perspective, the component enables customization of the payment workflow. 

The component exposes the following:

- [Payment method PHP API](payment_method_api.md) that allows for managing payment methods
- [Payment method REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#orders) that helps manage payment methods over HTTP
- [Payment PHP API](payment_api.md) that allows for managing payments


### Services

The Payment package provides the following services, which are entry points for calling backend APIs:

- `Ibexa\Contracts\Payment\PaymentMethodServiceInterface`
- `Ibexa\Contracts\Payment\PaymentServiceInterface`
