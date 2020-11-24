# ERP communication [[% include 'snippets/experience_badge.md' %]]

[[= product_name_exp =]] uses the logic of an ERP system in different situations:

- During login process, to get customer data 
- In product detail page (configurable), to get prices and stock infos
- In basket 
- In checkout
- During registration, to create contacts or customers
- In order history, to get documents from the ERP
- When importing products

The shop comes with a predefined set of messages:

|Message|Description|
|--- |--- |
|`calculate_sales_price`|Calculates prices using the business logic of the ERP|
|`createsalesorder`|Creates an order|
|`select_customer`|Gets customer data from the ERP|
|`select_contact`|Gets contact data for a person from the ERP|
|`create_contact`|Creates a contact in the ERP|
|`updatecustomer`|Updates a customer in the ERP|
|`orderdetail`|Gets details about an order|
|`invoice_detail`|Gets details about an invoice|
|`delivery_note_detail`|Gets details about a delivery note|
|`orderlist`|Gets a list of orders|
|`invoice_list`|Gets a list of invoice|
|`delivery_note_list`|Gets a list of delivery notes|
|`creditmemolist`|Gets a list of credit memos|
|`creditmemodetail`|Gets details about a credit memo|
|`readdeliveryaddress`|Gets data of a delivery address for specified party ID|
|`updatedeliveryaddress`|Updates the ERP data of an existing delivery address|
|`createdeliveryaddress`|Creates a new delivery address for a specified party ID|
|`deletedeliveryaddress`|Deletes a specific delivery address|

You can find the standard messages in `EshopBundle/Resources/config/messages.yml`.

Each bundle can extend these messages or define its own messages if required.

## Configuration

Make sure you have symlinks in the `app/Resources` folder:

``` bash
# If the 'Resources' directory does not exist, create it first
mkdir app/Resources

cd app/Resources/
ln -s ../../vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/xslbase

# if you have local message, add this symlink as well:
ln -s ../../src/<namespace>/Bundle/CommonBundle/Resources/xsl
```

For more information about the ERP message mapping, see [ERP Component: Mapping](erp_components/erp_component_mapping.md).

## Debugging

Log messages are logged to the database. A command-line tool offers a feature to check which messages were exchanged with the ERP system.

This command waits for the next message and displays the request and result as XML:

??? note "Example message log"

    ``` xml
    sudo -u _www php bin/console siso_tools:display_erp_log_command
     
    2016-12-14 17:44:16 Start new entry in the Erp Log Table with ID 11441
    Start ** mapping_type **
    responseEnd ** mapping_type **
    Start ** stylesheet **
    app/Resources/xslbase/response.noop.xslEnd ** stylesheet **
    Start ** input_xml **
    <?xml version="1.0" encoding="UTF-8"?>
    <OrderResponse>
      <SalesOrderID>0</SalesOrderID>
      <DocumentCurrencyCode/>
      <IssueDate>2016-12-14</IssueDate>
      <BuyerCustomerParty>
    ......
    End ** input_xml **
    Start ** output_xml **
    <?xml version="1.0"?>
    <OrderResponse>
      <SalesOrderID>0</SalesOrderID>
      <DocumentCurrencyCode/>
      <IssueDate>2016-12-14</IssueDate>
      <BuyerCustomerParty>
        <Party>
          <PartyName>
            <Name>Melanie Bourner</Name>
          </PartyName>
          <PartyIdentification>
            <ID>10000</ID>
          </PartyIdentification>
          <PostalAddress>
            <StreetName>F&#xE4;rberstra&#xDF;e 14</StreetName>
            <BuildingName/>
            <BuildingNumber/>
            <CityName>Berlin</CityName>
            <PostalZone>12</PostalZone>
            <CountrySubentity/>
            <AddressLine/>
            <Country>
              <IdentificationCode>DE</IdentificationCode>
            </Country>
          </PostalAddress>
        </Party>
      </BuyerCustomerParty>
    ...
    End ** output_xml **
    End new entry in the Erp Log Table.  Date: 2016-12-14 17:44:16
    Previous information of the Measuring Point = "250_mapping"
    ```

You can search for a specific message using the `--search-text` option:

``` bash
php bin/console siso_tools:display_erp_log_command --search-text 123456788
```

To dump 100 last messages, use the `--dump-last-messages` option:

``` bash
php bin/console siso_tools:display_erp_log_command --dump-last-messages 20 > /tmp/erp_messaages.txt
```

You can remove messages from the database with the `--delete-messages` option.

The following example removes messages older than three days:

``` bash
php bin/console siso_tools:display_erp_log_command --delete-messages 3
```
