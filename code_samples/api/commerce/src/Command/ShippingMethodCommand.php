<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Checkout\ShippingMethodServiceInterface;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\Query\Criterion\ShippingMethodRegion;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodDeleteTranslationStruct;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodQuery;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\RegionServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShippingMethodCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ShippingMethodServiceInterface $shippingMethodService;

    private RegionServiceInterface $regionService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        ShippingMethodServiceInterface $shippingMethodService,
        RegionServiceInterface $regionService
    ) {
        $this->shippingMethodService = $shippingMethodService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->regionService = $regionService;

        parent::__construct('doc:shippingMethod');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single shipping method by ID
        $shippingMethodId = 1;
        $shippingMethod = $this->shippingMethodService->getShippingMethodById($shippingMethodId);

        $output->writeln(
            sprintf(
                'Availability status of shipping method %d is "%s"', 
                $shippingMethodId, $shippingMethod->isEnabled()
            )
        );

        // Get a single shipping method by identifier
        $shippingMethodIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $shippingMethod = $this->shippingMethodService->getShippingMethod($shippingMethodIdentifier);

        $output->writeln(
            sprintf(
                'Got shipping method by identifier "%s" and type "%s".', 
                $shippingMethodIdentifier, 
                $shippingMethod->getType()->getIdentifier()
            )
        );

        // Find shipping methods
        $shippingMethodQuery = new ShippingMethodQuery(new ShippingMethodRegion($this->regionService->getRegion('EU')));
        $shippingMethodQuery->setLimit(10);

        $shippingMethods = $this->shippingMethodService->findShippingMethods($shippingMethodQuery);

        $shippingMethods->getShippingMethods();
        $shippingMethods->getTotalCount();

        foreach ($shippingMethods as $shippingMethod) {
            $output->writeln(
                sprintf(
                    '%s: %s- %s',
                    $shippingMethod->getIdentifier(),
                    $shippingMethod->getName(),
                    $shippingMethod->getDescription()
                )
            );
        }

        // Create a new shipping method
        $shippingMethodCreateStruct = $this->shippingMethodService->newShippingMethodCreateStruct(
            'eu_free_eur',
        );

        $shippingMethodCreateStruct->setEnabled(true);
        $shippingMethodCreateStruct->setName('eng-GB', 'EU free shipping EUR');

        $shippingMethod = $this->shippingMethodService->createShippingMethod($shippingMethodCreateStruct);

        $output->writeln(
            sprintf(
                'Created shipping method with name %s', 
                $shippingMethod->getName()
            )
        );

        // Update the shipping method
        $shippingMethodUpdateStruct = $this->shippingMethodService->newShippingMethodUpdateStruct();
        $shippingMethodUpdateStruct->setEnabled(false);

        $this->shippingMethodService->updateShippingMethod($shippingMethod, $shippingMethodUpdateStruct);

        $output->writeln(sprintf(
            'Updated shipping method "%s" by changing its "Enabled" status to "%s".',
            $shippingMethod->getName(),
            $shippingMethod->isEnabled()
        ));

        // Delete the shipping method
        $this->shippingMethodService->deleteShippingMethod($shippingMethod);
        $output->writeln(sprintf(
            'Deleted shipping method with ID %d and identifier "%s".',
            $shippingMethod->getId(),
            $shippingMethod->getIdentifier()
        ));

        // Delete shipping method translation
        $languageCode = 'eng-GB';
        $shippingMethodDeleteTranslationStruct = new ShippingMethodDeleteTranslationStruct($shippingMethod, $languageCode);
        $this->shippingMethodService->deleteShippingMethodTranslation($shippingMethodDeleteTranslationStruct);

        $output->writeln(sprintf(
            'Deleted translation for shipping method "%s" and language "%s".',
            $shippingMethod->getName(),
            $languageCode
        ));

        return self::SUCCESS;
    }
}
