# ERP messages [[% include 'snippets/commerce_badge.md' %]]

Order history uses the following ERP messages:

|`silver_erp.config.messages`|Process type in ERP|`webservice_operation`|Specifications|
|--- |--- |--- |--- |
|`invoice_detail`|`READPOSTEDSALESINVOICE`|`SV_OPENTRANS_GET_ORDERSTATUS`|`Resources/specifications/xml/request.invoiceDetail.xml`</br>`Resources/specifications/xml/response.invoiceDetail.xml`|
|`invoice_list`|`READPOSTEDSALESINVOICELIST`|`SV_OPENTRANS_GET_ORDERLIST`|`Resources/specifications/xml/request.invoiceList.xml`</br>`Resources/specifications/xml/response.invoiceList.xml`|
|`delivery_note_detail`|`READPOSTEDSALESSHIPMENT`|`SV_OPENTRANS_GET_ORDERSTATUS`|`Resources/specifications/xml/request.deliveryNoteDetail.xml`</br>`Resources/specifications/xml/response.deliveryNoteDetail.xml`|
|`delivery_note_list`|`READPOSTEDSALESSHIPMENTLIST`|`SV_OPENTRANS_GET_ORDERLIST`|`Resources/specifications/xml/request.deliveryNoteList.xml`</br>`Resources/specifications/xml/response.deliveryNoteList.xml`|
|`credit_memo_detail`|`READPOSTEDSALESCRMEMO`|`SV_OPENTRANS_GET_ORDERSTATUS`|`Resources/specifications/xml/request.creditMemoDetail.xml`</br>`Resources/specifications/xml/response.creditMemoDetail.xml`|
|`credit_memo_list`|`READPOSTEDSALESCRMEMOLIST`|`SV_OPENTRANS_GET_ORDERLIST`|`Resources/specifications/xml/request.creditMemoList.xml`</br>`Resources/specifications/xml/response.creditMemoList.xml`|
|`order_detail`|`READSALESDOCUMENT`|`SV_OPENTRANS_GET_ORDERSTATUS`|`Resources/specifications/xml/request.orderDetail.xml`</br>`Resources/specifications/xml/response.orderDetail.xml`|
|`order_list`|`READSALESDOCUMENTLIST`|`SV_OPENTRANS_GET_ORDERLIST`|`Resources/specifications/xml/request.orderList.xml`</br>`Resources/specifications/xml/response.orderList.xml`|

## Getting an invoice

This example fetches a invoice number from the ERP system:

``` php
$message = $this->container->get('silver_erp.message_inquiry_service')->inquireMessage(
    InvoiceDetailFactoryListener::INVOICEDETAIL
);
/** @var InvoiceDetailRequest $request */
$request = $message->getRequestDocument();
$request->ID->value = $invoiceNumber;
$request->CustomerNumber->value = $customerNumber;
/** @var WebConnectorMessageTransport $transport */
$transport = $this->container->get('silver_erp.message_transport');
$response = $transport->sendMessage($message)->getResponseDocument();
```

The specification for the request (`request.invoiceDetail.xml`) reflects the fields used in the request:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<InvoiceDetailRequest>
    <ID>10000</ID>
    <CustomerNumber>10000</CustomerNumber>
</InvoiceDetailRequest>
```

The response list is defined in `response.invoiceDetail.xml`.
