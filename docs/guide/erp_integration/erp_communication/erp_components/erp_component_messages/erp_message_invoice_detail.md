# ERP Message: InvoiceDetail [[% include 'snippets/experience_badge.md' %]]

`InvoiceDetail` fetches the detailed data for an existing invoice note.

## Request XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<InvoiceDetailRequest>
    <InvoiceID>10000</InvoiceID>
</InvoiceDetailRequest>
```

`InvoiceID` is the identification number of the requested invoice note

## Response XML

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<Invoice ses_unbounded="Delivery PaymentMeans PaymentTerms TaxTotal InvoiceLine">
    <ID></ID>
    <IssueDate></IssueDate>
    <!--TODO DUE_DATE-->
    <InvoiceTypeCode>SalesInvoice</InvoiceTypeCode>
    <OrderReference>
        <ID></ID> <!-- ??? ID or SalesOrderID -->
        <SalesOrderID></SalesOrderID>
        <IssueDate></IssueDate>
    </OrderReference>
    <AccountingSupplierParty>
    </AccountingSupplierParty>
    <AccountingCustomerParty ses_type="ses:Party">
        <Party></Party>
    </AccountingCustomerParty>
    <BuyerCustomerParty ses_type="ses:Party">
        <Party></Party>
    </BuyerCustomerParty>
    <Delivery ses_type="ses:DeliveryAddress" ses_tree="SesExtension">
        <!-- end TO DO -->
        <DeliveryAddress></DeliveryAddress>
        <SesExtension>
            <PaymentDueDate></PaymentDueDate> <!-- TODO Check if DueDate is correct -->
            <PayeeFinancialAccount>
                <CurrencyCode></CurrencyCode>
            </PayeeFinancialAccount>
        </SesExtension>
    </Delivery>
    <PaymentMeans>
        <PaymentDueDate></PaymentDueDate>
        <PayeeFinancialAccount>
            <CurrencyCode></CurrencyCode>
        </PayeeFinancialAccount>
    </PaymentMeans>
    <PaymentTerms>
        <Note></Note>
    </PaymentTerms>
    <TaxTotal>
        <!-- TODO <xsl:value-of select="HEADER_GENERAL/CURRENCY_CODE" /> put currency code in currencyID attribute?
        <TaxAmount currencyID="GBP"><xsl:value-of select="HEADER_GENERAL/VAT_AMOUNT" /></TaxAmount> -->
        <TaxAmount></TaxAmount>
    </TaxTotal>
    <LegalMonetaryTotal>
        <TaxExclusiveAmount></TaxExclusiveAmount>
        <TaxInclusiveAmount></TaxInclusiveAmount>
        <PayableAmount></PayableAmount>
    </LegalMonetaryTotal>
    <InvoiceLine ses_tree="SesExtension">
        <ID></ID>
        <Item>
            <Description></Description>
            <Name></Name>
            <BuyersItemIdentification>
                <ID></ID>
            </BuyersItemIdentification>
            <SellersItemIdentification>
                <ID></ID>
            </SellersItemIdentification>
            <ItemInstance>
                <LotIdentification>
                    <ExpiryDate></ExpiryDate> <!-- TODO Check if a document scoped field is available -->
                </LotIdentification>
            </ItemInstance>
        </Item>
        <Price>
            <PriceAmount></PriceAmount>
            <BaseQuantity></BaseQuantity>
        </Price>
        <SesExtension>
            <!-- TODO Check where to put this
            <Amount><xsl:value-of select="LINE/AMOUNT" /></Amount>
            <TaxInclusiveAmount><xsl:value-of select="LINE/AMOUNT_INCLUDING_VAT" /></TaxInclusiveAmount>
            <UnitOfMeasureCode><xsl:value-of select="LINE/UNIT_OF_MEASURE_CODE" /></UnitOfMeasureCode>
            <ShipmentDate><xsl:value-of select="LINE/SHIPMENT_DATE" /></ShipmentDate> -->
        </SesExtension>
    </InvoiceLine>
</Invoice>
```

Elements:

- `ID` - The requested document identification number
- `IssueDate` - The creation date of the document
- `OrderReference/ID` - The ID of the order related to the invoice note
- `OrderReference/SalesOrderID` - Currently the same as ID
- `OrderReference/IssueDate` - The creation date of the related order
- `AccountingCustomerParty` - Contains the party record for the business party the invoice is destined to (bill to)
- `BuyerCustomerParty` - Contains the party record for the business party which is the actual buyer (sell to)
- `Delivery` - Contains the delivery address information
    - `SesExtension/ShipmentMethod` - A code for shipment method (e.g. DHL Standard)
    - `SesExtension/ShippingAgentCode` - A code for the carrier who takes care of the transportation
- `PaymentMeans/PaymentDueDate` - The date until the invoice has to be settled
- `PaymentMeans/PayeeFinancialAccount/CurrencyCode` - The currency code for the invoice note
- `PaymentTerms` - Contains text about the terms of the payment
- `TaxTotal/TaxAmount` - The total amount of taxes for the invoice
- `LegalMonetaryTotal/TaxExclusiveAmount` - The total amount free of all taxes (net)
- `LegalMonetaryTotal/TaxInclusiveAmount` - The total amount including all taxes (gross)
- `LegalMonetaryTotal/PayableAmount` - The amount which has to be paid (net or gross depends on setup)
- `InvoiceLine` - May occur more than once. Contains information about the ordered articles
    - `Item/Description` - Description of the ordered item
    - `Item/Name` - Currently the same as Description
    - `Item/BuyersItemIdentification/ID` - Currently the same as the `SellersItemIdentification`. May be used if customers have their own identifications for items.
    - `Item/SellersItemIdentification/ID` - Item identification number.
    - `Price/PriceAmount` - The base price of the item
    - `Price/BaseQuantity` - The ordered quantity
    - `SesExtension/Amount` - The amount of this invoice line (may be net or gross)
    - `SesExtension/TaxInclusiveAmount` - The line amount inclusive taxes (gross)
    - `SesExtension/UnitOfMeasureCode` - A code determining the unit of measure (e.g. pieces)
    - `SesExtension/ShipmentDate` - The day when the order was shipped

### Reusable Party element

See [Reusable Party element](erp_message_select_customer.md#reusable-party-element)
