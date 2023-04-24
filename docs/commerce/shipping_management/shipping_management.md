---
description: The shipping management component covers defining and managing shipping methods as well as managing shipments and their lifecycle.
edition: commerce
---

# Shipping management

The shipping management component enables users to define and manage shipping methods of different types, as well as create and manage shipments, search for shipments and filter search results. 
Depending on their role, users can also enable or disable shipping methods, change status of shipments, and cancel shipments.

!!! note "Shipping method types"

    Two types of shipping methods are available by default: `flat rate` and `free`.

From the development perspective, the component enables customization of the shipment workflow.

The component exposes the following:

- [Shipping method PHP API](shipping_method_api.md) that allows for managing shipping methods
- [Shipment PHP API](shipment_api.md) that allows for managing shipments
- [REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-shipments) that helps get shipment information over HTTP

### Services

The Shipping management package provides the following services, which are entry points for calling backend APIs:

- `Ibexa\Contracts\Checkout\ShippingMethodServiceInterface`
- `Ibexa\Contracts\Checkout\ShipmentServiceInterface`
