# Implementing ERP delivery address creation and updates [[% include 'snippets/experience_badge.md' %]]

## General DeliveryParty record

All ERP messages for manipulation of a customer's delivery addresses use the same data structure at their core:

``` php
/** @var \Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\DeliveryParty $deliveryParty */
$deliveryParty->PartyIdentification[0]->ID->value = 'alphanumeric';
$deliveryParty->PartyName[0]->Name->value = 'alphanumeric';
$deliveryParty->PartyName[1]->Name->value = 'alphanumeric';
$deliveryParty->PostalAddress->StreetName->value = 'alphanumeric';
$deliveryParty->PostalAddress->AdditionalStreetName->value = 'alphanumeric';
$deliveryParty->PostalAddress->CityName->value = 'alphanumeric';
$deliveryParty->PostalAddress->CountrySubentityCode->value = 'alphanumeric code'; // Must exist in NAV
$deliveryParty->PostalAddress->PostalZone->value = 'post/zip code';
$deliveryParty->SesExtension->value['Code'] = 'alphanumeric code';
$deliveryParty->SesExtension->value['Blocked'] = 'boolean';
$deliveryParty->SesExtension->value['Key'] = 'alphanumeric';
```

Most of the fields are standard address fields. `PartyName` can be specified multiple times.
The number of lines that can be specified depends on the ERP.

`PartyIdentification` is where the customer number is defined. The first element can always be used.

`CountrySubentityCode` is a code that must be correctly set in ERP.

There are some values which are only evaluated by the NAV ERP system. These are `Code`, `Blocked` and `Key`.
Those fields are transmitted in the `SesExtension` array:

`Code` must be a value which is unique among all delivery addresses for the respective customer.
`Blocked` is a boolean which activate or deactivates the address.
`Key` is special field which is used to determine the integrity of the handled data.

## Create a delivery address for a registered customer

In order to create new addresses, the whole record must be created, for example:

``` php
use Silversolutions\Bundle\EshopBundle\Services\Factory\CreateDeliveryAddressFactoryListener;
use Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\CreateDeliveryAddressRequest;
use Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\CreateDeliveryAddressResponse;

/** @var \Silversolutions\Bundle\EshopBundle\Services\MessageInquiryService $messageInq */
$messageInq = $this->getContainer()->get('silver_erp.message_inquiry_service');
/** @var \Silversolutions\Bundle\EshopBundle\Services\Transport\AbstractMessageTransport $messageTrans */
$messageTrans = $this->getContainer()->get('silver_erp.message_transport');

$msg = $messageInq->inquireMessage(CreateDeliveryAddressFactoryListener::CREATEDELIVERYADDRESS);
/** @var CreateDeliveryAddressRequest $request */
$request = $msg->getRequestDocument();
$request->DeliveryParty->PartyIdentification[0] = new DeliveryPartyPartyIdentification();
$request->DeliveryParty->PartyIdentification[0]->ID->value = '10000';
$request->DeliveryParty->SesExtension->value['Code'] = 'TEST001';
$request->DeliveryParty->SesExtension->value['Blocked'] = 'false';
$request->DeliveryParty->PartyName = array(
    new DeliveryPartyPartyName(),
    new DeliveryPartyPartyName(),
);
$request->DeliveryParty->PartyName[0]->Name->value = 'Timothy';
$request->DeliveryParty->PartyName[1]->Name->value = 'Tester';
$request->DeliveryParty->PostalAddress->StreetName->value = 'Testallee 1';
$request->DeliveryParty->PostalAddress->AdditionalStreetName->value = 'Gassenstr.';
$request->DeliveryParty->PostalAddress->CityName->value = 'Testow';
$request->DeliveryParty->PostalAddress->CountrySubentityCode->value = ''; // Must exist in NAV
$request->DeliveryParty->PostalAddress->PostalZone->value = '12345';
/** @var CreateDeliveryAddressResponse $response */
$response = $messageTrans->sendMessage($msg)->getResponseDocument();
```
