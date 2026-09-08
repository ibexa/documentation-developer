# Payment method API

Use PHP API and REST API to manage payment methods in Commerce. You can create, modify and delete payment methods.

Editions: Commerce

> **Tip: Order management REST API**
>
> To learn how to manage payment methods with the REST API, see the [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Payments).

To get payment methods and manage them, use the `Ibexa\Contracts\Payment\PaymentMethodServiceInterface` interface.

From the developer's perspective, payment methods are referenced with identifiers defined manually at method creation stage in user interface.

> **Note: Support for multilingual applications**
>
> The `getPaymentMethodByIdentifier`, `getPaymentMethod` and `findPaymentMethods` methods take a second argument, `$prioritizedLanguages`, that can be an array of language codes or `null`. If there are language codes in an array, methods return payment method name translations in the specified languages. Translations come from the database.

## Get single payment method

### Get single payment method by identifier

To access a single payment method by using its string identifier, use the `PaymentMethodService::getPaymentMethodByIdentifier` method:

```php
$paymentMethodIdentifier = 'cash';
$paymentMethod = $this->paymentMethodService->getPaymentMethodByIdentifier($paymentMethodIdentifier);

$output->writeln(sprintf('Availability status of payment method "%s" is "%s".', $paymentMethodIdentifier, $paymentMethod->isEnabled()));
```

### Get single payment method by ID

To access a single payment method by using its numerical ID, use the `PaymentMethodService::getPaymentMethod` method:

```php
$paymentMethodId = 1;
$paymentMethod = $this->paymentMethodService->getPaymentMethod($paymentMethodId);

$output->writeln(sprintf('Payment method %d has type "%s"', $paymentMethodId, $paymentMethod->getType()->getIdentifier()));
```

## Get multiple payment methods

To fetch multiple payment methods, use the `PaymentMethodService::findPaymentMethods` method.

It follows the same search query pattern as other APIs:

```php
$offlinePaymentType = new PaymentMethodType('offline', 'Offline');
$paymentMethodCriterions = [
    new Type($offlinePaymentType),
    new Enabled(true),
];

$paymentMethodQuery = new PaymentMethodQuery((new LogicalAnd(...$paymentMethodCriterions)));
$paymentMethodQuery->setLimit(10);

$paymentMethods = $this->paymentMethodService->findPaymentMethods($paymentMethodQuery);

$paymentMethods->getPaymentMethods();
$paymentMethods->getTotalCount();

foreach ($paymentMethods as $paymentMethod) {
    $output->writeln($paymentMethod->getIdentifier() . ': ' . $paymentMethod->getName() . ' - ' . $paymentMethod->getDescription());
}
```

## Create payment method

To create a payment method, use the `PaymentMethodService::createPaymentMethod` method and provide it with an `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodCreateStruct` object that takes the following parameters:

- `identifier` string
- `type` TypeInterface object
- `names` array of string values
- `descriptions` array of string values
- `enabled` boolean value
- `options` object.

```php
        $offlinePaymentType = new PaymentMethodType('offline', 'Offline');
        $paymentMethodCreateStruct = new PaymentMethodCreateStruct(
            'bank_transfer_EUR',
            $offlinePaymentType,
        );
        $paymentMethodCreateStruct->setName('eng-GB', 'Bank transfer EUR');
        $paymentMethodCreateStruct->setEnabled(false);

        $paymentMethod = $this->paymentMethodService->createPaymentMethod($paymentMethodCreateStruct);

        $output->writeln(sprintf('Created payment method with name %s', $paymentMethod->getName()));
```

## Update payment method

You can update the payment method after it's created. An `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodUpdateStruct` object can take the following arguments: `identifier` string, `names` array of string values, `descriptions` array of string values, `enabled` boolean value, and an `options` object.

To update payment method information, use the `PaymentMethodServiceInterface::updatePaymentMethod` method:

```php
$paymentMethodUpdateStruct = new PaymentMethodUpdateStruct();
$paymentMethodUpdateStruct->setEnabled(true);

$this->paymentMethodService->updatePaymentMethod($paymentMethod, $paymentMethodUpdateStruct);

$output->writeln(sprintf(
    'Updated payment method "%s" by changing its availability status to "%s".',
    $paymentMethod->getName(),
    $paymentMethod->isEnabled()
));
```

## Delete payment method

To delete a payment method from the system, use the `PaymentMethodService::deletePayment` method:

```php
$this->paymentMethodService->deletePaymentMethod($paymentMethod);
$output->writeln(sprintf(
    'Deleted payment method with ID %d and identifier "%s".',
    $paymentMethod->getId(),
    $paymentMethod->getIdentifier()
));
```

## Check whether payment method is used

To check whether a payment method is used, for example, before you delete it, use the `PaymentMethodService::isPaymentMethodUsed` method:

```php
$isUsed = $this->paymentMethodService->isPaymentMethodUsed($paymentMethod);

if ($isUsed) {
    $output->writeln(sprintf(
        'Payment method with ID %d is currently used.',
        $paymentMethod->getId()
    ));
} else {
    $output->writeln(sprintf(
        'Payment method with ID %d is not used.',
        $paymentMethod->getId()
    ));
}
```
