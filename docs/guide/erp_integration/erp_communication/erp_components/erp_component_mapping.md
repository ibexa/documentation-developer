# ERP mapping component [[% include 'snippets/experience_badge.md' %]]

Mapping is used to transform a specific data format into another.
The abstract class `AbstractMessageMappingService` defines the interface for all mapping services.

## XsltDocumentMappingService

`XsltDocumentMappingService` is a mapping service that uses an XSLT processor to perform the mapping.

XSL files have to be stored in two special directories inside of the `/app/Resources` directory:

- `xslbase` contains the standard implementation.
- `xsl` contains specific adaptations of selected message mappings.

The files in these directories follow the naming scheme: `request|response.<messageCode>.xsl`.
The first part determines the direction of the communication.
The second part (`messageCode`) is passed to the `map*()` methods and defines which message is being mapped.
`FileLocatorInterface` is used to resolve the XSL files.

Example `request.productsearch.xsl`:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/CatalogueSearchRequest">
        <PRODUCT_SEARCH>
            <CUSTOMER_NUMBER><xsl:value-of select="PartyIdentification/ID" /></CUSTOMER_NUMBER>
            <!-- CatalogueItemIdentification|StandardItemIdentification maybe? -->
            <ARTICLE_AID><xsl:value-of select="CatalogueLine/Item/ManufacturersItemIdentification/ID" /></ARTICLE_AID>
            <!-- SellersItemIdentification maybe?-->
            <CUSTOMER_AID><xsl:value-of select="CatalogueLine/Item/BuyersItemIdentification/ID" /></CUSTOMER_AID>
            <PRODUCT_TYPE><xsl:value-of select="CatalogueLine/Item/CommodityClassification/ItemClassificationCode" /></PRODUCT_TYPE>
            <DESCRIPTION><xsl:value-of select="CatalogueLine/Item/Description" /></DESCRIPTION>
            <QUANTITY><xsl:value-of select="CatalogueLine/MaximumOrderQuantity" /></QUANTITY>
            <LANGUAGE><xsl:value-of select="Language/LocaleCode" /></LANGUAGE>
        </PRODUCT_SEARCH>
    </xsl:template>
</xsl:stylesheet>
```

Example configuration:

``` yaml
silver_erp.config.messages:
    search_product_info:
        message_class: "Name\\ProjectBundle\\Entity\\Messages\\SearchProductInfoMessage"
        response_document_class: "\\oasis\\names\\specification\\ubl\\schema\\xsd\\OrderResponse_2\\OrderResponse"
        webservice_operation: "http://webserviceurl"
        mapping_identifier: productsearch
```

## Multiple values / unbounded cardinality

Currently, in PHP code, the messages are converted to arrays without considering XSD,
so it is necessary to mark these elements to be converted to an array, even if it occurs only once.
This is done in a special attribute in the target structure.
The attribute's name is `singleElementArrays` and its content must be the respective elements' unqualified, space-separated names.
For example:

- `<Party singleElementArrays="PartyIdentification PartyName">`
- `<PostalAddress singleElementArrays="AddressLine">`

## DefaultValues for undefined attributes

`DefaultValuesService` can be used to set default values in outgoing or incoming ERP messages.

Default values are written on runtime into the objects if a specified field does exist and is empty.
It is possible to set any attribute or the value of a field.
If a specified field value/path does not exist, the service tries to build the object hierarchy by reflection
with the help of the `phpDocHeaders` from the UBL classes.

To set a default value, the complete path for the specified field must be used. For example:

`BuyerCustomerParty/PostalAddress/Country/IdentificationCode/value: "DE"`

## Configuration via `default_values.yml`

Configuration format:

``` yaml
parameters:
    silver_erp.config.default_values.request_mappings:
        <Message-Object-Type>:
            <Message-Object-Field>: <Defaultvalue>

    silver_erp.config.default_values.response_mappings:
        <Message-Object-Type>:
            <Message-Object-Field>: <Defaultvalue>
```

Example: Setting the value of the field `DocumentCurrencyCode` to `EUR` in an incoming `OrderResponse`:

``` yaml
parameters:
    silver_erp.config.default_values.response_mappings:
        OrderResponse:
            DocumentCurrencyCode/value: "EUR"
            BuyerCustomerParty/PostalAddress/Country/IdentificationCode/value: "DE"
            Delivery[]/DeliveryAddress/Country/value: "DE"
```

### NoopDocumentMappingService

`NoopDocumentMappingService` is a mapping service that does no mapping at all.
It can be used if a dependency to an `AbstractDocumentMappingService` is required but no mapping is necessary nor available.
