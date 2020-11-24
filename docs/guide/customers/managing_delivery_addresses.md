# Managing delivery addresses [[% include 'snippets/commerce_badge.md' %]]

!!! note

    These examples are based on Web Connector >= 3.0 for NAV with Web Services.
    For other ERP systems and former versions of the Web-Connector / NAV, the process and the data differ slightly.
    The external field 'Key', and the logic bound to it is specific for this setup.

## Create a new delivery address in ERP

Delivery address management follows the standard process for all ERP messages.
The following example depicts a simple implementation with hardcoded address values.

The address code generation is not managed in the ERP. Unlike this hardcoded value,
the application must track existing address codes and ensure that no duplicated codes
are sent to the ERP.

``` php
// Get the necessary services
$messageInq = $this->getContainer()->get('silver_erp.message_inquiry_service');
$messageTrans = $this->getContainer()->get('silver_erp.message_transport');

// Inquire the message object and prepare the request data
$msg = $messageInq->inquireMessage(CreateDeliveryAddressFactoryListener::CREATEDELIVERYADDRESS);
/** @var CreateDeliveryAddressRequest $request */
$request = $msg->getRequestDocument();
$request->DeliveryParty->PartyIdentification[0] = new DeliveryPartyPartyIdentification();
$request->DeliveryParty->PartyIdentification[0]->ID->value = '10000';
$request->DeliveryParty->SesExtension->value['Code'] = 'TEST';
$request->DeliveryParty->SesExtension->value['Blocked'] = 'false';
$request->DeliveryParty->PartyName = array(
    new DeliveryPartyPartyName(),
    new DeliveryPartyPartyName(),
);
// First name
$request->DeliveryParty->PartyName[0]->Name->value = 'Timothy';
// Last name
$request->DeliveryParty->PartyName[1]->Name->value = 'Tester';
$request->DeliveryParty->PostalAddress->StreetName->value = 'Testallee 1';
$request->DeliveryParty->PostalAddress->AdditionalStreetName->value = 'Gassenstr.';
$request->DeliveryParty->PostalAddress->CityName->value = 'Testow';
// Note: In NAV, only properly configured values are allowed for country codes.
$request->DeliveryParty->PostalAddress->CountrySubentityCode->value = '';
$request->DeliveryParty->PostalAddress->PostalZone->value = '12345';

// Send the data and process the response
/** @var CreateDeliveryAddressResponse $response */
$response = $messageTrans->sendMessage($msg)->getResponseDocument();
// The record key should be stored in the application's database for later updates.
$key = $response->DeliveryParty->SesExtension->value['Key'];
```

## Read an existing delivery address from the ERP

In the ERP, the address code and party identification are required to fetch a delivery address.

``` php
// Get the necessary services
$messageInq = $this->getContainer()->get('silver_erp.message_inquiry_service');
$messageTrans = $this->getContainer()->get('silver_erp.message_transport');

// Inquire the message object and prepare the request data
$msg = $messageInq->inquireMessage(ReadDeliveryAddressFactoryListener::READDELIVERYADDRESS);
/** @var ReadDeliveryAddressRequest $request */
$request = $msg->getRequestDocument();
$request->DeliveryParty->PartyIdentification[0] = new DeliveryPartyPartyIdentification();
$request->DeliveryParty->PartyIdentification[0]->ID->value = '10000';
$request->DeliveryParty->SesExtension->value['Code'] = 'TEST';

// Send the data and process the response
/** @var ReadDeliveryAddressResponse $response */
$response = $messageTrans->sendMessage($msg)->getResponseDocument();
```

## Update an existing delivery address in the ERP

Complete data must be sent (changed and unchanged fields) to change the address,
together with the Key value of the last read data. The Key is a consistency check for the update.
If the data in the ERP changed since it was fetched the last time, the Key of the update request does not match the Key in NAV and the request fails.
In that case, the data must be fetched again and current changes must be merged into the new data from NAV.
Fetching data might require user interaction (several HTTP requests).
The merged data must then be sent again in an update request with the new Key.

``` php
// Get the necessary services
$messageInq = $this->getContainer()->get('silver_erp.message_inquiry_service');
$messageTrans = $this->getContainer()->get('silver_erp.message_transport');

// Get the stored address data from the application's database
$deliveryParty = $this->fetchDeliveryAddress('10000', 'TEST');
    
// Inquire the message object and prepare the request data
$msg = $messageInq->inquireMessage(UpdateDeliveryAddressFactoryListener::UPDATEDELIVERYADDRESS);
/** @var UpdateDeliveryAddressRequest $request */
$request = $msg->getRequestDocument();
$request->DeliveryParty = $deliveryParty;
// Just an arbitrary extension of an existing value
$request->DeliveryParty->PostalAddress->StreetName->value .= '+';

// Send the data and process the response
/** @var UpdateDeliveryAddressResponse $response */
$response = $messageTrans->sendMessage($msg)->getResponseDocument();
if ($msg->getResponseStatus() === AbstractMessage::RESPONSE_STATUS_ERP_ERROR) {
    /* Evaluate if the error was because of a mismatch of the sent 'Key' value
     * If so:
     * - Fetch the current address data according to ReadDeliveryAddress
     * - Resolve possible conflicts with the changed data
     * - Retry the update with the new Key
     */
} else {
    // Standard error handling
}

// Store the newly retrieved key in the application's database for future updates
$lastKey = isset($response->DeliveryParty->SesExtension->value['Key'])
    ? $response->DeliveryParty->SesExtension->value['Key']
    : '';
```

## Delete an existing delivery address in the ERP

Only the Key is needed for the request to delete addresses.
If the value does not match the one in the ERP, the request is rejected and the data must be re-fetched
to get the new Key (and new data for a potential review of the changes).

``` php
// Get the necessary services
$messageInq = $this->getContainer()->get('silver_erp.message_inquiry_service');
$messageTrans = $this->getContainer()->get('silver_erp.message_transport');

// Fetch the last stored Key
$lastKey = $this->getLastKey('10000', 'TEST');

// Inquire the message object and prepare the request data
$msg = $messageInq->inquireMessage(DeleteDeliveryAddressFactoryListener::DELETEDELIVERYADDRESS);
/** @var DeleteDeliveryAddressRequest $request */
$request = $msg->getRequestDocument();
$request->DeliveryParty->SesExtension->value['Key'] = $lastKey;

// Send the data and process the response
/** @var DeleteDeliveryAddressResponse $response */
$response = $messageTrans->sendMessage($msg)->getResponseDocument();
$status = $response->Result->value;
```
