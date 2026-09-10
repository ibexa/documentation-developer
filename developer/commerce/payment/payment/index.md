# Payment

The payment component covers defining and managing payment methods, together with managing payments and their lifecycle.

Editions: Commerce

With the Payment component users can define and manage payment methods, create and manage payments, search for payment methods and payments, and filter payment search results. Depending on their role, users can also enable or disable payment methods, modify payment information, and cancel payments.

Available payment method types:

- offline – out of the box
- online payment services – through [integration with Payum](../payum_integration/index.md)

From the development perspective, the component enables [customization of the payment workflow](../configure_payment/index.md#custom-payment-workflows).

The component exposes the following APIs:

- [Payment method PHP API](../payment_method_api/index.md) that allows for managing payment methods
- [Payment method REST API](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Payments) that helps manage payment methods over HTTP
- [Payment PHP API](../payment_api/index.md) that allows for managing payments

## Services

The Payment package provides the following services, which are entry points for calling backend APIs:

- `Ibexa\Contracts\Payment\PaymentMethodServiceInterface`
- `Ibexa\Contracts\Payment\PaymentServiceInterface`
