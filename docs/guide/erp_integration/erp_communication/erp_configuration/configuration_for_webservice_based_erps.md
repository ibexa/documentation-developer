# Configuration for webservice-based ERPs [[% include 'snippets/experience_badge.md' %]]

If your ERP systems offers different URLs/webservices for each feature,
you can define the endpoint to the Webservice per messages.
The parameter `webservice_wsdl` can be set to the URL of the responsible webservice.  

``` yaml
siso_erp.default.message_settings.createsalesorder:
    message_class: "Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\CreateSalesOrderMessage"
    response_document_class: "\\Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\Document\\OrderResponse"
    webservice_operation: "MyWebserviceMethod"
    mapping_identifier: "createorder"
    webservice_wsdl: "https://mywebservice.com/WS/..../CreateOrderServices"
        
```

`webservice_operation` is the name of the method defined in the WSDL.

`webservice_wsdl` is the URL to the webservice itself.
