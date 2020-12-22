# ERP Message: SelectCustomer [[% include 'snippets/experience_badge.md' %]]

`SelectCustomer` fetches customer information, like all types of addresses etc., from the ERP system.
It is stored in the session afterwards to avoid duplicate calls to the ERP.

## Request XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<BuyerCustomerParty>
    <Party>
        <PartyIdentification>
            <ID>10000</ID>
        </PartyIdentification>
    </Party>
</BuyerCustomerParty>
```

## Response XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<OrderResponse>
    <BuyerCustomerParty ses_type="ses:Party">
        <Party>
        </Party>
    </BuyerCustomerParty>
    <SellerSupplierParty></SellerSupplierParty>
    <AccountingCustomerParty ses_type="ses:Party">
        <Party>
        </Party>
    </AccountingCustomerParty>
    <OriginatorCustomerParty></OriginatorCustomerParty>
    <Delivery ses_type="DeliveryAddress">
        <DeliveryAddress>
        </DeliveryAddress>
        <RequestedDeliveryPeriod></RequestedDeliveryPeriod>
    </Delivery>
    <Delivery ses_type="DeliveryAddress">
        <DeliveryAddress>
        </DeliveryAddress>
        <RequestedDeliveryPeriod></RequestedDeliveryPeriod>
    </Delivery>
    <Delivery ses_type="DeliveryAddress">
        <DeliveryAddress>
        </DeliveryAddress>
        <RequestedDeliveryPeriod></RequestedDeliveryPeriod>
    </Delivery>
    <OrderLine />
</OrderResponse>
```

Elements:

- `BuyerCustomerParty` - The party record which contains all information about the person / organization, which buys items.
- `SellerSupplierParty` - The party record which contains all information about the person / organization, which sells items.
- `AccountingCustomerParty` - The party record which contains all information about the person / organization, which is intended to receive and settle the invoice documents.
- `OriginatorCustomerParty` - Additonal customer party which may be necessary if two parties are included in an order process. For example, if a different department in an organization handles the purchase of items that another departments originally requested.
- `Delivery` - Records that contain delivery information (including delivery party and address).

### Reusable Party element

``` xml
<Party ses_unbounded="PartyIdentification PartyName" ses_type="ses:Contact" ses_tree="SesExtension">
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
</Party>
```

Elements:

- `PartyIdentification` - Although this element could occur several times (with different scheme codes), in this case it is only used once for a single party ID string.
- `PostalAddress` - Contains all address information. There are more fields.
    - `AddressLine`/`Line` - Can be used to define additional lines which are not defined in particular.

### Reusable Contact element

``` xml
<Contact ses_tree="SesExtension">
    <ID>KT1001</ID>
    <Name>Mr Fred Churchill</Name>
    <Telephone>+44 127 2653214</Telephone>
    <Telefax>+44 127 2653215</Telefax>
    <ElectronicMail>fred@iytcorporation.gov.uk</ElectronicMail>
    <OtherCommunication></OtherCommunication>
    <Note></Note>
    <SesExtension>
        <LanguageCode></LanguageCode>
        <IsMain></IsMain>
    </SesExtension>
</Contact>
```

### Reusable DeliveryAddress element

This element is currently not used in any standard message.

``` xml
 <DeliveryAddress ses_unbounded="AddressLine">
    <ID></ID>
    <Postbox></Postbox>
    <StreetName>Tischlerstr. 4-10</StreetName>
    <AdditionalStreetName></AdditionalStreetName>
    <InhouseMail></InhouseMail>
    <Department>Möbel-Meller KG</Department>
    <MarkAttention></MarkAttention>
    <MarkCare></MarkCare>
    <PlotIdentification></PlotIdentification>
    <CitySubdivisionName></CitySubdivisionName>
    <CityName>Düsseldorf</CityName>
    <PostalZone>48436</PostalZone>
    <CountrySubentity></CountrySubentity>
    <CountrySubentityCode></CountrySubentityCode>
    <Region></Region>
    <District></District>
    <TimezoneOffset></TimezoneOffset>
    <AddressLine />
    <Country></Country>
    <LocationCoordinate></LocationCoordinate>
</DeliveryAddress>
```
