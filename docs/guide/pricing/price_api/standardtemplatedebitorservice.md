# StandardTemplateDebitorService

`StandardTemplateDebitorService` (service ID: `siso_core.template_debitor.standard`)
can be used when the customer doesn't have a customer or contact number yet,
but the number is necessary when communicating data to ERP.
An example is price calculation, when prices are calculated using ERP.

The ERP system uses a concept called "template debitors".

This service uses [`StandardCountryZoneService`](standardcountryzoneservice.md) to get the correct zone for the country.
The country is determined from the given BuyerParty.

Customer groups from the BuyerParty are also considered when determining the template debitor information.

## TemplateDebitorServiceInterface

|Method|Description|
|--- |--- |
|`getTemplateCustomerNumber()`|Returns the template customer number depending on the given parties. If no parties are provided, configuration is used to provide fallback template customer number.|
|`getTemplateContactNumber()`|Returns template contact number depending on the given parties. If no parties are provided, configuration is used to provide fallback template contact number.|
