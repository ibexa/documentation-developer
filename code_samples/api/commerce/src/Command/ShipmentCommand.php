<?php

declare(strict_types=1);
 
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Contracts\Checkout\ShipmentServiceInterface;
use Ibexa\Contracts\Checkout\Shipment\ShipmentCreateStruct;
use Ibexa\Contracts\Checkout\Shipment\ShipmentQuery;
use Ibexa\Contracts\Checkout\Shipment\ShipmentUpdateStruct;
use Ibexa\Contracts\Checkout\Shipment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Checkout\Shipment\Query\Criterion\LogicalOr;
use Ibexa\Contracts\Checkout\Shipment\Query\Criterion\ShippingMethod;
use Ibexa\Contracts\Checkout\Shipment\Query\Criterion\UpdatedAt;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;

final class ShipmentCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ShipmentServiceInterface $shipmentService;

    public function __construct(
      PermissionResolver $permissionResolver,
      UserService $userService,
      ShipmentServiceInterface $shipmentService
      ) {
        $this->shipmentService = $shipmentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:shipment');
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): 
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single shipment
        $id = 1;
        $shipment = $this->shipmentService->getShipment($id);

        $output->writeln(sprintf('Shipment %d has status %s', $id, $shipment->getStatus()));

        // Get a single shipment by identifier
        $shipmentIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $shipment = $this->shipmentService->getShipmentByIdentifier($shipmentIdentifier);

        $output->writeln(sprintf('Your shipment has status %s', $shipment->getStatus()));

        // Query for shipments
        $shipmentCriterions = [
            new ShippingMethod(1),
            new CreatedAt('2023-03-24 15:09:16'),
            new UpdatedAt('2023-03-25 09:00:15'),
        ];
        
        $shipmentQuery = new ShipmentQuery(new LogicalOr(...$shipmentCriterions));
        $shipmentQuery->setLimit(20);

        $shipmentsList = $this->shipmentService->findShipments($shipmentQuery);

        $shipmentsList->getShipments();
        $shipmentsList->getTotalCount();

        foreach ($shipmentsList as $shipment) {
            $output->writeln($shipment->getIdentifier() . ': ' . $shipment->getName());
        }

        // Create a new shipment
        $shipmentCreateStruct = new ShipmentCreateStruct(
            'free',
            1,
            EUR('100')
        );

        $shipment = $this->shipmentService->createShipment($shipmentCreateStruct);

        $output->writeln(sprintf('Created shipment with identifier %s', $shipment->getIdentifier()));

        // Update existing shipment
        $shipmentUpdateStruct = new ShipmentUpdateStruct();
        $shipmentUpdateStruct->setStatus('shipped');

        $this->shipmentService->updateShipment($shipment, $shipmentUpdateStruct);

        $output->writeln(sprintf('Changed shipment status to %s', $shipment->getStatus());

        // Delete existing shipment permanently
        $this->shipmentService->deleteShipment($shipment);

        return self::SUCCESS;
    }
}
