<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalOr;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\UpdatedAt;
use Ibexa\Contracts\Shipping\Shipment\ShipmentCreateStruct;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;
use Ibexa\Contracts\Shipping\Shipment\ShipmentUpdateStruct;
use Ibexa\Contracts\Shipping\ShipmentServiceInterface;
use Ibexa\Contracts\Shipping\ShippingMethodServiceInterface;
use Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:shipment'
)]
final class ShipmentCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ShipmentServiceInterface $shipmentService;

    private ShippingMethodServiceInterface $shippingMethodService;

    private OrderServiceInterface $orderService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        ShipmentServiceInterface $shipmentService,
        ShippingMethodServiceInterface $shippingMethodService,
        OrderServiceInterface $orderService
    ) {
        $this->shipmentService = $shipmentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->shippingMethodService = $shippingMethodService;
        $this->orderService = $orderService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get a single shipment
        $id = 1;
        $shipment = $this->shipmentService->getShipment($id);

        $output->writeln(
            sprintf(
                'Shipment %d has status %s',
                $id,
                $shipment->getStatus()
            )
        );

        // Get a single shipment by identifier
        $identifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $shipment = $this->shipmentService->getShipmentByIdentifier($identifier);

        $output->writeln(
            sprintf(
                'Your shipment has status %s',
                $shipment->getStatus()
            )
        );

        // Query for shipments
        $shipmentCriteria = [
            new ShippingMethod($this->shippingMethodService->getShippingMethod('free')),
            new CreatedAt(new \DateTime('2023-03-24 15:09:16')),
            new UpdatedAt(new \DateTime('2023-03-25 09:00:15')),
        ];

        $shipmentQuery = new ShipmentQuery(new LogicalOr(...$shipmentCriteria));
        $shipmentQuery->setLimit(20);

        $shipmentsList = $this->shipmentService->findShipments($shipmentQuery);

        $shipmentsList->getShipments();
        $shipmentsList->getTotalCount();

        foreach ($shipmentsList as $shipment) {
            $output->writeln(
                $shipment->getIdentifier() . ': ' . $shipment->getStatus()
            );
        }

        // Create a new shipment
        $shipmentCreateStruct = new ShipmentCreateStruct(
            $this->shippingMethodService->getShippingMethod('free'),
            $this->orderService->getOrder(135),
            new Money\Money(100, new Money\Currency('EUR'))
        );

        $shipment = $this->shipmentService->createShipment($shipmentCreateStruct);

        $output->writeln(
            sprintf(
                'Created shipment with identifier %s',
                $shipment->getIdentifier()
            )
        );

        // Update existing shipment
        $shipmentUpdateStruct = new ShipmentUpdateStruct();
        $shipmentUpdateStruct->setTransition('send');

        $this->shipmentService->updateShipment($shipment, $shipmentUpdateStruct);

        $output->writeln(
            sprintf(
                'Changed shipment status to %s',
                $shipment->getStatus()
            )
        );

        // Delete existing shipment permanently
        $this->shipmentService->deleteShipment($shipment);

        return self::SUCCESS;
    }
}
