# Payment troubleshooting [[% include 'snippets/commerce_badge.md' %]]

## Extending the order size limit

Due to a restriction in JmsPaymentBundle, an order exceeding 99999.99999 causes an error message.

It is possible to extend this limit using an [official workaround for the JMSPaymentCoreBundle.](http://jmspaymentcorebundle.readthedocs.io/en/latest/guides/overriding_entity_mapping.html)

You need to override the service class `Siso\Bundle\PaymentBundle\Api\StandardPaymentService` and modify the `EXCEEDED_ENTITY_AMOUNT_VALUE` constant.
This constant is read by late static binding and will use the overridden value.

For example:

``` php
<?php

namespace App\Service;

use Siso\Bundle\PaymentBundle\Api\StandardPaymentService;

/**
 * Service class override
 * <parameters>
 *     <parameter key="siso_payment.payment_service.class">App\Service\ExamplePaymentService</parameter>
 * </parameters>
 */
class ExamplePaymentService extends StandardPaymentService
{
    const EXCEEDED_ENTITY_AMOUNT_VALUE = 999999999.99;
}
```

## Timeout in redirection to the paygate

At the transaction data encryption stage, the PHP process can run into an execution timeout.
This can happen when the user clicks the **Buy now** button on the order summary page.
The exception in the AJAX Response can look like this:

```
Exception message:

Error: Maximum execution time of 60 seconds exceeded

Occured in file /var/www/project/vendor/jms/payment-core-bundle/JMS/Payment/CoreBundle/Cryptography/MCryptEncryptionService.php line 91
```

The problem is with the usage of the PHP function [`mcrypt_create_iv`](http://php.net/manual/en/function.mcrypt-create-iv.php) in that line.
The default implementation uses the `/dev/urandom` device to determine a random number.
This can take a long time if the hosting system doesn't generate random events fast enough.
Then the call runs into a timeout.

To solve this, check the currently available entropy on the system:

``` bash
cat /proc/sys/kernel/random/entropy_avail
```

The result should be a number greater than 300. If it is less, the entropy is not enough to generate random numbers.

To increase the entropy, you have to install the `haveged` application.

Install the package with apt-get:

``` 
sudo apt-get install haveged
```

This tool starts automatically at boot and keeps entropy greater than 1000.
