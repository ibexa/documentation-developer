# Implement payment method filtering

Implement payment method filtering.

Editions: Commerce

You can use payment method filtering to decide, whether selected payment method can be used and displayed in checkout process. To allow this filtering, you need to create a custom payment method type and register new voter.

## Create custom payment method type

You can extend your Payment module implementation in different ways. One of them is to [create a custom payment method type](../extend_payment/index.md).

The following example shows, how to create `New Payment Method Type`.

### Define custom payment method type

First, register the new payment method type as a service:

```yaml
services:
    app.payment.type.new_payment_method_type:
        class: Ibexa\Contracts\Payment\PaymentMethod\Type\TypeInterface
        factory: ['@Ibexa\Contracts\Payment\PaymentMethod\Type\TypeFactoryInterface', 'createType']
        arguments:
            $identifier: new_payment_method_type
            $name: New Payment Method Type
            $domain: <translation_domain>
        tags:
            - { name: ibexa.payment.payment_method.type, alias: new_payment_method_type }
```

In the `arguments` list provide a name of the payment method type, the way you want it to appear on the list of available payment method types, in the following example: `New Payment Method Type`.

Now new custom payment method type should be visible in **Commerce** -> **Payment methods**.

### Create voter for new payment method type

Next, create a `NewPaymentMethodTypeVoter.php` file with the voter definition for your new payment method type:

```php
<?php

declare(strict_types=1);

namespace App\Payment\PaymentMethod\Voter;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodInterface;
use Ibexa\Contracts\Payment\PaymentMethod\Voter\AbstractVoter;

final class NewPaymentMethodTypeVoter extends AbstractVoter
{
    protected function getVote(PaymentMethodInterface $method, CartInterface $cart): bool
    {
        // Add custom logic if method should not always be visible

        return true;
    }
}
```

Created voter decides, if selected payment method type can be used and displayed in checkout process.

#### Register new voter

Register new voter as a service:

```yaml
    App\Payment\PaymentMethod\Voter\NewPaymentMethodTypeVoter:
        tags:
            - { name: ibexa.payment.payment_method.voter, type: new_payment_method_type }
```

#### Clear cache

Now, clear the cache by running the following command:

```bash
php bin/console cache:clear
```

Then, you can create a payment of the new type.

![New payment method type](https://doc.ibexa.co/en/5.0/commerce/payment/img/new_payment_method_type.png "New payment method type")
