# Order Submission [[% include 'snippets/experience_badge.md' %]]

Depending on the chosen payment method, the order is completed after:

- submitting the [order summary](../../../checkout/checkout_api/forms/order_summary.md)
- receiving a notification from the payment gateway
- returning from the payment gateway

During completion, order data is sent to the ERP system. On success, the state of the submitted basket changes to `confirmed`.
If it fails, the state becomes `ordered_failed` and an email is sent to administrator.

## BasketGuidService

After the summary of the checkout is confirmed by the user, the payment process is initiated.
To identify the order across all systems (shop, payment gateway, ERP system), a GUID is generated and stored to the basket.
The generation of that ID is left to the `BasketGuidService` service (service ID `silver_basket.guid_service`).
This way it is easy to override the standard generation routine.

## WebConnectorErpService

`AbstractErpService` defines the `submitOrder(Basket $basket)` method

The standard implementation of this method is found in `\Silversolutions\Bundle\EshopBundle\Services\WebConnectorErpService`

This method prepares the [`CreateSalesOrderMessage`](../../erp_communication/erp_components\erp_component_messages/erp_message_calculatesalesorder_createsalesorder.md) out of the basket's data and sends it to the ERP using [ERP transport](../../erp_communication/erp_components/erp_component_transport.md).
In case of an error during remote communication the [failed order process](../failed_order_process/failed_order_process.md) is triggered using `OrderFailedEvent`.

## Event before order is submitted

Before the order is sent to the ERP an event is triggered.
The corresponding event listener can modify the basket data or perform any additional action.
It can set the status to `failed` and set en error message.

If the event status is `failed`, the order is not submitted and is treated as a lost order.

It is not possible to use services in appropriate event listeners that require the session,
because the process can also be executed from the command line in the lost order process.

For example it is not possible to use the `CustomerProfileDataService` (`ses.customer_profile_data.ez_erp`), and the Repository (`ezpublish.api.repository`) must be used instead in order to fetch the user data.

## Sending additional data in the order

You can extend the message with additional fields in two ways:

- Extend the `CreateSalesOrderMessage` class. This solution requires maintenance effort in case of an update of the shop's base implementation, as changes to the base message must be merged to the extended version.
- Write the data into [one of the SesExtension](../../erp_communication/erp_components\erp_component_messages/erp_message_calculatesalesorder_createsalesorder.md) [tree elements (see `ses_tree` in table)](../../erp_communication/erp_components\erp_component_messages/erp_message_class_generator.md)).
This solution should only be used to add simple, single-valued fields.
During the communication with the remote service (e.g. Web.Connector), the tree attributes are mapped between PHP arrays and XML data implicitly without any structure definition.
This can cause conflicts for XML elements that occur multiple times, and sequential PHP arrays.

### Example

Sometimes it is necessary to send additional project-specific data in the order.
If you need to send the data to ERP, you can get it from basket (`dataMap`) or from customer data.

In such a case, implement an event listener which subscribes to `MessageRequestEvent`.

#### Service implementation

``` php
class MessageRequestListener
{
    /**
     * This method must be registered as a listener to the
     * 'silver_eshop.request_message' event.
     *
     * @param MessageRequestEvent $event
     */
    public function onOrderRequest(MessageRequestEvent $event)
    {
        $message = $event->getMessage();
        if ($message instanceof CreateSalesOrderMessage) {
            /** @var Order $request */
            $request = $message->getRequestDocument();
            $userId = $request->BuyerCustomerParty->SupplierAssignedAccountID->value;           
         
            if (!empty($userId)) {
                try {
                    $userService = $this->ezRepository->getUserService();
                    $ezUser = $userService->loadUser($userId);
                    if ($ezUser->getFieldValue(EzHelperService::USER_CUSTOMER_PROFILE_DATA)->text != '') {
                        $customerProfileDataBase64Serialize = $ezUser->getFieldValue(EzHelperService::USER_CUSTOMER_PROFILE_DATA)->text;
                        $customerProfileDataSerialized = base64_decode($customerProfileDataBase64Serialize);
                        $customerProfileData = unserialize($customerProfileDataSerialized);
                        //read customer data and set them in the SesExtension field
                        if ($customerProfileData instanceof CustomerProfileData) {
                            $customerType = $customerProfileData->sesUser->customerType;                           
                            $title = $customerProfileData->getDataMap()->hasAttribute('title')
                                ? $customerProfileData->getDataMap()->getAttribute('title') : '';
                            $academicTitle = $customerProfileData->getDataMap()->hasAttribute('academicTitle')
                                ? $customerProfileData->getDataMap()->getAttribute('academicTitle') : '';                          
                           
                            $request->SesExtension->value['customerType'] = isset($customerType) ? $customerType : '';                     
                            $request->SesExtension->value['title'] = isset($title) ? $title : '';
                            $request->SesExtension->value['academicTitle'] = isset($academicTitle) ? $academicTitle : ''; 
                    }
                } catch (\Exception $e) {
                    // must be injected, somehow
                    $this->logger->error('Exception:' . $e->getMessage());
                }
            }
        }
    }
}
```

#### Service configuration

``` xml
<parameter key="siso_checkout.message_request_listener.class">Path\To\Your\Class\MessageRequestListener</parameter>

<service id="siso_checkout.message_request_listener" class="%siso_checkout.message_request_listener.class%">           
   <tag name="kernel.event_listener" event="silver_eshop.request_message" method="onOrderRequest" />
</service>
```
