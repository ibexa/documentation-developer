# Order format [[% include 'snippets/experience_badge.md' %]]

The data which is sent to the ERP is described in the XML specification (`vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/specifications/xml/request.createSalesOrder.xml`). 

## Order 

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<Order ses_unbounded="OrderLine" ses_tree="SesExtension">
    <!-- WARNING: calculateSalesPrice needs to be the same structure as createSalesOrder! -->
    <DocumentCurrencyCode>EUR</DocumentCurrencyCode>
    <UUID></UUID>
    <IssueDate>2005-06-20</IssueDate>
    <Note>sample</Note>
    <SalesOrderID></SalesOrderID>
    <CustomerReference></CustomerReference>
    <BuyerCustomerParty>
        <SupplierAssignedAccountID>1234</SupplierAssignedAccountID>
        <Party ses_unbounded="PartyIdentification">
            <PartyIdentification>
                <ID>10000</ID>
            </PartyIdentification>
        </Party>
    </BuyerCustomerParty>
    <!-- will not be used but it can be used in project specific impl. -->
    <SellerSupplierParty ses_type="ses:Party">
        <Party>
        </Party>
    </SellerSupplierParty>
    <!-- will not be used but it can be used in project specific impl.
         AccountingCustomerParty will be the party getting the invoice
     -->
    <AccountingCustomerParty ses_type="ses:Party">
        <Party>
        </Party>
    </AccountingCustomerParty>
    <Delivery ses_type="ses:DeliveryParty">
        <RequestedDeliveryPeriod>
            <EndDate>2005-06-30</EndDate>
            <EndTime>18:00:00.0Z</EndTime> <!-- necessary? -->
        </RequestedDeliveryPeriod>
        <DeliveryParty />
    </Delivery>
    <PaymentMeans>
        <PaymentMeansCode>31</PaymentMeansCode>           <!-- Code for ERP (e.g. CREDIT, CASHONDELIV, ...) -->
        <PaymentDueDate>2007-01-01</PaymentDueDate>
        <PaymentChannelCode>IBAN</PaymentChannelCode>     <!-- PAYPAL, BANK, other payment providers ... -->
        <InstructionID>A12345</InstructionID>             <!-- Transaction ID for epayments -->
        <!-- Just used for bank transfers / Lastschrift -->
        <PayeeFinancialAccount>
            <ID>IS000001261234560101901239</ID>           <!-- IBAN -->
            <CurrencyCode>EUR</CurrencyCode>
            <FinancialInstitutionBranch>
                <ID>SEISISRE</ID>                     <!-- BIC-->
                <Name>Central bank of Iceland</Name>  <!-- Name of Bank -->
            </FinancialInstitutionBranch>
        </PayeeFinancialAccount>
        <CardAccount>
            <PrimaryAccountNumberID></PrimaryAccountNumberID>  <!-- e.g crypted/masked card number -->
            <NetworkID></NetworkID> <!-- Master, Visa, .. -->
            <!--  <CardTypeCode>Debit, Credit etc. </CardTypeCode> -->
            <ExpiryDate></ExpiryDate>
        </CardAccount>
    </PaymentMeans>
    <TransactionConditions>
        <ID>3WEEKS</ID>
        <!-- or -->
        <ActionCode>3WEEKS</ActionCode>
    </TransactionConditions>

    <OrderLine ses_tree="SesExtension" ses_type="ses:LineItem">
        <Note>Freetext note on line 1</Note>
        <Note>Freetext note on line 2</Note>
        <LineItem />
        <SesExtension />
    </OrderLine>
    <SesExtension>
    </SesExtension>
</Order>
```

## Order lines

``` xml
<LineItem ses_unbounded="Delivery AllowanceCharge" ses_tree="SesExtension">
    <ID/>
    <SalesOrderID>10000</SalesOrderID>
    <Quantity>1</Quantity>
    <LineExtensionAmount/>
    <TotalTaxAmount/>
    <MinimumQuantity/>
    <MaximumQuantity/>
    <MinimumBackorderQuantity/>
    <MaximumBackorderQuantity/>
    <PartialDeliveryIndicator/>
    <BackOrderAllowedIndicator/>
    <Delivery>
        <MaximumQuantity>0</MaximumQuantity>
        <LatestDeliveryDate/>
    </Delivery>
    <AllowanceCharge>
        <ID/>
        <ChargeIndicator>true|false</ChargeIndicator>
        <AllowanceChargeReasonCode/>
        <AllowanceChargeReason/>
        <Amount/>
    </AllowanceCharge>
    <Price>
        <PriceAmount>2950</PriceAmount>
        <BaseQuantity>1</BaseQuantity>
    </Price>
    <Item ses_unbounded="Description ManufacturersItemIdentification">
        <Name>Web-Connector</Name>
        <Description>für SAP, Magento oder NAV</Description>
        <SellersItemIdentification>
            <ID>1000</ID>
            <ExtendedID>123</ExtendedID>
        </SellersItemIdentification>
        <ManufacturersItemIdentification>
            <ID>ABC</ID>
        </ManufacturersItemIdentification>
        <BuyersItemIdentification>
            <ID>ABC</ID>
        </BuyersItemIdentification>
    </Item>
    <SesExtension>
        <StockNumeric/>
        <OnStock/>
        <VatCode/>
        <PriceIsIncVat/>
    </SesExtension>
</LineItem>
```
