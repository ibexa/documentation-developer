# eContent FAQ [[% include 'snippets/commerce_badge.md' %]]

## After using eContent the top navigation is empty

Check your data inside eContent.

Make sure that for all objects the attribute which is defined as `name_identifier` in `sve_class` is stored in `sve_object_attributes`

``` sql
select * from sve_class;
+----------+---------------+-----------------+
| class_id | class_name    | name_identifier |
+----------+---------------+-----------------+
|        1 | product_group |             101 |
|        2 | product       |             205 |
+----------+---------------+-----------------+
 
 select * from sve_object_attributes where node_id=1003;
+---------+--------------+----------+------------+----------+--------------------------------------------+
| node_id | attribute_id | language | data_float | data_int | data_text                                  |
+---------+--------------+----------+------------+----------+--------------------------------------------+
|    1003 |          202 | ger-DE   |       NULL |     NULL | 80810                                      |
|    1003 |          205 | ger-DE   |       NULL |     NULL | Projection Bulb EFP GZ6.35 Philips12V 100W |
|    1003 |          209 | ger-DE   |       13.5 |     NULL | NULL                                       |
+---------+--------------+----------+------------+----------+--------------------------------------------+
```

Check if the root element also has at least this data inside the `sve_object_attributes` table:

``` sql
select * from sve_object_attributes where node_id=2;
+---------+--------------+----------+------------+----------+-----------+
| node_id | attribute_id | language | data_float | data_int | data_text |
+---------+--------------+----------+------------+----------+-----------+
|       2 |          101 | ger-DE   |       NULL |     NULL | Produkte  |
+---------+--------------+----------+------------+----------+-----------+
```

Check if the correct class ID is set in the configuration:

- check if the `types` setting contains the correct `class_id` used in eContent for `product_groups`. It is usually 1
- check if the fields used for the labels are set: `label_fields`

``` yaml
siso_core.default.navigation.catalog:
    #the class id has to be specified here
    types: ['1']
    sections: [1, 2]
    enable_priority_zero: true
    label_fields: ['ses_category_ses_name_value_s','name_s']
    additional_fields: ['ses_category_ses_code_value_s', 'ses_category_ses_name_value_s' ]
```

Check if the field mapping is correct (the same has to be done for products: `silver_econtent.default.mapping.product`):

``` yaml
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
        id: "name"
        extract: "extractText"
```

## Products are not displayed in the detail page

Make sure that the main attributes are defined:

- `name_identifier`
- `ses_sku`
- `ses_price`

## The search says products have been found but none are displayed

Check if you have issues while building the catalog elements.

In dev environment, exceptions are logged to `silver.eshop.log`.

## How can I improve the speed of getting a product by SKU?

Doctrine does not allow creating an index based on a part of a string.
This is why it can be helpful to setup an index manually:

``` 
create index ind_datatext  on sve_object_attributes (data_text(20));
create index ind_datatext  on sve_object_attributes_tmp (data_text(20));
```

This example assumes that the SKU has a maximum length of 20, which should be fine for almost all projects.

## Facets are lowercased

If facet names are lowercase, you need to set the `index_facet_fields` parameter for the specific fields which should not be lowercase.
See [Indexing econtent data](econtent_features/indexing_econtent_data/indexing_econtent_data.md).
