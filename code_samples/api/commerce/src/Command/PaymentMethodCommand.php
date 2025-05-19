<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodCreateStruct;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodUpdateStruct;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Type;
use Ibexa\Contracts\Payment\PaymentMethodServiceInterface;
use Ibexa\Payment\Values\PaymentMethodType;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:paymentMethod'
)]
final class PaymentMethodCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private PaymentMethodServiceInterface $paymentMethodService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        PaymentMethodServiceInterface $paymentMethodService
    ) {
        parent::__construct();
        $this->paymentMethodService = $paymentMethodService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single payment method by ID
        $paymentMethodId = 1;
        $paymentMethod = $this->paymentMethodService->getPaymentMethod($paymentMethodId);

        $output->writeln(sprintf('Payment method %d has type "%s"', $paymentMethodId, $paymentMethod->getType()->getIdentifier()));

        // Get a single payment method by identifier
        $paymentMethodIdentifier = 'cash';
        $paymentMethod = $this->paymentMethodService->getPaymentMethodByIdentifier($paymentMethodIdentifier);

        $output->writeln(sprintf('Availability status of payment method "%s" is "%s".', $paymentMethodIdentifier, $paymentMethod->isEnabled()));

        // Find payment methods
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

        // Create a new payment method
        $paymentMethodCreateStruct = new PaymentMethodCreateStruct(
            'bank_transfer_EUR',
            $offlinePaymentType,
        );
        $paymentMethodCreateStruct->setName('eng-GB', 'Bank transfer EUR');
        $paymentMethodCreateStruct->setEnabled(false);

        $paymentMethod = $this->paymentMethodService->createPaymentMethod($paymentMethodCreateStruct);

        $output->writeln(sprintf('Created payment method with name %s', $paymentMethod->getName()));

        // Update the payment method
        $paymentMethodUpdateStruct = new PaymentMethodUpdateStruct();
        $paymentMethodUpdateStruct->setEnabled(true);

        $this->paymentMethodService->updatePaymentMethod($paymentMethod, $paymentMethodUpdateStruct);

        $output->writeln(sprintf(
            'Updated payment method "%s" by changing its availability status to "%s".',
            $paymentMethod->getName(),
            $paymentMethod->isEnabled()
        ));

        // Delete the payment method
        $this->paymentMethodService->deletePaymentMethod($paymentMethod);
        $output->writeln(sprintf(
            'Deleted payment method with ID %d and identifier "%s".',
            $paymentMethod->getId(),
            $paymentMethod->getIdentifier()
        ));

        // Check whether the payment method is used
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

        return self::SUCCESS;
    }
}
