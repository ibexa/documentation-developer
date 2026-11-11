# Shipment Search Criteria reference

Shipment Search Criteria

Editions: Commerce

Shipment Search Criteria are only supported by [Shipment Search (`ShipmentService::findShipments`)](../../../commerce/shipping_management/shipment_api/index.md#get-multiple-shipments).

With these Criteria you can filter shipments by their shipment identifier, shipment creation date, shipment status, shipping method, and more.

## Shipment Search Criteria

| Search Criterion                                                                                                    | Search based on                                                                    |
| ------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| [CreatedAt](../shipment_createdat_criterion/index.md)            | Date and time when shipment was created                                            |
| [Currency](../shipment_currency_criterion/index.md)              | Currency code                                                                      |
| [Id](../shipment_id_criterion/index.md)                          | Shipment ID                                                                        |
| [Identifier](../shipment_identifier_criterion/index.md)          | Shipment identifier                                                                |
| [LogicalAnd](../shipment_logicaland_criterion/index.md)          | Logical AND criterion that matches if all the provided Criteria match              |
| [LogicalOr](../shipment_logicalor_criterion/index.md)            | Logical OR criterion that matches if at least one of the provided Criteria matches |
| [Owner](../shipment_owner_criterion/index.md)                    | Owner based on the user reference                                                  |
| [ShippingMethod](../shipment_shipping_method_criterion/index.md) | Shipping method applied to the shipment                                            |
| [Status](../shipment_status_criterion/index.md)                  | Status of the shipment                                                             |
| [UpdatedAt](../shipment_updatedat_criterion/index.md)            | Date and time when status of the shipment was updated                              |
