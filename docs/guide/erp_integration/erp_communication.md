# ERP communication [[% include 'snippets/commerce_badge.md' %]]

The shop comes with a predefined set of messages that are used to communicate with ERP:

|Message|Description|
|--- |--- |
|`calculate_sales_price`|Calculates prices based on ERP's business logic|
|`createsalesorder`|Creates an order|
|`select_customer`|Gets customer data from ERP|
|`select_contact`|Gets contact data for a person from ERP|
|`create_contact`|Creates a contact in ERP|
|`updatecustomer`|Updates a customer in ERP|
|`orderdetail`|Gets details about an order|
|`invoice_detail`|Gets details about an invoice|
|`delivery_note_detail`|Gets details about a delivery note|
|`orderlist`|Gets a list of orders|
|`invoice_list`|Gets a list of invoice|
|`delivery_note_list`|Gets a list of delivery notes|
|`creditmemolist`|Gets a list of credit memos|
|`creditmemodetail`|Gets details about a credit memo|
|`readdeliveryaddress`|Gets delivery address data for the provided party ID|
|`updatedeliveryaddress`|Updates the ERP data of an existing delivery address|
|`createdeliveryaddress`|Creates a new delivery address for the provided party ID|
|`deletedeliveryaddress`|Deletes a delivery address|

You can find the standard messages in `EshopBundle/Resources/config/messages.yml`.

## Additional lines

A response that ERP sends to the shop can contain more information about a product than was requested.
This information can include additional shipping costs, vouchers, bonus products, discounts, etc.
This information is handled by a service that adds lines to the basket or to a basket line.

`WebConnectorService` passes the whole ERP response object to [`RemotePriceProvider`](remotepriceprovider.md).
`RemotePriceProvider` creates additional lines in the price response if it gets additional price information from ERP that has not been requested.
