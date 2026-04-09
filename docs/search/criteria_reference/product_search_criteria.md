---
description: Product Search Criteria
page_type: reference
month_change: true
---

# Product Search Criteria reference

Product Search Criteria are supported by [product and product variant search](product_api.md#products) with the following methods:

- `ProductServiceInterface::findProducts()`
- `ProductServiceInterface::findProductVariants()`
- `ProductServiceInterface::findVariants()`

Search Criterion let you filter product by specific attributes, for example, color, availability, or price.

## Product Search Criteria

To query for products coming from [[= pim_product_name =]] PIM, see [[[= pim_product_name =]] Search API](/product_catalog/quable/quable_api.md#search-for-products) for details about the integration.

|Search Criterion|Search based on|Local product catalog|[[= pim_product_name =]] PIM|
|-----|-----|-----|-----|
|[AttributeGroupIdentifier](attributegroupidentifier_criterion.md)|Value of product's attribute group identifier| &#10004;| |
|[AttributeName](attributename_criterion.md)|Value of product's attribute name| &#10004;| |
|[BasePrice](baseprice_criterion.md)|Product's base price| &#10004;| |
|[CatalogIdentifier](catalogidentifier_criterion.md)|Catalog's identifier| &#10004;| |
|[CatalogName](catalogname_criterion.md)|Catalog's name| &#10004;| |
|[CatalogStatus](catalogstatus_criterion.md)|Catalog's status| &#10004;| |
|[CheckboxAttribute](checkboxattribute_criterion.md)|Value of product's checkbox attribute| &#10004;| |
|[ColorAttribute](colorattribute_criterion.md)|Value of product's color attribute| &#10004;| |
|[CreatedAt](createdat_criterion.md)|Date and time when product was created| &#10004;| &#10004;|
|[CreatedAtRange](createdatrange_criterion.md)|Date and time range when product was created| &#10004;| |
|[CustomPrice](customprice_criterion.md)|Product's custom price| &#10004;| |
|[DateTimeAttribute](datetimeattribute_criterion.md)|Value of product's date and time attribute| &#10004;| |
|[DateTimeAttributeRange](datetimeattributerange_criterion.md)|Value of product's date and time attribute and given time range| &#10004;| |
|[FloatAttribute](floatattribute_criterion.md)|Value of product's float attribute| &#10004;| |
|[FloatAttributeRange](floatattributerange_criterion.md)|Value of product's float attribute| &#10004;| |
|[IntegerAttribute](integerattribute_criterion.md)|Value of product's integer attribute| &#10004;| |
|[IntegerAttributeRange](integerattributerange_criterion.md)|Value of product's integer attribute| &#10004;| |
|[IsVirtual](isvirtual_criterion.md)|Product type (virtual or physical)| &#10004;| |
|[LogicalAnd](logicaland_criterion.md)|Composite criterion to group multiple criteria using the AND condition| &#10004;| &#10004;|
|[LogicalOr](logicalor_criterion.md)|Composite criterion to group multiple criteria using the OR condition| &#10004;|[Partially supported](quable_api.md#search-for-products)|
|[MatchAll](matchall_criterion.md)|All products| &#10004;| &#10004;|
|[ProductAvailability](productavailability_criterion.md)|Product's availability| &#10004;| |
|[ProductCategory](productcategory_criterion.md)|Product category assigned to product| &#10004;| &#10004;|
|[ProductCategorySubtree](productcategorysubtree_criterion.md)|Product category subtree assigned to product| &#10004;| &#10004;|
|[ProductCode](productcode_criterion.md)|Product's code| &#10004;| &#10004;|
|[ProductName](productname_criterion.md)|Product's name| &#10004;| &#10004;|
|[ProductStock](productstock_criterion.md)|Product's numerical stock| &#10004;| |
|[ProductStockRange](productstockrange_criterion.md)|Product's numerical stock| &#10004;| |
|[ProductType](producttype_criterion.md)|Product type| &#10004;| &#10004;|
|[RangeMeasurementAttributeMaximum](rangemeasurementattributemaximum_criterion.md)|Maximum value of product's measurement attribute| &#10004;| |
|[RangeMeasurementAttributeMinimum](rangemeasurementattributeminimum_criterion.md)|Minimum value of product's measurement attribute| &#10004;| |
|[SelectionAttribute](selectionattribute_criterion.md)|Value of product's selection attribute| &#10004;| |
|[SimpleMeasurementAttribute](simplemeasurementattribute_criterion.md)|Value of product's measurement attribute| &#10004;| |
|[SymbolAttribute](symbolattribute_criterion.md)|Value of product's symbol attribute| &#10004;| |
|[UpdatedAt](updated_at_criterion.md)|Product modification date| &#10004;| &#10004;|
|[UpdatedAtRange](updated_at_range_criterion.md)|Product modification date range| &#10004;| |
