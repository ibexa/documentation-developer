# eContent Back Office [[% include 'snippets/commerce_badge.md' %]]

You can see an overview of the data model in **Control center** -> **eContent**.

The model itself has to be defined by a developer (using SQL). The tab **eContent types** shows an overview about:

- defined eContent types (e.g. `product_group`, `product`)
- the list of attributes per eContent type

For each eContent Field Type the list of attributes is displayed:

- Name: identifier of this attribute
- ID: internal unique ID
- Type
- Mapping: shows where the field can be found when using the `CatalogElement`.
The mapping is defined in a yml file: `silver_econtent.default.mapping.product`
(For more information, see [econtent - Configuration](../econtent_configuration.md)).
