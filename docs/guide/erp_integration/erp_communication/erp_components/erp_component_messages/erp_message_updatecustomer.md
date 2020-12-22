# ERP Message: UpdateCustomer [[% include 'snippets/experience_badge.md' %]]

`UpdateCustomer` sends customer information, such as addresses, to the ERP system.

Customer update message identifier for service:

``` php
$this->container->get('silver_erp.message_inquiry_service')->inquireMessage(UpdateCustomerFactoryListener::UPDATECUSTOMER);
```

## Request XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<RequestUpdateCustomer ses_type="ses:Party">
    <Party />
</RequestUpdateCustomer>
```

## Response XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<ResponseUpdateCustomer ses_type="ses:Party">
    <Party />
</ResponseUpdateCustomer>
```

### Reusable Party element

See [Reusable Party element](erp_message_select_customer.md#reusable-party-element) for more information.

## Mapping

### Request XSL

``` xml
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/RequestUpdateCustomer/Party">
        <WC_USER_MANAGEMENT>
            <PROCESS_TYPE>UPDATECUSTOMER</PROCESS_TYPE>
            <WEB_SITE>HOME</WEB_SITE>
            <NUMBER>
                <xsl:value-of select="PartyIdentification/ID"/>
            </NUMBER>
            <BLOCKED />
            <CURRENCY />
            <WEB_NEWSLETTER />
            <JOB_TITLE />
            <NAME><xsl:value-of select="PartyName/Name"/></NAME>
            <NAME_2 />
            <ADDRESS><xsl:value-of select="PostalAddress/StreetName"/></ADDRESS>
            <ADDITIONAL_ADDRESS_INFO><xsl:value-of select="PostalAddress/AdditionalStreetName"/></ADDITIONAL_ADDRESS_INFO>
            <CITY><xsl:value-of select="PostalAddress/CityName"/></CITY>
            <COUNTRY_CODE><xsl:value-of select="Country/IdentificationCode"/></COUNTRY_CODE>
            <COUNTY><xsl:value-of select="PostalAddress/CountrySubentity"/></COUNTY>
            <RESPONSIBILITY_CENTER />
            <COMPANY_NUMBER />
            <FAX_NUMBER><xsl:value-of select="Contact/Telefax"/></FAX_NUMBER>
            <POST_CODE><xsl:value-of select="PostalAddress/PostalZone"/></POST_CODE>
            <PHONE_NUMBER><xsl:value-of select="Contact/Telephone"/></PHONE_NUMBER>
            <HOME_PAGE />
            <E_MAIL><xsl:value-of select="Contact/ElectronicMail"/></E_MAIL>
            <LANGUAGE_CODE><xsl:value-of select="Contact/SesExtension/LanguageCode"/></LANGUAGE_CODE>
            <SALUTATION><xsl:value-of select="Person/Title"/></SALUTATION>
            <SALESPERSON_CODE />
            <CUSTOMER_POSTING_GROUP><xsl:value-of select="SesExtension/CustomerPostingGroup"/></CUSTOMER_POSTING_GROUP>
            <GEN_BUS_POSTING_GROUP><xsl:value-of select="SesExtension/GenBusPostingGroup"/></GEN_BUS_POSTING_GROUP>
            <VAT_BUS_POSTING_GROUP><xsl:value-of select="SesExtension/VatBusPostingGroup"/></VAT_BUS_POSTING_GROUP>
            <CONTACT_PERSON><xsl:value-of select="Contact/Name"/></CONTACT_PERSON>
            <CREDIT_LIMIT_LCY />
        </WC_USER_MANAGEMENT>
    </xsl:template>
</xsl:stylesheet>
```

### Response XSL

``` xml
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/*">
        <ResponseUpdateCustomer>
            <Party>
                <PartyIdentification>
                    <ID>
                        <xsl:value-of select="NUMBER"/>
                    </ID>
                </PartyIdentification>
                <PartyName>
                    <Name><xsl:value-of select="NAME"/></Name>
                </PartyName>
                <PostalAddress ses_unbounded="AddressLine" ses_tree="SesExtension">
                    <StreetName><xsl:value-of select="ADDRESS"/></StreetName>
                    <AdditionalStreetName><xsl:value-of select="ADDITIONAL_ADDRESS_INFO"/></AdditionalStreetName>
                    <BuildingNumber />
                    <CityName><xsl:value-of select="CITY"/></CityName>
                    <PostalZone><xsl:value-of select="POST_CODE"/></PostalZone>
                    <CountrySubentity><xsl:value-of select="COUNTY"/></CountrySubentity>
                    <AddressLine>
                        <Line />
                    </AddressLine>
                    <Country>
                        <IdentificationCode><xsl:value-of select="COUNTRY_CODE"/></IdentificationCode>
                    </Country>
                    <SesExtension />
                </PostalAddress>
                <Contact>
                    <Name><xsl:value-of select="CONTACT_PERSON"/></Name>
                    <Telephone><xsl:value-of select="PHONE_NUMBER"/></Telephone>
                    <Telefax><xsl:value-of select="FAX_NUMBER"/></Telefax>
                    <ElectronicMail><xsl:value-of select="E_MAIL"/></ElectronicMail>
                    <SesExtension>
                        <LanguageCode><xsl:value-of select="LANGUAGE_CODE"/></LanguageCode>
                    </SesExtension>
                </Contact>
                <Person ses_tree="SesExtension">
                    <Title><xsl:value-of select="SALUTATION"/></Title>
                </Person>
                <SesExtension>
                    <CustomerPostingGroup><xsl:value-of select="CUSTOMER_POSTING_GROUP"/></CustomerPostingGroup>
                    <GenBusPostingGroup><xsl:value-of select="GEN_BUS_POSTING_GROUP"/></GenBusPostingGroup>
                    <VatBusPostingGroup><xsl:value-of select="VAT_BUS_POSTING_GROUP"/></VatBusPostingGroup>
                </SesExtension>
            </Party>
        </ResponseUpdateCustomer>
    </xsl:template>
</xsl:stylesheet>
```
