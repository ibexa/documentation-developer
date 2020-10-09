# StandardTemplateDebitorService

`StandardTemplateDebitorService` can be used when the customer doesn't have a customer or contact number yet,
but the number is necessary when communicating data to ERP.
An example is price calculation, when prices are calculated using ERP.

The ERP system is using a concept called "template debitors".

This service uses [`StandardCountryZoneService`](standardcountryzoneservice.md) to get the correct zone for the country.
The country is determined from the given BuyerParty.

Customer groups from the BuyerParty are also considered when determining the template debitor information.

### Storing customer groups in BuyerParty

``` xml
<Party ses_unbounded="PartyIdentification PartyName" ses_type="ses:Contact" ses_tree="SesExtension">
    <SesExtension>
        <CustomerGroups>
            <Code>GROUPA</Code>
            <Code>GROUPB</Code>
        </CustomerGroups>
    </SesExtension>
</Party> 
```

## Configuration

Service ID: `siso_core.template_debitor.standard`

Default template customer information:

``` yaml
siso_core.template_debitor.customer_numbers:
    #configuration for the zone
    EU:
        #configuration for the country Germany
        DE:
            #customer groups possible:
            #GROUPA: 10001
            #more groups
            #GROUPB: 10002
            #default if no customer groups available
            default: 10000
        #default value for the zone, if no country is specified
        default: 40000
    World:
        default: 20000
    #default value if no zone is specified
    default: 10000

siso_core.template_debitor.contact_numbers:
    #configuration for the zone
    EU:
        #configuration for the country
        DE:
            #customer groups possible:
            #GROUPA: KT100211
            #more groups
            #GROUPB: 10002
            #default if no customer groups available
            default: KT100210
        #default value for the zone, if no country is specified
        default: KT000004
    World:
        default: KT000136
    #default value if no zone is specified
    default: KT100210
```

## TemplateDebitorServiceInterface

|Method|Description|
|--- |--- |
|`public function getTemplateCustomerNumber(Party $buyerParty = null, Party $invoiceParty = null, Party $deliveryParty = null);`|This method returns the template customer number depending on the given parties. If no parties are provided, configuration is used to provide fallback template customer number.|
|`public function getTemplateContactNumber(Party $buyerParty = null,Party $invoiceParty = null,Party $deliveryParty = null);`|This method returns template contact number depending on the given parties. If no parties are provided, configuration is be used to provide fallback template contact number.|
