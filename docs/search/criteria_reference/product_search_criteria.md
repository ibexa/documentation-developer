---
description: Product Search Criteria
page_type: reference
month_change: false
---

# Product Search Criteria reference

Product Search Criteria let you filter products by specific properties, for example, color, availability, or creation date.

You use them over the REST API, in the `Filter` or `Query` element of the payload of the
[`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request,
or of the [`POST /product/catalog/catalogs/{identifier}/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Catalog/operation/ibexa.product_catalog.rest.catalogs.products.view) request, which searches within a single catalog.
In the payload, the name of a Criterion has the `Criterion` suffix, for example, `ProductCodeCriterion`.
Criteria that you provide in one `Filter` or `Query` element are combined with a logical AND.

Products are content items, so you can also find them with a content search,
by using the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request with, for example, the
[ContentTypeIdentifier](contenttypeidentifier_criterion.md) Criterion.
Such a search returns content items instead of products, and it doesn't accept Product Search Criteria.
In the same way, the product endpoints don't accept [content Search Criteria](search_criteria_reference.md).

Catalog Criteria (`CatalogIdentifier`, `CatalogName`, and `CatalogStatus`) are used with the
[`POST /product/catalog/catalogs/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Catalog/operation/ibexa.product_catalog.rest.catalogs.view) request,
and attribute definition Criteria (`AttributeName` and `AttributeGroupIdentifier`) with the
[`POST /product/catalog/attributes/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Attribute/operation/ibexa.product_catalog.rest.attributes.view) request.

## Product Search Criteria

To query for products coming from [[= pim_product_name =]], see [[[= pim_product_name =]]](../../product_catalog/quable/quable.md) for details about the integration.

|Search Criterion|Search based on|Local product catalog|[[= pim_product_name =]]|
|-----|-----|-----|-----|
|[AttributeGroupIdentifier](attributegroupidentifier_criterion.md)|Value of product's attribute group identifier| &#10004;| |
|[AttributeName](attributename_criterion.md)|Value of product's attribute name| &#10004;| |
|[CatalogIdentifier](catalogidentifier_criterion.md)|Catalog's identifier| &#10004;| |
|[CatalogName](catalogname_criterion.md)|Catalog's name| &#10004;| |
|[CatalogStatus](catalogstatus_criterion.md)|Catalog's status| &#10004;| |
|[ColorAttribute](colorattribute_criterion.md)|Value of product's color attribute| &#10004;| |
|[CreatedAt](createdat_criterion.md)|Date and time when product was created| &#10004;| &#10004;|
|[CreatedAtRange](createdatrange_criterion.md)|Date and time range when product was created| &#10004;| |
|[FloatAttribute](floatattribute_criterion.md)|Value of product's float attribute| &#10004;| |
|[FloatAttributeRange](floatattributerange_criterion.md)|Value of product's float attribute| &#10004;| |
|[IntegerAttribute](integerattribute_criterion.md)|Value of product's integer attribute| &#10004;| |
|[IntegerAttributeRange](integerattributerange_criterion.md)|Value of product's integer attribute| &#10004;| |
|[IsVirtual](isvirtual_criterion.md)|Product type (virtual or physical)| &#10004;| |
|[ProductAvailability](productavailability_criterion.md)|Product's availability| &#10004;| |
|[ProductCategory](productcategory_criterion.md)|Product category assigned to product| &#10004;| &#10004;|
|[ProductCode](productcode_criterion.md)|Product's code| &#10004;| &#10004;|
|[ProductName](productname_criterion.md)|Product's name| &#10004;| &#10004;|
|[ProductType](producttype_criterion.md)|Product type| &#10004;| &#10004;|
|[SelectionAttribute](selectionattribute_criterion.md)|Value of product's selection attribute| &#10004;| |
|[UpdatedAt](updated_at_criterion.md)|Product modification date| &#10004;| &#10004;|
|[UpdatedAtRange](updated_at_range_criterion.md)|Product modification date range| &#10004;| |
