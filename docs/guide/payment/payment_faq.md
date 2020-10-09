# Payment FAQ

## How can I activate payment options in checkout process?

Individual payment options / payment methods are implemented in Symfony bundles.
As soon as they are registered in the kernel, they are displayed in the checkout payment form. The respective options are registered in the checkout form by a DIC compiler pass and must fulfill some requirements:

- The bundle must define a form type service
- The form type must define the `payment.method_form_type` tag
- The form type must define the `form.type` tag with an alias attribute that is used as text in the payment choice.

For example:

``` xml
<service id="payment.form.telecash_connect_type"
         class="%payment.form.telecash_connect_type.class%">
    <tag name="payment.method_form_type" />
    <tag name="form.type" alias="telecash_connect" />
</service>
```

The compiler pass is defined in the checkout bundle: `\Siso\Bundle\CheckoutBundle\DependencyInjection\Compiler\PaymentMethodsPass`

## How can I customize the payment options?

To customize payment options displayed in the payment options box
(e.g. to hide some if products are not available), change the payment form.

To change the shipping/payment form, replace or rewrite the form type service.
The form type for the options choice is implemented in the checkout bundle in `\Siso\Bundle\CheckoutBundle\Form\Type\CheckoutShippingPaymentType`.

The methods `CheckoutShippingPaymentType::buildForm()` and `CheckoutShippingPaymentType::setDefaultOptions()` are called to assemble the HTML form.

See [Configuration for the Checkout Forms](../checkout/checkout_api/forms/configuration_for_checkout_forms.md)
and [Symfony's form documention](http://symfony.com/doc/3.4/book/forms.html) for more information.

## Can I extend the order size limit?

Due to a restriction in JmsPaymentBundle, an order exceding 99999.99999 causes an error message.

It is possible to extend this limit using an [official workaround for the JMSPaymentCoreBundle.](http://jmspaymentcorebundle.readthedocs.io/en/latest/guides/overriding_entity_mapping.html)

You need to override the service class `Siso\Bundle\PaymentBundle\Api\StandardPaymentService` and adapt the constant `EXCEEDED_ENTITY_AMOUNT_VALUE`.
This constant is read by late static binding and will use the overridden value.

For example:

``` php
<?php

namespace Project\Bundle\ProjectBundle\Service;

use Siso\Bundle\PaymentBundle\Api\StandardPaymentService;

/**
 * Service class overide
 * <parameters>
 *     <parameter key="siso_payment.payment_service.class">Project\Bundle\ProjectBundle\Service\ExamplePaymentService</parameter>
 * </parameters>
 */
class ExamplePaymentService extends StandardPaymentService
{
    const EXCEEDED_ENTITY_AMOUNT_VALUE = 999999999.99;
}
```

## The redirection from the shop to the paygate fails because of an execution timeout

During the encryption of the transaction data the PHP process can run into an execution timeout.
This can occur after clicking the **Buy now** button at the order summary page.
The exception in the AJAX Response can look like this:

```
Exception message:

Error: Maximum execution time of 60 seconds exceeded

Occured in file /var/www/project/vendor/jms/payment-core-bundle/JMS/Payment/CoreBundle/Cryptography/MCryptEncryptionService.php line 89
```

The problem is the usage of the PHP function [`mcrypt_create_iv`](http://php.net/manual/en/function.mcrypt-create-iv.php) in that line.
The default implementation uses the `/dev/urandom` device to determine a random number.
This can take a long time if the hosting system doesn't generate enough random events per time.
Then the call runs into a timeout.

To solve this, check the currently available entropy on the system:

``` bash
cat /proc/sys/kernel/random/entropy_avail
```

The result should be a number greater than 300. If it is less, the entropy is not enough to generate random numbers.

To increase the entropy you have to install the `haveged` application.

Install the package with apt-get:

``` 
sudo apt-get install haveged
```

This tool starts automatically at boot and keeps entropy greater than 1000.
