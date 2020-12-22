# ERP Message: SelectContact [[% include 'snippets/experience_badge.md' %]]

`SelectContact` fetches contact information, like all types of contact related data, from the ERP system or CRM system.

## Request XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<BuyerCustomerParty>
    <Party>
        <Contact>
            <ID>10000</ID>
        </Contact>
    </Party>
</BuyerCustomerParty>
```

## Response XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<OrderResponse>
    <ErpContact ses_type="ses:Contact">
        <Contact>
        </Contact>
    </ErpContact>
</OrderResponse>
```

### Reusable Contact element

``` xml
<Contact>
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
