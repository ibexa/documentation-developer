# Payment API

Use PHP API to manage payments in Commerce. You can create, update and delete payments.

Editions: Commerce

To get payments and manage them, use the `Ibexa\Contracts\Payment\PaymentServiceInterface` interface.

By default, UUID is used to generate payment identifiers. You can change that by providing a custom payment identifier in `Ibexa\Contracts\Payment\Payment\PaymentCreateStruct` or `Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct`.

## Get single payment

### Get single payment by ID

To access a single payment by using its numerical ID, use the `PaymentServiceInterface::getPayment` method:

```php
$paymentId = 1;
$payment = $this->paymentService->getPayment($paymentId);

$output->writeln(sprintf('Payment %d has status %s', $paymentId, $payment->getStatus()));
```

### Get single payment by identifier

To access a single payment by using its string identifier, use the `PaymentServiceInterface::getPaymentByIdentifier` method:

```php
$paymentIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
$payment = $this->paymentService->getPaymentByIdentifier($paymentIdentifier);
```

## Get multiple payments

To fetch multiple payments, use the `PaymentServiceInterface::findPayments` method. It follows the same search query pattern as other APIs:

```php
$paymentCriterions = [
    new Currency('USD'),
    new Currency('CZK'),
];

$paymentQuery = new PaymentQuery(new LogicalOr(...$paymentCriterions));
$paymentQuery->setLimit(10);

$paymentsList = $this->paymentService->findPayments($paymentQuery);

$paymentsList->getPayments();
$paymentsList->getTotalCount();

foreach ($paymentsList as $payment) {
    $output->writeln($payment->getIdentifier() . ': ' . $payment->getOrder()->getIdentifier() . ': ' . $payment->getOrder()->getValue()->getTotalGross()->getAmount());
}
```

## Create payment

To create a payment, use the `PaymentServiceInterface::createPayment` method and provide it with the `Ibexa\Contracts\Payment\Payment\PaymentCreateStruct` object that takes the following arguments: `method`, `order` and `amount`.

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

$output->writeln(sprintf('Created payment %s for order %s', $payment->getIdentifier(), $payment->getOrder()->getIdentifier()));
```

## Update payment

You can update payment information after the payment is created. You could do it to support a scenario when, for example, an online payment failed, has been processed by using other means, and its status has to be updated in the system. The `Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct` object takes the following arguments: `transition`, `identifier`, and `context`. To update payment information, use the `PaymentServiceInterface::updatePayment` method:

```php
$paymentUpdateStruct = new PaymentUpdateStruct();
$paymentUpdateStruct->setTransition('pay');

$this->paymentService->updatePayment($payment, $paymentUpdateStruct);

$output->writeln(sprintf('Changed payment status to %s', $payment->getStatus()));
```

## Delete payment

To delete a payment from the system, use the `PaymentServiceInterface::deletePayment` method:

```php
$this->paymentService->deletePayment($payment);
```
