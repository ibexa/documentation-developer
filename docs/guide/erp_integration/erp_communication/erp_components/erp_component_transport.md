# ERP transport component [[% include 'snippets/experience_badge.md' %]]

The transport component provides an interface to the physical transportation of the messages.
This includes the serialization of the data into a stream that the physical transportation is capable to process.
Because serialized data is the most abstract form of data (generally a string),
the mapping invocation is also placed in this component.
For more information about mapping itself, see [ERP mapping component](erp_component_mapping.md).

## Abstract message transport class

All transport classes must derive from `AbstractMessageTransport`.
This class provides a public but final `sendMessage()` method that defines a process that all transport classes must provide.
It calls an abstract protected `internalSendMessage()` method which has to do the actual communication and message processing.
Furthermore, it checks a semaphore service which indicates whether the remote ERP service is available
and sets that semaphore afterwards if an error occurred during communication.

The overall process is:

1. Dispatch a `MessageRequestEvent` which enables listeners to change the request before it is sent.
1. Do the actual message transportation to the remote service:
    1. Check the semaphore service if communication is not blocked. `ErpDisabledException` is thrown and caught if it is blocked.
    1. Call `internalSendMessage()`
    1. If `ErpUnavailableException` is thrown by `internalSendMessage()`, the semaphore is set to blocked.
1. Dispatch a `MessageResponseEvent` which enables listeners to change the response before it is passed back to the standard business logic. `MessageExceptionEvent` is dispatched instead if an error occurrs.
 
### Events

There are two events defined which are dispatched during the transport:

- `\Silversolutions\Bundle\EshopBundle\Message\Event\TransportMessageEvents::REQUEST_MESSAGE = 'silver_eshop.request_message'` - the `silver_eshop.request_message` event is dispatched when a message is about to be sent by the transport layer (before a potential mapping). 
The event listener receives an instance of `Silversolutions\Bundle\EshopBundle\Message\Event\MessageRequestEvent`.
- `\Silversolutions\Bundle\EshopBundle\Message\Event\TransportMessageEvents::RESPONSE_MESSAGE = 'silver_eshop.response_message'` - the `silver_eshop.response_message` event is dispatched when a message was received and unserialized by the transport layer (after a potential mapping).  
The event listener receives an instance of `Silversolutions\Bundle\EshopBundle\Message\Event\MessageResponseEvent`.
- `\Silversolutions\Bundle\EshopBundle\Message\Event\TransportMessageEvents::RESPONSE_MESSAGE = 'silver_eshop.exception_message'` - this `silver_eshop.exception_message` event is dispatched when an exception occurs while sending the message.
The event listener receives an instance of `Silversolutions\Bundle\EshopBundle\Message\Event\MessageExceptionEvent`.

### Test the transport channel

AbstractErpTransport has an additional method: `testCommunication()`.

This method is intended to invoke an actual request by using the transport and return the status of the response in form of a boolean value (`true` = success; `false` = failure)

Parameters:

|Type|Definition|Description|
|--- |--- |--- |
|string|`& $errorText = ''`|This optional parameter gets a variable per reference to which an error text is written (if any occurs).|

## ERP semaphore service

The `Silversolutions\Bundle\EshopBundle\Services\ErpSemaphoreServiceInterface` interface indicates the status of availability of the remote ERP system. This interface provides two methods.

### testAvailability()

This method is intended to check the status of the semaphore.
If the semaphore is locked, `Silversolutions\Bundle\EshopBundle\Exceptions\ErpDisabledException` is thrown, otherwise nothing happens.
The semaphore is locked if `setUnavailable()` was invoked before and the timeout hasn't expired.

### setUnavailable()

This method is intended to set the status of the semaphore to locked and set/reset the timeout for that status.
The timeout has to be set the service implementation somehow. Injection is recommended.

### StashErpSemaphoreService

`StashErpSemaphoreService` (`Silversolutions\Bundle\EshopBundle\Services\StashErpSemaphoreService`)
uses the Symfony Stash API to persist the status of the semaphore between requests.
It is configured with the following parameters:

