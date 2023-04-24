<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodInterface;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Type;
use Ibexa\Contracts\Payment\PaymentMethodServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;

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
        $this->paymentMethodService = $paymentMethodService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:paymentMethod');
    }

    protected function execute(InputInterface $input, OutputInterface $output):
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single payment method by ID
        $paymentMethodId = 1;
        $paymentMethod = $this->paymentMethodService->getPaymentMethod($paymentMethodId);

        $output->writeln(sprintf('Payment method %d has status "%s"', $id, $paymentMethod->getStatus()));

        // Get a single payment method by identifier
        $paymentMethodIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $paymentMethod = $this->paymentMethodService->getPaymentMethodByIdentifier($paymentMethodIdentifier);

        $output->writeln(sprintf('Availability status od payment method "%s" is "%s".', $paymentMethodIdentifier, $paymentMethod->getEnabled()));

        // Find payment methods
        $paymentMethodCriterions = [
            new Type('offline'),
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
            'transfer_eu',
            'offline',
            'EU free payment EUR',
            null,
            true,
            null
        );

        $paymentMethod = $this->paymentMethodService->createPaymentMethod($paymentMethodCreateStruct);

        $output->writeln(sprintf('Created payment method with name %s', $paymentMethod->getName()));

        // Update the payment method
        $paymentMethodUpdateStruct = new PaymentMethodUpdateStruct();
        $paymentMethodUpdateStruct->setEnabled(false);

        $this->paymentMethodService->updatePaymentMethod($paymentMethod, $paymentMethodUpdateStruct);

        $output->writeln(sprintf(
            'Updated payment method "%s" by changing its availability status to "%s".',
            $paymentMethod->getName(),
            $paymentMethod->getEnabled()
        ));

        // Delete the payment method
        $this->paymentMethodService->deletePaymentMethod($paymentMethod);
        $output->writeln(sprintf(
            'Deleted payment method with ID %d and identifier "%s".', 
            $paymentMethod->getId(), 
            $paymentMethod->getIdentifier()
        ));
    }
}
