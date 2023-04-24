<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodInterface;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodQuery;
use Ibexa\Contracts\Checkout\ShippingMethodServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;

final class ShippingMethodCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ShippingMethodServiceInterface $shippingMethodService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        ShippingMethodServiceInterface $shippingMethodService
    ) {
        $this->shippingMethodService = $shippingMethodService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:shippingMethod');
    }

    protected function execute(InputInterface $input, OutputInterface $output):
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single shipping method by ID
        $shippingMethodId = 1;
        $shippingMethod = $this->shippingMethodService->getShippingMethod($shippingMethodId);

        $output->writeln(sprintf('Shipping method %d has status "%s"', $shippingMethodId, $shippingMethod->getStatus()));

        // Get a single shipping method by identifier
        $shippingMethodIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $shippingMethod = $this->shippingMethodService->getShippingMethodByIdentifier($shippingMethodIdentifier);

        $output->writeln(sprintf('Got shipping method by identifier "%s" and type "%s".', $shippingMethodIdentifier, $shippingMethod->getType()));

        // Find shipping methods
        $shippingMethodCriterions = [
            new ShippingMethodRegion('EU'),
            new CreatedAt('2023-03-24 15:09:16'),
            new UpdatedAt('2023-03-25 09:00:15'),
        ];

        $shippingMethodQuery = new ShippingMethodQuery((new LogicalAnd(...$shippingMethodCriterions)));
        $shippingMethodQuery->setLimit(10);

        $shippingMethods = $this->shippingMethodService->findShippingMethods($shippingMethodQuery);

        $shippingMethods->getShippingMethods();
        $shippingMethods->getTotalCount();

        foreach ($shippingMethods as $shippingMethod) {
            $output->writeln($shippingMethod->getIdentifier() . ': ' . $shippingMethod->getName() . '- ' . $shippingMethod->getDescription());
        }

        // Create a new shipping method
        $shippingMethodCreateStruct = $this->shippingMethodService->newShippingMethodCreateStruct(
            'eu_free_eur',
            'free',
            'EU free shipping EUR',
            null,
            ['currency' => 'EUR', 'price' => 100],
            true,
            `EU`,
            null
        );

        $shippingMethod = $this->shippingMethodService->createShippingMethod($shippingMethodCreateStruct);

        $output->writeln(sprintf('Created shipping method with name %s', $shippingMethod->getName()));

        // Update the shipping method
        $shippingMethodUpdateStruct = $this->shippingMethodService->newShippingMethodUpdateStruct();
        $shippingMethodUpdateStruct->setEnabled(false);

        $this->shippingMethodService->updateShippingMethod($shippingMethod, $shippingMethodUpdateStruct);

        $output->writeln(sprintf(
            'Updated shipping method "%s" by changing its "Enabled" status to "%s".',
            $shippingMethod->getName(),
            $shippingMethod->getEnabled()
        ));

        // Delete the shipping method
        $this->shippingMethodService->deleteShippingMethod($shippingMethod);
        $output->writeln(sprintf(
            'Deleted shipping method with ID %d and identifier "%s".', 
            $shippingMethod->getId(), 
            $shippingMethod->getIdentifier()
        ));

        // Delete shipping method translation
        $languageCode = 'en';
        $this->shippingMethodService->deleteShippingMethodTranslation($shippingMethod, $languageCode);

        $output->writeln(sprintf(
            'Deleted translation for shipping method "%s" and language "%s".',
            $shippingMethod->getName(),
            $languageCode
        ));

        return self::SUCCESS;
    }
}

