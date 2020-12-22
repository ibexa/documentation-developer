# Importing and indexing data (SQL) [[% include 'snippets/commerce_badge.md' %]]

## Query examples

These queries can be useful for testing imported data or debugging.

``` sql
/* Get all elements with all tables joined: */
SELECT
    * 
FROM
    sve_object 
JOIN
    sve_object_attributes ON ( sve_object.node_id = sve_object_attributes.node_id ) 
JOIN
    sve_class_attributes ON ( sve_object_attributes.attribute_id = sve_class_attributes.attribute_id );
 
/* Get all products */
SELECT
    * 
FROM
    sve_object 
JOIN
    sve_object_attributes ON ( sve_object.node_id = sve_object_attributes.node_id ) 
JOIN
    sve_class_attributes ON ( sve_object_attributes.attribute_id = sve_class_attributes.attribute_id )
WHERE
    sve_object.class_id = 2 /* Class id 2 is for products */;
 
/* Get all product groups */
SELECT
    * 
FROM
    sve_object 
JOIN
    sve_object_attributes ON ( sve_object.node_id = sve_object_attributes.node_id ) 
JOIN
    sve_class_attributes ON ( sve_object_attributes.attribute_id = sve_class_attributes.attribute_id )
WHERE
    sve_object.class_id = 1 /* Class id 1 is for product groups*/ ;

/* Get product node ids and names*/
SELECT
    sve_object.node_id,
    sve_object_attributes.data_text
FROM
    sve_object 
JOIN
    sve_object_attributes ON ( sve_object.node_id = sve_object_attributes.node_id ) 
JOIN
    sve_class_attributes ON ( sve_object_attributes.attribute_id = sve_class_attributes.attribute_id )
WHERE
    sve_object.class_id = 2 
AND
    sve_class_attributes.attribute_id = 201
ORDER BY
    sve_object_attributes.data_text;
```

### Import process for eContent

Tables `sve_class` and `sve_class_attributes` have data definitions and `sve_object` and `sve_object_attributes` have the data itself.

`sve_class` and `sve_class_attributes` should be modified only when data definition is changed, for example:

``` sql
/* Insert data in sve_class table */
 
INSERT INTO `sve_class` (`class_id`, `class_name`, `name_identifier`)
VALUES
    (1,'product_group',101),
    (2,'product',201);
 
/* Insert data in sve_class_attributes table */
INSERT INTO `sve_class_attributes` (`attribute_id`, `class_id`, `attribute_name`, `ezdatatype`, `sort_field`)
VALUES
    (101,1,'ses_name','ezstring','data_text'),
    (102,1,'number','ezstring','data_text'),
    (103,1,'code','ezstring','data_text'),
    (201,2,'ses_name','ezstring','data_text'),
    (202,2,'ses_sku','ezstring','data_text'),
    (203,2,'product_sort_field','ezstring','data_text'),
    (204,2,'sub_headline','ezstring','data_text'),
    (205,2,'marker','ezstring','data_text'),
    (206,2,'length','ezfloat','data_float');
 
/* This tables should be modified only when data definition is changed. */
```

An example of importing `sve_object` and `sve_object_attributes` data:

