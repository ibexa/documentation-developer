# Extend Payment

Extend Payment with custom payment method types.

Editions: Commerce

You can extend your Payment module implementation:

- by creating a custom payment method type
- by attaching custom data to a payment

You can also [customize the payment processing workflow](../configure_payment/index.md#custom-payment-workflows).

## Create custom payment method type

If your application needs payment methods of other type than the default `offline` one, or ones offered by Payum, you can create custom payment method types. Code samples below show how this could be done if your organization wants to use PayPal independently.

> **Note: Gateway integration requirement**
>
> Ibexa DXP doesn't come with gateway redirects. Whether you're an integrator or an end customer, it's your responsibility to implement payment gateway integration.

### Define custom payment method type

Create a PHP definition of the payment method type.

```php
<?php

declare(strict_types=1);

namespace App\Payment;

use Ibexa\Contracts\Payment\PaymentMethod\Type\TypeInterface;

final class PayPal implements TypeInterface
{
    public function getIdentifier(): string
    {
        return 'paypal';
    }

    public function getName(): string
    {
        return 'PayPal';
    }
}
```

Make sure that `getName()` returns a human-readable name of the payment method type, the way you want it to appear on the list of available payment method types.

Now, register the definition as a service:

```yaml
services:
    App\Payment\PayPal: 
        tags: 
            name: ibexa.payment.payment_method.type 
            alias: paypal
```

As an alternative, instead of creating a custom class, you can use a built-in type factory to define the payment method type in the service definition file:

```yaml
services:
    app.payment.type.paypal:
        class: Ibexa\Contracts\Payment\PaymentMethod\Type\TypeInterface
        factory: [ '@Ibexa\Contracts\Payment\PaymentMethod\Type\TypeFactoryInterface', 'createType' ]
        arguments:
            $identifier: 'paypal'
            $name: 'PayPal'
        tags:
            - name: ibexa.payment.payment_method.type
              alias: paypal
```

At this point a custom payment method type should be visible in the user interface.

### Create options form

Create a corresponding form type:

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayPalOptionsType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add('base_url', UrlType::class, [
            'constraints' => [new NotBlank()],
        ]);

        // ...
    }
}
```

Next, create a mapper that maps the information that the user inputs in the form into attribute definition.

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsFormMapper implements OptionsFormMapperInterface
{
    public function createOptionsForm(
        string $name,
        FormBuilderInterface $builder,
        array $context = []
    ): void {
        $builder->add($name, PayPalOptionsType::class);
    }
}
```

Then, register `OptionsFormMapper` as a service:

```yaml
services:
    App\Form\Type\OptionsFormMapper:
        tags:
            - name: ibexa.payment.payment_method.options.form_mapper
              type: paypal
```

### Create options validator

You might want to make sure that data provided by the user is validated. To do that, create an options validator that checks user input against the constraints and dispatches an error when needed.

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsValidatorError;
use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsValidatorInterface;

final class UrlOptionValidator implements OptionsValidatorInterface
{
    public function validateOptions(OptionsBag $options): array
    {
        $errors = [];
        if (empty($options->get('base_url'))) {
            $errors[] = new OptionsValidatorError('base_url', 'Base URL cannot be blank');
        }

        // Add gateway implementation here

        return $errors;
    }
}
```

Then, register the validator as a service:

```yaml
services:
    App\Form\Type\OptionsValidator:
        tags:
            - name: ibexa.payment.payment_method.options.validator
              type: paypal
```

### Restart application

Shut down the application, clear browser cache, and restart the application. Then, try creating a payment of the new type.

![Payment method of custom type](https://doc.ibexa.co/en/5.0/commerce/payment/img/custom_payment_type.png "Payment method of custom type")

## Attach custom data to payments

When you create a payment, you can attach custom data to it, for example, you can pass an invoice number or a proprietary transaction identifier.

You add custom data by using the `setContext` method:

```php
$context = [
    'transaction_id' => '5e5fe187-c865-49£2-b407-a946fd7b5be0',
];

$paymentCreateStruct = new PaymentCreateStruct(
    $this->paymentMethodService->getPaymentMethodByIdentifier('bank_transfer_EUR'),
    $this->orderService->getOrder(135),
    new Money\Money(100, new Money\Currency('EUR'))
);
$paymentCreateStruct->setContext(new ArrayMap($context));

$payment = $this->paymentService->createPayment($paymentCreateStruct);
```

Then, you retrieve it with the `getContext` method:

```php
$paymentIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
$payment = $this->paymentService->getPaymentByIdentifier($paymentIdentifier);

$context = $payment->getContext();
```
