# Payment Method Identifier Criterion

Payment Method Identifier Search Criterion

Editions: Commerce

The `Identifier` Search Criterion searches for payment methods based on the payment method identifier.

## Arguments

- `identifier` - string that represents the payment method identifier

## Example

### PHP

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;

$query = new PaymentMethodQuery(
    new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Identifier('f7578972-e7f4-4cae-85dc-a7c74610204e')
);
```
