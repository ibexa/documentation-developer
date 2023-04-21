---
description: The order management component covers creating orders and managing their lifecycle.
edition: commerce
---

# Order management

The order management component enables users to search for orders and filter search results. 
Depending on their role, users can also track the status of their orders, review order details, cancel orders, issue invoices for orders, and generate aggregate reports.

From the development perspective, the component enables customization of the order management workflow and integration with external systems to exchange order information.

The component exposes the following:

- [PHP API](order_management_api.md) that allows for managing orders
- [REST API](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-orders) that helps get order information over HTTP

### Order management service 

The Order Management package provides the `Ibexa\Contracts\OrderManagement\OrderServiceInterface` service, 
which is the entrypoint for calling the [backend API](order_management_api.md).
