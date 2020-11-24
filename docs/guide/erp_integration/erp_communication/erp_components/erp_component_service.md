# ERP service component [[% include 'snippets/experience_badge.md' %]]

To provide a simple interface to the ERP communication, the `AbstractErpService` abstract class is defined.
This class is derived from Symfony service classes.
For example the `WebConnectorErpService` implements this abstract class for the communication to the Web.Connector.

For every basic request to the ERP one class methods exists (e.g. for price calculation of some products). Currently this includes:

``` php
public function calculatePrices(PriceRequest $priceRequest);
public function submitOrder(Basket $basket, array $params = array());
public function selectCustomer($customerNumber, $maxCount = 1, array $params = array());
public function selectContact($customerNumber, $contactNumber = '', array $params = array());
```

## Service method implementation

An implementation for the `selectCustomer()` method can look like the following:

``` php
class ExampleErpService extends AbstractErpService
{
    /**
     * @var Silversolutions\Bundle\EshopBundle\Services\MessageInquiryService
     */
    protected $messageInquiry;
    /**
     * @var Silversolutions\Bundle\EshopBundle\Services\Transport\AbstractMessageTransport
     */
    protected $transport;

    // {...}
    
    public function selectCustomer($customerNumber, $maxCount = 1, array $params = array())
    {
```

First you invoke the message factory to create an instance of the ERP message you want to send.

``` php
        // try to get message instance
        try {
            /** @var SelectCustomerMessage $selectCustomerMessage */
            $selectCustomerMessage = $this->messageInquiry->inquireMessage(
                StandardMessageFactoryListener::SELECTCUSTOMER
            );
        } catch (MessageInquiryException $messageException) {
            // {Do some logging or appropriate exception handling}
            return null;
        }
```

Then you have to feed the data which was given to the method into the received message object.

``` php
        // initialize request values and send message
        if (!$selectCustomerMessage instanceof SelectCustomerMessage) {
            $context = array('message' => $selectCustomerMessage);
            // {Do some logging or appropriate exception handling}
            return null;
        }
        $selectCustomerMessage->setCustomerNumber($customerNumber);
        $selectCustomerMessage->setMaxCount($maxCount);
```

Next you have to get an instance of the transport service and give the message instance to the `sendMessage()` method.
It returns the same instance which you passed as argument, but if is successful, that instance holds the response now.

``` php
        try {
            $response = $this->transport->sendMessage($selectCustomerMessage)->getResponseDocument();
            if (!$response instanceof OrderResponse) {
                $context = array('response' => $response);
                // {Do some logging or appropriate exception handling}
                return null;
            }
        } catch (\RuntimeException $rtException) {
            // {Do some logging or appropriate exception handling}
            return null;
        }
```

Now you can return the response of the message directly or prepare the response that is defined by this service method.

``` php
        return $response;
    }
```

## Symfony service configuration

If you reimplement the abstract service, you have to register your class as a service:

``` yaml
services:
    silver_erp.facade:
        class:     "\Example\Namespace\ExampleErpService"
        arguments: ["@silver_erp.message_inquiry_service", "@silver_erp.message_transport"]
```

The service ID has to be `silver_erp.facade`. That way this implementation is automatically used when the ERP service is injected as a dependency.
The arguments in the example above are another two services of the ERP bundle.
These are injected as dependency of the example service class.
Since the message inquiry service and the transport service are necessary for all ERP communication,
these two dependencies are the least of all ERP service implementations.

This redefines the default service configuration. Make sure that your configuration has a higher priority than the ERP bundle in your Symfony project setup.
