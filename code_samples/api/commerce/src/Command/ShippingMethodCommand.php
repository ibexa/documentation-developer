<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodCreateStruct;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodDeleteTranslationStruct;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodInterface;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodListInterface;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodQuery;
use Ibexa\Contracts\Checkout\Value\ShippingMethod\ShippingMethodUpdateStruct;
use Ibexa\Contracts\Checkout\ShippingMethodServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShippingMethodCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ShippingMethodServiceInterface $shippingMethodService;

    public function __construct(ShippingMethodServiceInterface $shippingMethodService)
    {
        $this->shippingMethodService = $shippingMethodService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:shipping_method');
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): 
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Create a new shipping method
        $createStruct = $this->shippingMethodService->newShippingMethodCreateStruct('Standard');
        $shippingMethod = $this->shippingMethodService->createShippingMethod($createStruct);
        $output->writeln(sprintf('Created new shipping method with ID %d and identifier "%s".', $shippingMethod->getId(), $shippingMethod->getIdentifier()));

        // Get a shipping method by ID
        $shippingMethod = $this->shippingMethodService->getShippingMethodById($shippingMethod->getId());
        $output->writeln(sprintf('Got shipping method by ID %d and identifier "%s".', $shippingMethod->getId(), $shippingMethod->getIdentifier()));

        // Get a shipping method by identifier
        $shippingMethod = $this->shippingMethodService->getShippingMethod($shippingMethod->getIdentifier());
        $output->writeln(sprintf('Got shipping method by identifier "%s" and ID %d.', $shippingMethod->getIdentifier(), $shippingMethod->getId()));

        // Update the shipping method
        $updateStruct = $this->shippingMethodService->newShippingMethodUpdateStruct();
        $updateStruct->name = 'New Standard';
        $shippingMethod = $this->shippingMethodService->updateShippingMethod($shippingMethod, $updateStruct);
        $output->writeln(sprintf('Updated shipping method with ID %d and new name "%s".', $shippingMethod->getId(), $shippingMethod->getName()));

        // Find shipping methods
        $query = new ShippingMethodQuery();
        $query->orderBy('name', 'ASC');
        $shippingMethods = $this->shippingMethodService->findShippingMethods($query);
        $output->writeln(sprintf('Found %d shipping methods.', $shippingMethods->count()));

        // Delete the shipping method
        $this->shippingMethodService->deleteShippingMethod($shippingMethod);
        $output->writeln(sprintf('Deleted shipping method with ID %d and identifier "%s".', $shippingMethod->getId(), $shippingMethod->getIdentifier()));

        // Delete the shipping method translation
        $deleteTranslationStruct = new ShippingMethodDeleteTranslationStruct();
        $deleteTranslationStruct->shippingMethod = $shippingMethod;
        $deleteTranslationStruct->language = 'en';
        $
    }
}