``` sql
/* Insert data in sve_object table */
INSERT INTO `sve_object` (`node_id`, `class_id`, `parent_id`, `change_date`, `blocked`, `hidden`, `priority`, `section`, `url_alias`, `path_string`, `depth`, `main_node_id`)
VALUES
    (2,1,0,NULL,0,0,1,1,'Highlite','/2/',1,2),
    (11,1,2,NULL,0,0,1,1,'Highlite/DMT','/2/11/',2,11),
    (1000001,1,11,NULL,0,0,1,1,'Highlite/DMT/New-Products','/2/11/1000001/',3,1000001),
    (1000101,1,11,NULL,0,0,1,1,'Highlite/DMT/Outlet-Sales','/2/11/1000101/',3,1000101),
    (25290,1,11,NULL,0,0,1,1,'Highlite/DMT/Media-Gear','/2/11/25290/',3,25290),
    (125290,1,25290,NULL,0,0,1,1,'Highlite/DMT/Media-Gear/Screens','/2/11/25290/125290/',4,125290),
    (225290,2,125290,NULL,0,0,1,1,'Highlite/DMT/Media-Gear/Screens/Proscreen-manual','/2/11/25290/125290/225290/',5,225290),
    (225291,2,125290,NULL,0,0,2,1,'Highlite/DMT/Media-Gear/Screens/Proscreen-manual_1','/2/11/25290/125290/225291/',5,225291),
    (220841,2,125290,NULL,0,0,3,1,'Highlite/DMT/Media-Gear/Screens/Projection-Screen-4-3','/2/11/25290/125290/220841/',5,220841),
    (225292,2,125290,NULL,0,0,4,1,'Highlite/DMT/Media-Gear/Screens/Proscreen-manual_2','/2/11/25290/125290/225292/',5,225292),
    (220842,2,125290,NULL,0,0,5,1,'Highlite/DMT/Media-Gear/Screens/Projection-Screen-4-3-Manual','/2/11/25290/125290/220842/',5,220842);
 
/* Insert data in sve_obect_attributes table */
 
INSERT INTO `sve_object_attributes` (`node_id`, `attribute_id`, `data_float`, `data_int`, `data_text`, `language`)
VALUES
    (2,101,NULL,NULL,'Highlite','eng-GB'),
    (11,101,NULL,NULL,'DMT','eng-GB'),
    (11,102,NULL,NULL,'00.10','eng-GB'),
    (11,102,NULL,NULL,'00.10','ger-DE'),
    (1000001,101,NULL,NULL,'Neuheiten','ger-DE'),
    (1000001,101,NULL,NULL,'New Products','eng-GB'),
    (1000001,102,NULL,NULL,'00.00','eng-GB'),
    (1000001,103,NULL,NULL,'NEW','eng-GB'),
    (1000101,101,NULL,NULL,'Auslaufartikel','ger-DE'),
    (1000101,101,NULL,NULL,'Outlet Sales','eng-GB'),
    (1000101,102,NULL,NULL,'ZZZ','eng-GB'),
    (1000101,103,NULL,NULL,'DECLINE','eng-GB'),
    (25290,101,NULL,NULL,'Media Gear','eng-GB'),
    (125290,101,NULL,NULL,'Screens','eng-GB'),
    (125290,102,NULL,NULL,'00.10.020','eng-GB'),
    (125290,102,NULL,NULL,'00.10.020','ger-DE'),
    (225290,201,NULL,NULL,'Proscreen manual','eng-GB'),
    (225290,202,NULL,NULL,'100350','eng-GB'),
    (225290,203,NULL,NULL,'00.10.020/005','eng-GB'),
    (225290,203,NULL,NULL,'00.10.020/005','ger-DE'),
    (225290,204,NULL,NULL,'72\" 4:3','eng-GB'),
    (225290,204,NULL,NULL,'72\" 4:3','ger-DE');
```

Remember to index the products in Solr, see [Staging system](../../econtent_features/staging_system.md) and [Indexing eContent data](../../econtent_features/indexing_econtent_data/indexing_econtent_data.md)

### Import procedure using temp tables

Tables `sve_object` and `sve_object_attributes` have two clone temporary tables called `sve_object_tmp` and `sve_object_attributes_tmp`.
These temporary tables are used to import new data and keep data available while importing by means of the normal tables.
After an import is finished, you can execute a command to rename the temporary tables to normal tables:

``` bash
php bin/console silversolutions:econtent-tables-swap
```

### Languages

The language definitions of eContent elements are defined in `sve_object_attributes`. Every attribute row has a language definition, for example:

|node_id|attribute_id |   data_float | data_int  |  data_text    | language|
|---|---|---|---|---|---|
|1000001|101          |   NULL       | NULL      |  Neuheiten    | ger-DE|
|1000001|101          |   NULL       | NULL      |  New Products | eng-GB|

There is no language hierarchy. Only languages specified in configuration are indexed:

``` yaml
siso_search.default.index_econtent_languages: [ ger-DE, eng-GB ]
```

### eContent Indexer

For information about indexing eContent, see [Indexing econtent data](../../econtent_features/indexing_econtent_data/indexing_econtent_data.md).

For information about creating custom plugins for indexing, see [Custom indexer plugin for eContent](../econtent_search_cookbook/custom_indexer_plugin_for_econtent).

### Data model attributes in eContent

If you need to enrich an eContent site with data from the content model, use a command from the `SisoNavEcontentImporterPlugin` plugin. 