- `siso_erp.erp_semaphore.stash_item_id` - A string which identifies the semaphore within the stash pool.
- `siso_erp.erp_semaphore.max_lock_time` - An integer which defines the semaphore's timeout in seconds.

This service has a dependency to `Stash\Interfaces\PoolInterface` injected into the constructor.

### FileErpSemaphoreService

`FileErpSemaphoreService` (`Silversolutions\Bundle\EshopBundle\Services\FileErpSemaphoreService`)
uses simple file system functions for persisting the status of the semaphore between requests.
It is configured with the following parameters:

- `siso_erp.erp_semaphore.lock_file` - defines the path to the file which should be used to determine the status of the semaphore.
- `siso_erp.erp_semaphore.max_lock_time` - an integer which defines the semaphore's timeout in seconds.

!!! note

    This implementation might not be safe for cluster configurations.

## Web.Connector transport

This class is the transport implementation that communicates with the Web.Connector.

Currently only the SOAP RPC mode is implemented.

Serializing:

For serializing [Symfony's serializer API](https://github.com/symfony/Serializer) is used.
For this a new (un-)serializer was created: DomXmlEncoder.
This class leverages a fork of the XSD2PHP library and can transform the document class instances automatically to XML code and backwards.
During deserialization, fields that are not defined in the destination response class are ignored
and it is logged using the logging dependency of the transport.

Mapping:

Additionally, if an instance of `AbstractDocumentMappingService` is injected by the method `setMappingService()`,
the normalized array of the request and response are passed to this mapping service.
The subclass of the mapper must be able to handle array data.
For example, the `XsltDocumentMappingService` may be used. If no service is injected, no mapping is done at all.

Injecting configuration:

All configuration must be injected using the respective setter methods.
These method calls are already defined in the service configuration of the EshopBundle.
All default values are defined in `webconnector.yml` and may or must be overwritten in the project configuration.

### Configuration parameters (webconnector.yml)

Example:

``` yaml
silver_erp.config.web_connector.service_location: "http://webconnector.example.com:81/webconnector/webconnector_opentrans.php5"
silver_erp.config.web_connector.service_uri: "http://www.silversolutions.de"
silver_erp.config.web_connector.default_parameters:
    user: serviceUser
    password: $secret!
    erp_parameters:
        timeout: 10000
```

#### `silver_erp.config.web_connector.service_location`

This is a string field. It defines a URL which directs the Web.Connector's web-service.

#### `silver_erp.config.web_connector.service_uri`

This is a string field.

#### `silver_erp.config.web_connector.default_parameters`

This is an array map field. All ERP operations of the Web.Connector have the same parameter signature.
The last parameter is the given message data. The others can be configured in this configuration parameter:

- `user`: Web.Connector authentication user name.
- `password`: Web.Connector authentication user password.
- `erp_parameters`: another array map defining additional parameters.

### Message configuration parameters (messages.yml)

Example:

``` yaml
silver_erp.config.messages:
    example_message:
        message_class: "Namespace\\ExampleMessage"
        response_document_class: "Namespace\\DocumentClass"
        webservice_operation: SV_OPENTRANS_CALCULATE_PRICE
        mapping_identifier: example
    another_message: ...
```

#### `silver_erp.config.messages`

This is an array map field. It contains several keys which themselves contain records for the respective message configuration.
The keys do not have any functional meaning, they only offer a distinction of the messages in the configuration itself.

- `message_class`: The fully-qualified class name of the message (instance of `AbstractMessage`)
- `response_document_class`: The fully-qualified class name of the response document. This is used to instantiate the response in the transport before the raw data is fed into the instance.
- `webservice_operation`: The name of the SOAP web-service operation for this message.
- `mapping_identifier`: The base name of the mapping, if any is set up.
- `debug`: When set, the message's request and response data is written to the log file shortly before and after SOAP call.
