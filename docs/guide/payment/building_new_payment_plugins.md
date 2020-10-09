# Building new payment plugins

You can create a custom payment plugin based on `JMSPaymentCoreBundle`.
The steps overlap with the requirements for [new payment plugins for JMS payment.](http://jmsyst.com/bundles/JMSPaymentCoreBundle/master/plugins)

## Create new plugin class

Create a new plugin class which extends `JMS\Payment\CoreBundle\Plugin\AbstractPlugin`.

### Create a payment method identifier

Implement the abstract method `processes($paymentSystemName)`.
`$paymentSystemName` is the identifier for the payment methods this plugin will support.
The identifier is used for example in the payment form in the checkout process.

``` php
<?php

namespace Bundle\PaymentTestBundle\Plugin;

use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;

/**
 * JMS Plugin class for the payment
 */
class TeleCashConnectPlugin extends AbstractPlugin
{
    /**
     * Implementation which determines, that this plugin will be able to handle
     * the 'telecash_connect' payment system.
     *
     * @param string $paymentSystemName
     * @return boolean
     */
    public function processes($paymentSystemName)
    {
        return $paymentSystemName === 'telecash_connect';
    }
}
```

!!! note "Important"

    The payment method identifier must comply with the tag attribute alias in the form type definition and the tag attribute `paymentMethod` in the [extended data configuration definition](#register-services).

### Override the supported transaction methods

`JMS\Payment\CoreBundle\Plugin\PluginInterface` defines several methods for specific transactions.
`\JMS\Payment\CoreBundle\Plugin\AbstractPlugin` implements the `PluginInterface`, but only throws `FunctionNotSupportedException`.
Deriving classes must override specific methods and implement the transaction logic.
You need to implement at least one of the following methods:

- For the payment operation AUTHORIZE implement the `approve()` method.
- In this example, you implement the `approveAndDeposit()` method. This method is used for the SALE payment operation.

#### `approveAndDeposit()`

In this example, a financial transaction is expected to have one of two states:

- `STATE_NEW`
- `STATE_PENDING`

Any other state is ignored and causes a rollback. Any exception other than `ActionRequiredException` causes a rollback

In case of rollback the `JMSPluginController` sets the state to `STATE_FAILED` and rolls back the transaction as the controller expects:

- either the response code of the transaction is set to `RESPONSE_CODE_SUCCESS`
- or the method throws `ActionRequiredException`.

``` php
/**
 * @param FinancialTransactionInterface $transaction
 * @param bool $retry
 * @throws ActionRequiredException
 * @throws \Exception
 */
public function approveAndDeposit(FinancialTransactionInterface $transaction, $retry)
{
    // Get transaction data
    $extendedData = $transaction->getExtendedData();
    // Check the status of the transaction
    switch ($transaction->getState()) {
        case FinancialTransactionInterface::STATE_NEW;
            // Check $data, if redirect is necessary
            // collect data for necessary redirect action
            // prepare ActionRequiredException with data and throw it
            $instruction = $transaction->getPayment()->getPaymentInstruction();
            $amount = $transaction->getRequestedAmount();
            $currency = $this->parameters['currency_mapping'][$instruction->getCurrency()][1];
            $extendedData->set('transaction_type', self::TRX_TYPE_APPROVE_AND_DEPOSIT);
            $formData = $this->buildFormData($amount, $currency, $extendedData);
            $extendedData->set('form_data', $formData);
            $transaction->setResponseCode(PluginInterface::REASON_CODE_ACTION_REQUIRED);
            $exception = new ActionRequiredException();
            $exception->setAction(new VisitUrl('/telecash/forward'));
            throw $exception;
            break;
        case FinancialTransactionInterface::STATE_PENDING;
            // Verify notify data and finalize payment if the data is valid
            $notifyData = $extendedData->get('notify_data');
            $notifyValidationHash = $this->createNotifyHash(
                $notifyData['chargetotal'],
                $notifyData['currency'],
                $extendedData->get('storename'),
                $extendedData->get('secret'),
                $notifyData['txndatetime'],
                $notifyData['approval_code']
            );
            if ($notifyValidationHash !== $notifyData['notification_hash']) {
                throw new \Exception('Notify hash not valid! This HTTP request is probably a fraud.');
            }
            // if approval_code starts with an Y, the transaction is finalized,
            // else the notify wasn't final.
            if (substr($notifyData['approval_code'], 0, 1) === self::TRX_REPONSE_CODE_OK) {
                $processedAmount = $notifyData['chargetotal'];
                $transactionId = $notifyData['oid'];
                $transaction->setProcessedAmount($processedAmount);
                $transaction->setReferenceNumber($transactionId);
                $transaction->setResponseCode(PluginInterface::RESPONSE_CODE_SUCCESS);
            }
            break;
    }
}
```

## Create new form type class

To display the new implemented payment plugin as an option in the checkout process,
you have to create a form type class and define it as a service in the configuration.

``` php
<?php

namespace Bundle\PaymentTestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TeleCashConnectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getBlockPrefix()
    {
        return 'telecash_connect';
    }
}
```

## Create new configuration class

In the configuration class you can define extended data specific for the payment plugin.

Most payment provider implementations need more than data that is defined by `JMSPaymentCoreBundle`.

The extended data can be prepared and provided by implementing the `\Siso\Bundle\PaymentBundle\Api\PluginConfigurationInterface` interface.

In this example you implement two methods:

- `createExtendedDataForOrder()` provides the return URLs which are sent to the payment gateway during the redirect request and some other necessary values for the plugin implementation.
- `determinePaymentOperation()` returns the constant `PO_SALE`. This causes `StandardPaymentService` to use [`approveAndDeposit()`](#override-supported-transaction-methods) in order to try to finalize the payment.
This method can be used to invoke different payment operations depending on, for example, configuration.

`PluginConfigurationInterface` is designed to be injected as a service.
This means you can inject any needed dependency to this class via the service container, as well.
In this case it is the Symfony router and parameter values.

``` php
namespace Bundle\PaymentTestBundle\Plugin;

use Siso\Bundle\PaymentBundle\Api\PluginConfigurationInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Configuration class for the Telecash payment plugin.
 */
class Configuration implements PluginConfigurationInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param RouterInterface $router
     * @param array $parameters
     */
    public function __construct(RouterInterface $router, array $parameters = array())
    {
        $this->router = $router;
        $this->parameters = $parameters + array(
            'timezone' => '',
            'storename' => '',
            'secret' => '',
            'mode' => '',
        );
    }

    /**
     * @param string $orderReference
     * @return array
     */
    public function createExtendedDataForOrder($orderReference)
    {
        return array(
            'success_url' => $this->router->generate(
                'siso_telecash_success',
                array(
                    'orderReference' => $orderReference,
                ),
                RouterInterface::ABSOLUTE_URL
            ),
            'error_url' => $this->router->generate(
                'siso_telecash_error',
                array(
                    'orderReference' => $orderReference,
                ),
                RouterInterface::ABSOLUTE_URL
            ),
            'notify_url' => $this->router->generate(
                'siso_telecash_notify',
                array(
                    'orderReference' => $orderReference,
                ),
                RouterInterface::ABSOLUTE_URL
            ),
            'timezone' => $this->parameters['timezone'],
            'storename' => $this->parameters['storename'],
            'secret' => $this->parameters['secret'],
            'mode' => $this->parameters['mode'],
        );
    }

    /**
     * Returns PluginConfigurationInterface::PO_SALE as no other payment
     * operation is currently supported.
     *
     * @return string
     */
    public function determinePaymentOperation()
    {
        // Only sale (approveAndDeposit) is currently supported by this plugin.
        return PluginConfigurationInterface::PO_SALE;
    }
} 
```

## Register services

To get the new `PaymentPlugin` recognized by `JMSPaymentBundle`, the new classes must be registered as services with specific tags.

``` xml
<parameters>
    <parameter key="payment.form.telecash_connect_type.class">Bundle\PaymentTestBundle\Form\Type\TelecashConnectType</parameter>
    <parameter key="payment.plugin.telecash_connect.class">Bundle\PaymentTestBundle\Plugin\TelecashConnectPlugin</parameter>
    <parameter key="payment.plugin.telecash_connect.config.class">Bundle\PaymentTestBundle\Plugin\Configuration</parameter>
</parameters>

<services>
    <service id="payment.plugin.telecash_connect.config"
             class="%payment.plugin.telecash_connect.config.class%">
        <argument type="service" id="router" />
        <argument type="collection">
            <argument key="mode" type="string">%siso_telecash_payment.parameter.mode%</argument>
            <argument key="storename" type="string">%siso_telecash_payment.parameter.storename%</argument>
            <argument key="secret" type="string">%siso_telecash_payment.parameter.secret%</argument>
            <argument key="timezone" type="string">%siso_telecash_payment.parameter.timezone%</argument>
        </argument>
        <tag name="payment.plugin.config" paymentMethod="telecash_connect" />
    </service>

    <service id="payment.plugin.telecash_connect"
             class="%payment.plugin.telecash_connect.class%">
        <call method="setParameters">
            <argument type="collection">
                <argument key="currency_mapping">%siso_payment.currency_mapping%</argument>
                <argument key="test_code">%siso_payment.telecash.test_code.success%</argument>
                <argument key="application_mode">%siso_telecash_payment.application_mode%</argument>
            </argument>
        </call>
        <tag name="payment.plugin" />
    </service>

    <service id="payment.form.telecash_connect_type"
             class="%payment.form.telecash_connect_type.class%">
        <tag name="payment.method_form_type" />
        <tag name="form.type" alias="telecash_connect" />
    </service>
</services>
```

### Services and tags

#### Payment plugin

`Bundle\PaymentTestBundle\Plugin\TelecashConnectPlugin`

Every payment plugin service is injected into `JMSPluginManager` by the `payment.plugin` tag.

#### Form values

`Bundle\PaymentTestBundle\Form\Type\TelecashConnectType`

[A compiler pass](payment_faq.md) searches for the tag `form.type` and uses the alias.
The compiler pass itself is defined in `SisoCheckoutBundle`, as the form is part of the checkout process.

The alias is used:

- as the [payment method identifier](#create-new-plugin-class)
- in the front-end - as the option (value) in the payment form in the checkout process

#### Extended data configuration

`Bundle\PaymentTestBundle\Plugin\Configuration`

The configuration service is defined by the tag `payment.plugin.config`, which must provide the attribute `paymentMethod` with the value according to the respective [payment method identifer](#create-new-plugin-class).
