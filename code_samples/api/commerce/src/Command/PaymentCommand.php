<?php

declare(strict_types=1);
 
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderInterface;
use Ibexa\Contracts\Payment\PaymentServiceInterface;
use Ibexa\Contracts\Payment\Payment\PaymentCreateStruct;
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\LogicalOr;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;

final class PaymentCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private PaymentServiceInterface $paymentService;

    public function __construct(
      PermissionResolver $permissionResolver,
      UserService $userService,
      PaymentServiceInterface $paymentService
      ) {
        $this->paymentService = $paymentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:payment');
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): 
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

        $output->writeln(sprintf('Your payment has status %s', $payment->getStatus()));

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
            $output->writeln($payment->getIdentifier() . ': ' . $payment->getOrder().getIdentifier() . ': ' . getAmount());
        }

        // Create a new payment
        $paymentCreateStruct = new PaymentCreateStruct(
            'Bank transfer EU',
            '2304/137'
            EUR('100')
        );

        $payment = $this->paymentService->createPayment($paymentCreateStruct);

        $output->writeln(sprintf('Created payment $s for order %s', $payment->getIdentifier(), '2304/137'));

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
