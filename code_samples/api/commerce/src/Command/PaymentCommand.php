<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\Payment\Payment\PaymentCreateStruct;
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\LogicalOr;
use Ibexa\Contracts\Payment\PaymentMethodServiceInterface;
use Ibexa\Contracts\Payment\PaymentServiceInterface;
use Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:payment'
)]
final class PaymentCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private PaymentServiceInterface $paymentService;

    private OrderServiceInterface $orderService;

    private PaymentMethodServiceInterface $paymentMethodService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        PaymentServiceInterface $paymentService,
        OrderServiceInterface $orderService,
        PaymentMethodServiceInterface $paymentMethodService,
    ) {
        $this->paymentService = $paymentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->paymentMethodService = $paymentMethodService;

        parent::__construct();
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single payment
        $paymentId = 1;
        $payment = $this->paymentService->getPayment($paymentId);

        $output->writeln(sprintf('Payment %d has status %s', $paymentId, $payment->getStatus()));

        // Get a single payment by identifier
        $paymentIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $payment = $this->paymentService->getPaymentByIdentifier($paymentIdentifier);

        $context = $payment->getContext();
        // Will be overridden later but used to illustrate `getContext()`

        $output->writeln(sprintf('Your payment for transaction has status %s', $payment->getStatus()));

        // Query for payments
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

        // Create a new payment
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

        // Update existing payment
        $paymentUpdateStruct = new PaymentUpdateStruct();
        $paymentUpdateStruct->setTransition('pay');

        $this->paymentService->updatePayment($payment, $paymentUpdateStruct);

        $output->writeln(sprintf('Changed payment status to %s', $payment->getStatus()));

        // Delete existing payment permanently
        $this->paymentService->deletePayment($payment);

        return self::SUCCESS;
    }
}
