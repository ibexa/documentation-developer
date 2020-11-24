# eContent xonfiguration [[% include 'snippets/commerce_badge.md' %]]

## Data provider

The following configuration is available in `econtent.yml`. 

`catalog_data_provider` Configures the shop to use eCcontent as data provider:

``` yaml
#possible values: econtent or ez5
silver_eshop.default.catalog_data_provider: econtent
```

## Languages

The indexer for eContent needs to know which languages are used in your project and if you are using a fallback language.

Adapt this setting according to your project needs:

``` yaml
siso_search.default.index_econtent_languages:
    ger-DE: eng-GB #language: ger-DE, fallback: eng-GB
    eng-GB: ger-DE #language: eng-GB, ger-DE
```

`silver_econtent.default.languages` defined the languages used for eContent.
If there are other languages present in database they will be ignored.

``` yaml
#definition for econtent languages
silver_econtent.default.languages: [ eng-GB, ger-DE]

#language for "eng" SiteAccess with no fallback.
silver_econtent.eng.languages: [ eng-GB ]

#language for "ger" SiteAccess with English as fallback.
silver_econtent.ger.languages: [ ger-DE, eng-GB ]
```

The second language specified here is the fallback language.
This means that if content is not found in the first language, it will use the second language instead.

## Database tables

``` yaml
silver_econtent.default.table_object: sve_object
silver_econtent.import.table_object: sve_object_tmp
silver_econtent.default.table_object_attributes: sve_object_attributes
silver_econtent.import.table_object_attributes: sve_object_attributes_tmp
silver_econtent.default.table_class: sve_class
silver_econtent.default.table_class_attributes: sve_class_attributes
silver_econtent.default.table_externaldata: ses_externaldata
```

## Catalog segmentation

``` yaml
# Used for catalog segmentation: enabled or disabled
silver_econtent.default.section_filter: disabled
# Defines the name of the table to be used
silver_econtent.default.table_catalog_filter: sve_object_catalog
# The 'where' condition in order to limit product catalog
silver_econtent.default.filter_SQL_where:
# A catalog segmentation code used for this SiteAccess
silver_econtent.default.catalog_filter_default_catalogcode:
```

## Root node

Make sure your root node in the `save_object` table has this ID:

```
silver_econtent.default.root_node_id: 2
```

```
Example:
  
node_id class_id    parent_id   change_date blocked hidden  priority    section url_alias   path_string depth   main_node_id
2   1   0   NULL    0   0   1   1   Highlite    /2/ 1   2
```

## Navigation

`contentTypes` is the ID specified in `sve_class`. In the following example 1 is for product groups and 2 is for products.
`limit` is the amount to show in navigation service.

``` yaml
#navigation configuration
silver_eshop.default.econtent_catalog_data_provider.filter:
    navigation:
    contentTypes: 1
        limit: 20
```

## Factory configuration

Definition for the methods that create a catalog node:

```
#configuration for the factory
silver_eshop.default.econtent_catalog_factory.product_group: createCatalogNode
silver_eshop.default.econtent_catalog_factory.product: createOrderableProductNode
```

## SKU

This is the definition for the field that is used for SKU.
It is required for building the catalog element and is linked to `sve_class_attributes.attribute_id`.

``` yaml
silver_econtent.default.sku_id: 202
```

```
attribute_id    class_id    attribute_name  ezdatatype  sort_field
202 2   ses_sku ezstring    data_text
```

## Class ID

This specifies the ID of product group elements found in `se_class.class_id`:

``` yaml
silver_econtent.default.class_id_catalog: 1
```

```
class_id    class_name  name_identifier
1   product_group   101
```

## Content extraction

The following configuration defines how content is extracted from product groups:

```yaml
silver_econtent.default.mapping.product_group:
    identifier:
    id: "node_id"
    extract: false
        parentElementIdentifier:
    id: "parent_id"
    extract: false
        url:
    id: "url_alias"
    extract: false
        name:
    id: "ses_name"
    extract: "extractText"
    text:
    id: "text"
    extract: "extractText"
    image:
    id: "image"
    extract: "extractImage"
```

The following configuration defines how content is extracted from products.

It specifies the method used to extract the value. If it is false, the value is extracted directly from the database.

### Image

The image path to the product image should be relative to `web/var/assets/product_images`
(the path is stored in the `silver_eshop.default.catalog_factory.assets` setting).

Specification data:

Specification data has to be stored in a JSON-formatted (type `ezstring`) example (one group "technic" is used).

```
{
  "technic": [
    {
      "label": "Größe",
      "value": "1,69 cm (0.667 Zoll)"
    },
    {
      "label": "Kompatibilität",
      "value": "Epson Stylus Pro 9600, "
    }
  ]
}
```

Important: current the identifier in eContent has to be named `ses_specification`.

The attributes of the specification data are indexed in Solr as well.

``` yaml
silver_econtent.default.mapping.product:
    identifier:
        id: "node_id"
        extract: false
    parentElementIdentifier:
        id: "parent_id"
        extract: false
    url:
        id: "url_alias"
        extract: false
    sku:
        id: "ses_sku"
        extract: "extractText"
    manufacturerSku:
        id: "ses_manufacturer_sku"
        extract: "extractText"
    name:
        id: "ses_name"
        extract: "extractText"
    ean:
        id: "ses_ean"
        extract: "extractText"
    text:
        id: "ses_subtitle"
        extract: "extractText"
    subtitle:
        id: "ses_subtitle"
        extract: "extractText"
    image:
        id: "ses_image_main"
        extract: "extractImage"
    shortDescription:
        id: "ses_short_description"
        extract: "extractTextBlock"
    longDescription:
        id: "ses_long_description"
        extract: "extractTextBlock"
    price:
        id: "ses_unit_price"
        extract: "extractPrice"
    cacheIdentifier:
        id: "ses_sku"
        extract: "extractCacheIdentifier"
```

## Field prefix

This definition is used by this plugin: `SisoNavEcontentImporterPlugin`

It defines the prefix of the field name that Fields from [[= product_name =]] have in eContent.

``` yaml
silver_econtent.default.ez_datatype_attribute_prefix: ezdata_
```

## Data from an external data source

For every catalog element `EcontentCatalogFactory` collects all information from the `ses_externaldata` table for the given SKU. The SKU is taken from the `data_text` column in `sve_object_attributes` table. It collects different data like PIM, SAP and TYP codes. Then it matches the external data with catalog element attributes and also puts all data in `dataMap`.

Configuration for `externalDataTypes` is used for searching different content in the `externalData` table.

``` yaml
silver_econtent.default.externalDataType:
    pim:
        identifier: pim
    sap:
        identifier: sap
    typ:
        identifier: Typ1
        prefix: TY_
```
