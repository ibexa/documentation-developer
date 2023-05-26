---
description: Extend Payment with custom payment method type.
edition: commerce
---

# Extend Payment

There are different ways you can extend your Payment module implementation. 
One of them is to create a custom payment method type. 
The other is attaching custom data to a payment.

You can also customize the payment processing workflow.

Based on such type store managers can define numerous payment methods.

!!! note "Gateway integration requirement"

    [[= product_name =]] does not come with gateway redirects. Whether you are an integrator or the end customer, it is your responsibility to implement payment gateway integration.

## Create custom payment method type

Create a PHP definition of the payment method type.

``` php
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

Make sure that `getName` returns a human readable name of the payment method type, the way you want it to appear on the list of available payment method types.

Now, register the definition as a service:

``` yaml
 services:
    App\Payment\PayPal: 
        tags: 
            name: ibexa.payment.payment_method.type 
            alias: paypal
```

Alternatively, you can achieve the same effect by using the Type Factory.
To do it, define the payment method type in your YAML configuration file:

``` yaml
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

## Options form

Use the Form Builder to define a form type that contains all the options that you need for your payment method type:

``` php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayPalOptionsType extends AbstractType 
{ 
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    { 
        builder->add( 
            'base_url', 
            UrlType::class, 
            [ 
                'constraints' => [ 
                    new NotBlank(),
                ]
            ]
        );
        
        # ...
    }
}
```

Next, create the `OptionsFormMapper.php` file that maps the information that the user inputs in the form into attribute definition.

``` php
<?php

declare(strict_types=1);

namespace App\Attribute\PayPal;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsFormMapper implements OptionsFormMapperInterface 
{ 
    public function createOptionsForm
    ( 
        string $name, 
        FormBuilderInterface $builder, 
        array $context = [] 
    ) : void { 
        $builder->add($name, PayPalOptionsType::class); 
    }
}
```

... and register the `OptionsFormMapper` interface as a service:

``` yaml
services:
    App\Payment\PayPal\OptionsFormMapper:
        tags:
            -   name: ibexa.payment.payment_method.options.form_mapper
                type: paypal
```

## Options validator

Finally, make sure the data provided by the user is validated. To do that, create `OptionsValidator` that checks user input against the constraints and dispatches an error when needed.

``` php
<?php

declare(strict_types=1);

namespace App\Attribute\PayPal;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsValidator implements OptionsValidatorInterface 
{ 
    public function validateOptions(OptionsBag $options): array 
    { 
        $errors = []; 
        if (empty ($options->get('base_url'))) { 
            $errors[] = new OptionsValidatorError ('base_url', 'Base Url should not be blank');
        }
        
     # ...

    return $errors; 
    }
}
```

Register the validator as a service and tag it with `ibexa.payment.payment_method.options.form_mapper`:

``` yaml
services:
    App\Payment\PayPal\OptionsValidator:
        tags:
            -   name: ibexa.payment.payment_method.options.validator
                type: paypal
```

## Attach custom data to payments

When you create a payment, you can attach custom data to it, for example, you can pass an invoice number or a proprietary transaction identifier.
You do it by using the `setContext` and `getContext` methods:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 89, 104) =]]
```

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 89, 104) =]]
```
