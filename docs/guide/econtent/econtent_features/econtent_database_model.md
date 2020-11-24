# eContent database model [[% include 'snippets/commerce_badge.md' %]]

eContent uses four main database tables and two optional ones:

|Table|Staging|Purpose|
|--- |--- |--- |
|`sve_class`||Stores types of catalog elements (e.g. product, product_group). Each type has an identifier which has a relation with `sve_class_attributes`.|
|`sve_class_attributes`||Stores all possible catalog element attributes (name, type) for different catalog elements (`class_id`).|
|`sve_object`|yes|Stores all catalog elements and general information about them (URL, parent, depth, etc.).|
|`sve_object_attributes`|yes|Stores all attributes for the given catalog element depending on language.|
|`ses_externaldata`||(optional) Stores additional information for `sve_object_attributes` of `ses_externaldata`. Collects more information for that kind of catalog element.|
|`sve_object_catalog`|yes|(optional) Used for segmentation.|

For staging purposes, the database tables use the `_tmp` prefix (e.g. `sve_object_tmp`).
The staging tables can be used to import a complete product catalog without affecting the production catalogue.
For more information, see [eContent staging system](staging_system.md). 

!!! note

    [[= product_name_com =]] uses Doctrine entities to create these tables.

    It is impossible to create indexes for the table `sve_object_attributes` for the `data_text` attribute with Doctrine. You must create the indexes manually every time you run
    `php bin/console doctrine:schema:update --force`

## Metadata for products and product groups

The table `sve_object` contains one entry for each product group, product, etc.
You can arrange data in a tree structure by using the field `parent_id`, which is the Location ID of the parent.
Location IDs start from 2 due to compatibility with the [[= product_name =]] data structure.

This table contains several other pieces of information in addition to Content Type ID and Location ID, for example:

- time of last change
- Location ID of the parent
- flag that indicates whether the item is blocked
- priority
- URL alias - readable URL of this document (for example `/shop/toys/kids/wooden_toy`)
- depth
- main Location ID - if the item has multiple Locations, this parameter defines the first appearance in this tree, where all data referenced to this object is stored

!!! note

    Although tables have relationships, there are no constraints defined in database definition.

### Table `sve_object`

|Field|Type|Null|Key|Default|Extra|
|--- |--- |--- |--- |--- |--- |
|`node_id`|int(10) unsigned||PRI|0||
|`class_id`|int(10) unsigned||MUL|0||
|`parent_id`|int(10) unsigned|||0||
|`change_date`|datetime|YES||NULL||
|`blocked`|tinyint(3) unsigned|||0||
|`priority`|smallint(5) unsigned|||0||
|`section`|tinyint(3) unsigned|||0||
|`url_alias`|text|YES|MUL|NULL||
|`path_string`|varchar(255)|YES|MUL|NULL||
|`depth`|tinyint(3) unsigned|YES||NULL||
|`main_node_id`|int(10) unsigned||MUL|0||
|`hidden`|tinyint(4)|YES||0||

Example:

``` code
mysql > select node_id, class_id, parent_id, blocked, hidden, priority from sve_object limit 1,3;
+---------+----------+-----------+---------+--------+----------+
| node_id | class_id | parent_id | blocked | hidden | priority |
+---------+----------+-----------+---------+--------+----------+
|       3 |        1 |         2 |       0 |      0 |        7 | 
|       4 |        1 |         3 |       0 |      0 |        1 | 
|       5 |        2 |         4 |       0 |      0 |        0 | 
+---------+----------+-----------+---------+--------+----------+

select node_id, url_alias, path_string, depth from sve_object limit 1,3;
+---------+--------------------------------------------------------------------+-------------+-------+
| node_id | url_alias                                                          | path_string | depth |
+---------+--------------------------------------------------------------------+-------------+-------+
|       3 | Produkte/Plakate                                                   | /2/3/       |     2 | 
|       4 | Produkte/Plakate/Motivplakate                                      | /2/3/4/     |     3 | 
|       5 | Produkte/Plakate/Motivplakate/Bildung-macht-Zukunft                | /2/3/4/5/   |     4 | 
+---------+--------------------------------------------------------------------+-------------+-------+
```

## Attributes for products and product groups

You can create multiple data fields for each entry in `sve_object_attributes`.
Each of them can be set in its own language. The language codes follow the ISO-639 standard (for example, 'ger-DE' or 'eng-US'). 

Each entry consists of the following fields:

- `attribute_id` - ID of this attribute (see `sve_class_attributes`)
- `node_id` - internal Location ID
- `data_int`, `data_float`, `data_text` - value of the attribute depending on the data type (see `sve_class_attributes`)

### Table `sve_object_attributes`

|Field|Type|Null|Key|Default|Extra|
|--- |--- |--- |--- |--- |--- |
|`node_id`|int(10) unsigned||PRI|0||
|`attribute_id`|int(10) unsigned||PRI|0||
|`data_float`|float|YES||NULL||
|`data_int`|int(11)|YES||NULL||
|`data_text`|text|YES||NULL||
|`language`|varchar(6)||PRI|ger-DE||

### Table `sve_class`

This table describes all available Content Types. The class fields are defined in `sve_class_attributes`.

