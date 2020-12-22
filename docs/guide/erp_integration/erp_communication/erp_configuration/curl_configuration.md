# cURL configuration [[% include 'snippets/experience_badge.md' %]]

## cURL

``` yaml
parameters:
    silver_erp.config.curl.target_url: "http://rest.example.host:81/service"
    silver_erp.config.curl.options:
        CURLOPT_HTTPHEADER:
            - "Content-Type: application/xml"
```

### silver_erp.config.curl.target_url

`silver_erp.config.curl.target_url` is the URL that is addressed by cURL to send the message data.

### silver_erp.config.curl.options

`curl.options` is an associative array that lets you define all possible values that can be set by [curl_setopt()](http://www.php.net/manual/en/function.curl-setopt.php).
This parameter defines the default values used for every message.
You can override it using the override parameter in the respective message configuration.

### silver_erp.config.messages

There are some transport-specific settings in the `silver_erp.config.messages` parameter:

- You can define a different URL which should be used for the communication. That URL is configured in the `webservice_operation` field.
- You can override the values in the `silver_erp.config.curl.options` parameter. This is done in an additional field `override`.

For example:

``` yaml
silver_erp.config.curl.options:
    CURLOPT_HTTPHEADER:
        - "Content-Type: application/xml"

silver_erp.config.messages:
    search_product_info:
        message_class: "Namespace\\ExampleMessage"
        response_document_class: "\\oasis\\names\\specification\\ubl\\schema\\xsd\\OrderResponse_2\\OrderResponse"
        webservice_operation: "http://otherhost.example.com/example-message"
        mapping_identifier: "example"
        override:
            silver_erp.config.curl.options:
                CURLOPT_HTTPPROXYTUNNEL: true
                CURLOPT_PROXY: "proxy.host:1234" 
```

In this case, for the `search_product_info` message, additionally to the `CURLOPT_HTTPHEADER` some proxy settings are set up in the cURL handle: `CURLOPT_HTTPPROXYTUNNEL` and `CURLOPT_PROXY`.

## Messages

Messages are configured in the `silver_erp.config.messages` parameter.

This parameter is an associative array which itself holds further associative arrays.
The top-level keys are identifiers for the messages which are currently not evaluated in the process logic.
The keys within a particular message configuration are the following:

- `message_class` is the fully-qualified class name of the class that holds the request and response document instances.
It is used by the transport implementations to determine the configuration for the given message object.
- `response_document_class` is the class that is instantiated by the transport implementation with the received data of the response.
- `webservice_operation` is a string value that determines the triggered operation of the transport
 Its specific value depends on the transport implementation.
- `mapping_identifier` is a string that configures the mapping identifier for this specific message.

For example:

``` yaml
parameters:
    silver_erp.config.messages:
        calculate_sales_price:
            message_class: "Silversolutions\\Bundle\\EshopBundle\\Message\\CalculateSalesPriceMessage"
            response_document_class: "oasis\\names\\specification\\ubl\\schema\\xsd\\OrderResponse_2\\OrderResponse"
            webservice_operation: SV_OPENTRANS_CALCULATE_PRICE
            mapping_identifier: calcprice
```
