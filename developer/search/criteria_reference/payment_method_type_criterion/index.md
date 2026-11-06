# Payment Method Type Criterion

Payment Method Type Search Criterion

Editions: Commerce

The `Type` Search Criterion searches for payment methods based on payment method type.

## Arguments

- `type` - string that represents a payment method type

## Example

### PHP

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;

/** @var \Ibexa\Contracts\Payment\PaymentMethod\Type\TypeRegistryInterface $paymentMethodTypeRegistry */
$paymentMethodType = $paymentMethodTypeRegistry->getPaymentMethodType('offline');

$query = new PaymentMethodQuery(
    new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Type($paymentMethodType)
);
```