|Field|Type|Null|Key|Default|Extra|
|--- |--- |--- |--- |--- |--- |
|`class_id`|int(10) unsigned||PRI|0||
|`class_name`|varchar(255)|YES||NULL||
|`name_identifier`|int(10) unsigned|||0||

### Table `sve_class_attributes`

The table describes the Content Type Fields.

|Field|Type|Null|Key|Default|Extra|
|--- |--- |--- |--- |--- |--- |
|`attribute_id`|int(10) unsigned||PRI|0||
|`class_id`|int(10) unsigned|||0||
|`attribute_name`|varchar(255)|YES||NULL||
|`ezdatatype`|varchar(255)|||||
|`sort_field`|varchar(255)|||data_text||

The following datatypes are supported:

#### ezstring

The data is stored in the `data_text` field as a flat string.

#### ezinteger

The data is stored in the `data_int` field.

#### ezprice

The price information is stored in the `data_float` field. The `data_text` field contains information about the VAT value in percent and a flag that indicates whether the price includes VAT or not.

Example:

``` code
+---------+--------------+------------+----------+-----------+----------+
| node_id | attribute_id | data_float | data_int | data_text | language |
+---------+--------------+------------+----------+-----------+----------+
|       5 |          210 |      0.952 |        0 | 19,1      | ger-DE   | 
+---------+--------------+------------+----------+-----------+----------+
```

In this example, the price is 0.952 EUR (currency is defined per shop), including 19% VAT.

#### ezmatrix

This Content Type enables storing data organized in rows in columns in one field.
It is useful for dynamic attributes.

For example:

``` 
+---------+--------------+------------+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------+
| node_id | attribute_id | data_float | data_int | data_text                                                                                                                                                                                                      | language |
+---------+--------------+------------+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------+
|     249 |          240 |          0 |        0 | <?xml version='1.0' encoding='UTF-8'?><ezmatrix><name></name><columns number='2'><column num='0' id='filename'>Filename</column><column num='1' id='name'>Name</column></columns><rows number='0'/></ezmatrix> | ger-DE   | 
+---------+--------------+------------+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------+
```

- columns: definition of the columns with an ID and a Label
- rows: containing the data by rows and columns. For example, if a table contains two rows and two columns, four `<c>` tags must be generated.

``` xml
<?xml version='1.0' encoding='UTF-8'?>
<ezmatrix>
    <name></name>
    <columns number='2'>
        <column num='0' id='filename'>Filename</column>
        <column num='1' id='name'>Name</column>
    </columns>
    <rows number='1'/>
    <c>test/30ccf286d5c8cf1a3ebb16e75cb0adc4.pdf</c>
    <c>GS60-Montageanleitung.pdf</c>
</ezmatrix> 
```

## Examples

```
# Classes defined for econtent
 
mysql > SELECT * FROM sve_class;
class_id    class_name      name_identifier
1           warengruppe     101 
2           bestellprodukt  201
 
# attributes for the classes 1 and 2
 
mysql > SELECT * FROM sve_class_attributes;
attribute_id    class_id    attribute_name  ezdatatype  sort_field
101             1           name            ezstring    data_text   
102             1           navisionid      ezstring    data_text
201             2           name            ezstring    data_text
202             2           navisionid      ezstring    data_text
203             2           description     ezstring    data_text
204             2           vendor_no       ezstring    data_text
205             2           unit_list_price ezstring    data_text
 
 
# object table 
mysql > SELECT * FROM sve_object; 
node_id class_id    parent_id   change...   blocked priority    section url_alias   path... depth   main...
2   1           0           NULL    0   1           0   shop            /2/ 1   2
3   1           2           NULL    0   1           0   shop/wg         /2/3    2   3
4   2           3           NULL    0   1           0   shop/wg/bsp /2/3/4  3   4
 
 
# attributes
 
SELECT * FROM sve_object_attributes;
node_id attribute_id    data_float  data_int    data_text       language
2   101         NULL            NULL            Shop            ger-DE
2   102         NULL            NULL            FOLDER_ID       ger-DE
3   101         NULL            NULL            Wg              ger-DE
3   102         NULL            NULL            FOLDER_ID       ger-DE
4   201         NULL            NULL            Bsp             ger-DE
4   202         NULL            NULL            ITEM_NO         ger-DE
4   203         NULL            NULL            Beschreibung    ger-DE
4   204         NULL            NULL            019-DA-12       ger-DE
4   205         NULL            NULL            19.95           ger-DE
```

### Table `ses_externaldata`

This table describes all external data from SAP, PIM, TYP, etc. The content is encoded in JSON.
Content Type Fields are defined in `sve_class_attributes`.

|Field|Type|Null|Key|Default|Extra|
|--- |--- |--- |--- |--- |--- |
|`id`|int(10) unsigned||PRI|||
|`sku`|varchar(40)|||||
|`field_id`|varchar(40)|||||
|`language_code`|varchar(8)|||||
|`ses_field_type`|varchar(20)|||||
|`content`|longtext||||json encoded|

Matching external data from `sve_class_attributes` of type `ses_externaldata` is done by `data_text`.
It must match the SKU (e.g. 000000000000167738).
