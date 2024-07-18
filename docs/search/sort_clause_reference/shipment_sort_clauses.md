---
description: Shipment Sort Clauses
edition: commerce
page_type: reference

---

# Shipment Sort Clauses

Shipment Sort Clauses are only supported by [Shipment Search (`ShipmentService::findShipments`)](shipment_api.md#get-multiple-shipments).

By using Sort Clauses you can filter shipments by specific attributes, for example: creation date, status, and so on.

| Sort Clause | Sorting based on |
|-----|-----|
|[Id](shipment_id_sort_clause.md)|Shipment ID|
|[Identifier](shipment_identifier_sort_clause.md)|Shipment identifier|
|[CreatedAt](shipment_createdat_sort_clause.md)|Date and time when shipment was created|
|[UpdatedAt](shipment_updatedat_sort_clause.md)|Date and time when shipment status was updated|
|[Status](shipment_status_sort_clause.md)|Shipment status|
