---
edition: commerce
---

# ERP integration

[[= product_name =]] can communicate with ERP systems. 

The communication covers, among other things, product and customer data, price and stock information, orders and order history.
[[= product_name =]] and the ERP system can exchange the following data.

|Data/Process|What is exchanged|Communication process|
|--- |--- |--- |
|Customer data|Data about the customer, such as invoice and purchase address, list of delivery addresses, status, customer group, credit limit, contact data|The data for a customer is fetched from ERP when the user logs in and has a customer number.|
|Product data|Products and product groups|Product import can run, for example, every night. This data is usually provided by using an export (XML, CSV, JSON).|
|Prices|List price and volume prices, individual prices|List prices are exchanged during the product import. Individual prices are fetched from ERP when a customer is logged in and has a customer number. In that case the shop requests prices in real time from ERP. You can define per project which cases request prices from the ERP (for example, product detail page, basket and checkout).|
|Orders|Address data, Delivery address, products and customer number|When the customer makes an order, the order is sent immediately to the ERP system. If electronic payment is involved, the order is placed when the payment provider acknowledges the transaction.|
|Documents|Invoices, orders, delivery notes, credit memos|The order history feature requests such documents in real time from the ERP. This ensures that the customer sees all documents even if they placed the order by phone or fax.|

## ERP configuration

To connect your shop to ERP, configure the following [ERP settings](../../guide/basket/basket.md) in the Back Office:

- URL of the Web-Connector
- User name (configured per Web-Connector)
- Password (configured per Web-Connector)

The following configuration enables the use of ERP:

``` yaml
siso_local_order_management.default.send_order_to_erp: true
siso_order_history.default.use_local_documents: false
```

### Checking ERP status

If a message to the ERP system fails, the shop checks whether the whole ERP is offline, or just this one message failed.

If it is a general error, the shop sets the ERP connection to offline.
When ERP is offline, requests are immediately handled as an error. 

The following parameter sets the ERP offline time for 60 seconds before another request is sent. 

``` yaml
siso_erp.erp_semaphore.max_lock_time: 60
```

### Configuration for webservice-based ERPs

If the ERP system offers different URLs/webservices for each feature,
you can define the endpoint to the webservice per message.
The parameter `webservice_url` can be set to the URL of the responsible webservice.  

``` yaml
siso_erp.default.message_settings.createsalesorder:
    message_class: "Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\CreateSalesOrderMessage"
    response_document_class: "\\Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\Document\\OrderResponse"
    webservice_operation: "CreateSalesOrder"
    webservice_url: "$web_connector.service_location;siso_erp$/InboundCreateOrderIISWebService.svc?wsdl"
    mapping_identifier: "createorder"
```

`webservice_operation` is the name of the method defined in the WSDL.

`webservice_url` is the URL to the webservice itself.

### Monitoring the ERP connection

The Back Office provides a monitoring service that enables checking all messages exchanged between ERP and [[= product_name =]].

To see it, go to **eCommerce -> Control center -> ERP request log**.

Then select a date range and a measuring point to get more details about requests that were sent to the ERP system.

![](../img/erp_request_log.png)
