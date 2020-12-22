# Getting product data from ERP [[% include 'snippets/experience_badge.md' %]]

## Retrieving products from ERP in a Symfony controller

``` php
/** @var WebConnectorErpService $importer */
$importer = $this->get('silver_erp.facade');
//Starting SKU
$startSku = '1..';
//Number of items to be retrieved (optional, default is 10)
$itemMaxCount = 30;
$items = $importer->selectItem($startSku, $itemMaxCount);
foreach($items as $products)
{
    foreach($products as $product)
    {
        //Prints the product's name
        echo (string)$product->ProductMeta->name->TextField->text->translations->translation[0]->value;
        //Prints the product's price
        echo (string)$product->ProductMeta->price->PriceField->price->price->value;
    }
}
```

## Adding new fields to map project specific fields

Copy the file `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/mapping/wc3-nav/xsl/response.itemtransfer.xsl` in `ProjectBundleName/Resources/mapping/wc3-nav/xsl` and edit it.

To add for example, the field `VAT_Prod_Posting_Group` from the response:

``` 
Array
(
    [SoapResponse] => Array
        (
            [ItemTransferResult] => Array
                (
                    [Item] => Array
                        (
                            [0] => Array
                                (
                                    [No] => 0002
                                    [No_2] => 
                                    [Description] => Waage / Personenwaage GS 39, Glaswaage
                                    [Search_Description] => WAAGE / PERSONENWAAGE GS 39, GLASWAAGE
                                    [Description_2] => mit Sprachfunktion, 4 Speicher, 150kg
                                    [Base_Unit_of_Measure] => STK
                                    [Net_Weight] => 2.4
                                    [Freight_Type] => 
                                    [Country_Region_Purchased_Code] => 
                                    [VAT_Bus_Posting_Gr_Price] => 
                                    [Gen_Prod_Posting_Group] => 07-19
                                    [Country_Region_of_Origin_Code] => 
                                    [Tax_Group_Code] => 
                                    [VAT_Prod_Posting_Group] => 19 <-- field to add
```

Add the following block to the xsl file under the `<Datamap>` section:

``` xml
<Datamap>
...
 <TextLine>
    <identifier>ses_vat_prod_posting_group</identifier><!-- Identifier -->
    <TextField>
        <text>
            <encoding></encoding>
            <translations ses_unbounded="translation">
                <translation>
                    <language>ger-DE</language>
                    <value><xsl:value-of select="VAT_Prod_Posting_Group"/></value><!-- The name of the field from the response -->
                </translation>
            </translations>
        </text>
        <SesExtension />
    </TextField>
</TextLine>
```

To add a field of type array, add an array block, also in the `Datamap` section:

``` xml
<Datamap>
...
<Array>
    <identifier>ses_attributes</identifier>
    <ArrayField>
        <array>
            <encoding></encoding>
            <translations ses_unbounded="translation">
                <translation ses_tree="value">
                    <language>ger-DE</language>
                    <value><xsl:copy-of select="Attributes" /></value>
                </translation>
            </translations>
        </array>
        <SesExtension />
    </ArrayField>
</Array>
```
