# ERP Messages: addresses [[% include 'snippets/experience_badge.md' %]]

`ReadDeliveryAddress`, `UpdateDeliveryAddress`, `CreateDeliveryAddress`, `DeleteDeliveryAddress`
are messages for delivery or shipping addresses.
All those messages have a similar structure. For Read and Delete, the ERP system expects only the `PartyIdentification` in the request.
The Delete response only contains a status response as text.

## ReadDeliveryAddress

See [Reusable DeliveryParty element](#reusable-deliveryparty-element)

### Request

``` xml
<ReadDeliveryAddressRequest ses_type="ses:DeliveryParty">
    <DeliveryParty />
</ReadDeliveryAddressRequest> 
```

### Response

``` xml
<ReadDeliveryAddressResponse ses_type="ses:DeliveryParty">
    <DeliveryParty />
</ReadDeliveryAddressResponse>
```

## UpdateDeliveryAddress

See [Reusable DeliveryParty element](#reusable-deliveryparty-element)

### Request

``` xml
<UpdateDeliveryAddressRequest ses_type="ses:DeliveryParty">
    <DeliveryParty />
</UpdateDeliveryAddressRequest>
```

### Response

``` xml
<UpdateDeliveryAddressResponse ses_type="ses:DeliveryParty">
    <DeliveryParty />
</UpdateDeliveryAddressResponse>
```

## CreateDeliveryAddress

See [Reusable DeliveryParty element](#reusable-deliveryparty-element)

### Request

``` xml
<CreateDeliveryAddressRequest ses_type="ses:DeliveryParty">
    <DeliveryParty />
</CreateDeliveryAddressRequest>
```

### Response

``` xml
<CreateDeliveryAddressResponse ses_type="ses:DeliveryParty">
    <DeliveryParty />
</CreateDeliveryAddressResponse> 
```

## DeleteDeliveryAddress

See [Reusable DeliveryParty element](#reusable-deliveryparty-element)

### Request

``` xml
<DeleteDeliveryAddressRequest ses_type="ses:DeliveryParty">
    <DeliveryParty />
</DeleteDeliveryAddressRequest>
```

### Response

``` xml
<DeleteDeliveryAddressResponse>
    <Result />
</DeleteDeliveryAddressResponse>
```

## Reusable DeliveryParty element

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<DeliveryParty ses_unbounded="PartyIdentification PartyName" ses_type="ses:Contact" ses_tree="SesExtension">
    <PartyIdentification>
        <ID>10000</ID>
    </PartyIdentification>
    <PartyName>
        <Name>Möbel-Meller KG</Name>
    </PartyName>
    <PostalAddress ses_unbounded="AddressLine" ses_tree="SesExtension">
        <StreetName>Tischlerstr. 4-10</StreetName>
        <AdditionalStreetName />
        <BuildingNumber>4-10</BuildingNumber>
        <CityName>Berlin</CityName>
        <PostalZone>12555</PostalZone>
        <CountrySubentity>Berlin</CountrySubentity>
        <CountrySubentityCode>BER</CountrySubentityCode>
        <AddressLine>
            <Line>Gartenhaus</Line>
        </AddressLine>
        <Country>
            <IdentificationCode>DE</IdentificationCode>
            <Name>Deutschland</Name>
        </Country>
        <Department>Development</Department>
        <SesExtension />
    </PostalAddress>
    <Contact>
    </Contact>
    <Person ses_tree="SesExtension">
        <FirstName>Frank</FirstName>
        <FamilyName>Dege</FamilyName>
        <Title>Herr</Title>
        <MiddleName />
        <SesExtension />
    </Person>
    <SesExtension />
</DeliveryParty> 
```

See [Reusable Contact element](erp_message_select_customer.md#reusable-contact-element)
