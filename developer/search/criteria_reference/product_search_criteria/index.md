# Product Search Criteria reference

Product Search Criteria

Product Search Criteria are supported by [product and product variant search](../../../product_catalog/product_api/index.md#products) with the following methods:

- `ProductServiceInterface::findProducts()`
- `ProductServiceInterface::findProductVariants()`
- `ProductServiceInterface::findVariants()`

Search Criterion let you filter product by specific attributes, for example, color, availability, or price.

## Product Search Criteria

To query for products coming from Quable PIM, see [Quable Search API](../../../product_catalog/quable/quable_api/index.md#search-for-products) for details about the integration.

| Search Criterion                                                                                                                              | Search based on                                                        | Local product catalog | Quable PIM |
| --------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- | --------------------- | ---------- |
| [AttributeGroupIdentifier](../attributegroupidentifier_criterion/index.md)                 | Value of product's attribute group identifier                          | Yes                   |            |
| [AttributeName](../attributename_criterion/index.md)                                       | Value of product's attribute name                                      | Yes                   |            |
| [BasePrice](../baseprice_criterion/index.md)                                               | Product's base price                                                   | Yes                   |            |
| [CatalogIdentifier](../catalogidentifier_criterion/index.md)                               | Catalog's identifier                                                   | Yes                   |            |
| [CatalogName](../catalogname_criterion/index.md)                                           | Catalog's name                                                         | Yes                   |            |
| [CatalogStatus](../catalogstatus_criterion/index.md)                                       | Catalog's status                                                       | Yes                   |            |
| [CheckboxAttribute](../checkboxattribute_criterion/index.md)                               | Value of product's checkbox attribute                                  | Yes                   |            |
| [ColorAttribute](../colorattribute_criterion/index.md)                                     | Value of product's color attribute                                     | Yes                   |            |
| [CreatedAt](../createdat_criterion/index.md)                                               | Date and time when product was created                                 | Yes                   | Yes        |
| [CreatedAtRange](../createdatrange_criterion/index.md)                                     | Date and time range when product was created                           | Yes                   |            |
| [CustomPrice](../customprice_criterion/index.md)                                           | Product's custom price                                                 | Yes                   |            |
| [DateTimeAttribute](../datetimeattribute_criterion/index.md)                               | Value of product's date and time attribute                             | Yes                   |            |
| [DateTimeAttributeRange](../datetimeattributerange_criterion/index.md)                     | Value of product's date and time attribute and given time range        | Yes                   |            |
| [FloatAttribute](../floatattribute_criterion/index.md)                                     | Value of product's float attribute                                     | Yes                   |            |
| [FloatAttributeRange](../floatattributerange_criterion/index.md)                           | Value of product's float attribute                                     | Yes                   |            |
| [IntegerAttribute](../integerattribute_criterion/index.md)                                 | Value of product's integer attribute                                   | Yes                   |            |
| [IntegerAttributeRange](../integerattributerange_criterion/index.md)                       | Value of product's integer attribute                                   | Yes                   |            |
| [IsVirtual](../isvirtual_criterion/index.md)                                               | Product type (virtual or physical)                                     | Yes                   |            |
| [LogicalAnd](../logicaland_criterion/index.md)                                             | Composite criterion to group multiple criteria using the AND condition | Yes                   | Yes        |
| [LogicalOr](../logicalor_criterion/index.md)                                               | Composite criterion to group multiple criteria using the OR condition  | Yes                   |            |
| [MatchAll](../matchall_criterion/index.md)                                                 | All products                                                           | Yes                   | Yes        |
| [ProductAvailability](../productavailability_criterion/index.md)                           | Product's availability                                                 | Yes                   |            |
| [ProductCategory](../productcategory_criterion/index.md)                                   | Product category assigned to product                                   | Yes                   | Yes        |
| [ProductCategorySubtree](../productcategorysubtree_criterion/index.md)                     | Product category subtree assigned to product                           | Yes                   | Yes        |
| [ProductCode](../productcode_criterion/index.md)                                           | Product's code                                                         | Yes                   | Yes        |
| [ProductName](../productname_criterion/index.md)                                           | Product's name                                                         | Yes                   | Yes        |
| [ProductStock](../productstock_criterion/index.md)                                         | Product's numerical stock                                              | Yes                   |            |
| [ProductStockRange](../productstockrange_criterion/index.md)                               | Product's numerical stock                                              | Yes                   |            |
| [ProductType](../producttype_criterion/index.md)                                           | Product type                                                           | Yes                   | Yes        |
| [RangeMeasurementAttributeMaximum](../rangemeasurementattributemaximum_criterion/index.md) | Maximum value of product's measurement range attribute                 | Yes                   |            |
| [RangeMeasurementAttributeMinimum](../rangemeasurementattributeminimum_criterion/index.md) | Minimum value of product's measurement range attribute                 | Yes                   |            |
| [SelectionAttribute](../selectionattribute_criterion/index.md)                             | Value of product's selection attribute                                 | Yes                   |            |
| [SimpleMeasurementAttribute](../simplemeasurementattribute_criterion/index.md)             | Value of product's single measurement attribute                        | Yes                   |            |
| [SymbolAttribute](../symbolattribute_criterion/index.md)                                   | Value of product's symbol attribute                                    | Yes                   |            |
| [UpdatedAt](../updated_at_criterion/index.md)                                              | Product modification date                                              | Yes                   | Yes        |
| [UpdatedAtRange](../updated_at_range_criterion/index.md)                                   | Product modification date range                                        | Yes                   |            |
