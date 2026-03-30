---
description: Product Search Criteria
page_type: reference
---

# Product Search Criteria reference

Product Search Criteria are supported by [product and product variant search](product_api.md#products) with the following methods:

- `ProductServiceInterface::findProducts()`
- `ProductServiceInterface::findProductVariants()`
- `ProductServiceInterface::findVariants()`

Search Criterion let you filter product by specific attributes, for example, color, availability, or price.

## Product Search Criteria

To [query for products coming from [[= pim_product_name =]] PIM](quable_api.md#search-for-products), see the list below for search criteria supported by this integration.

|Search Criterion|Search based on| Supported by [[= pim_product_name =]] PIM |
|-----|-----|----|
|[AttributeGroupIdentifier](attributegroupidentifier_criterion.md)|Value of product's attribute group identifier| |
|[AttributeName](attributename_criterion.md)|Value of product's attribute name| |
|[BasePrice](baseprice_criterion.md)|Product's base price| |
|[CatalogIdentifier](catalogidentifier_criterion.md)|Catalog's identifier| |
|[CatalogName](catalogname_criterion.md)|Catalog's name| |
|[CatalogStatus](catalogstatus_criterion.md)|Catalog's status| |
|[CheckboxAttribute](checkboxattribute_criterion.md)|Value of product's checkbox attribute| |
|[ColorAttribute](colorattribute_criterion.md)|Value of product's color attribute| |
|[CreatedAt](createdat_criterion.md)|Date and time when product was created| &#10004; |
|[CreatedAtRange](createdatrange_criterion.md)|Date and time range when product was created| |
|[LogicalAnd](logicaland_criterion.md)|Composite criterion to group multiple criteria using the AND condition | &#10004; |
|[LogicalOr](logicalor_criterion.md)|Composite criterion to group multiple criteria using the OR condition | Supported only when a pair of criteria is given: ProductCode followed by ProductName |
|[CustomPrice](customprice_criterion.md)|Product's custom price| |
|[DateTimeAttribute](datetimeattribute_criterion.md)|Value of product's date and time attribute| |
|[DateTimeAttributeRange](datetimeattributerange_criterion.md)|Value of product's date and time attribute and given time range| |
|[FloatAttribute](floatattribute_criterion.md)|Value of product's float attribute| |
|[FloatAttributeRange](floatattributerange_criterion.md)|Value of product's float attribute| |
|[IntegerAttribute](integerattribute_criterion.md)|Value of product's integer attribute| |
|[IntegerAttributeRange](integerattributerange_criterion.md)|Value of product's integer attribute| |
|[IsVirtual](isvirtual_criterion.md)|Product type (virtual or physical)| |
|[ProductAvailability](productavailability_criterion.md)|Product's availability| |
|[UpdatedAt](updatedat_criterion.md)|Product modification date|  &#10004; |
|[ProductCategory](productcategory_criterion.md)|Product category assigned to product| &#10004; |
|[ProductCategorySubtree](productcategorysubtree_criterion.md)|Product category subtree assigned to product| &#10004; |
|[MatchAll](matchall_criterion.md)|All products| &#10004; |
|[ProductCode](productcode_criterion.md)|Product's code| &#10004; |
|[ProductName](productname_criterion.md)|Product's name| &#10004; |
|[ProductStock](productstock_criterion.md)|Product's numerical stock| |
|[ProductStockRange](productstockrange_criterion.md)|Product's numerical stock| |
|[ProductType](producttype_criterion.md)|Product type| &#10004; |
|[RangeMeasurementAttributeMaximum](rangemeasurementattributemaximum_criterion.md)|Maximum value of product's measurement attribute| |
|[RangeMeasurementAttributeMinimum](rangemeasurementattributeminimum_criterion.md)|Minimum value of product's measurement attribute| |
|[SelectionAttribute](selectionattribute_criterion.md)|Value of product's selection attribute| |
|[SimpleMeasurementAttribute](simplemeasurementattribute_criterion.md)|Value of product's measurement attribute| |
|[SymbolAttribute](symbolattribute_criterion.md)|Value of product's symbol attribute| |
