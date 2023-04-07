---
description: Use PHP API to manage shipments n Commerce: create, update and delete shipments.
edition: commerce
---

# Shipment API

!!! tip "Shipping management REST API"

    To learn how to manage shipments with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-shipping).

To get shipments and manage them, use the `Ibexa\Contracts\ShippingManagement\ShipmentServiceInterface` interface.

## Get single shipment 

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     */
    public function getShipment(int $id): ShipmentInterface;

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     */
    public function getShipmentByIdentifier(string $identifier): ShipmentInterface;

    public function findShipments(?ShipmentQuery $query = null): ShipmentListInterface;

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\BadStateException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     */
    public function createShipment(ShipmentCreateStruct $createStruct): ShipmentInterface;

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\BadStateException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     */
    public function updateShipment(ShipmentInterface $shipment, ShipmentUpdateStruct $updateStruct): ShipmentInterface;

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     */
    public function deleteShipment(ShipmentInterface $shipment): void;