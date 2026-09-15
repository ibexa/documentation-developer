---
description: Aggregations help fine-tune search for content and Locations by grouping results into categories.
page_type: reference
---

# Aggregation reference

Aggregation is used to group search results into categories.

You use aggregations over the REST API, in the `Aggregations` element of the payload of the
[`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request for content and location search,
or of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request for product search.
The `Aggregations` element takes a list of objects, each of them named after the aggregation to run.

Product search runs as a content search that is limited to products, so you can also use
content aggregations with product search.
Product aggregations, on the other hand, only produce results for products.

There are three types of aggregations:

- Term aggregations group by value and count object in each group
- Range aggregations count values in specified ranges
- Stats aggregations compute stats over numeric fields: minimum, average and maximum value, count, and sum of values

## Content aggregations

|Name | Type | Based on|
|---|---|---|
|[ContentTypeTermAggregation](contenttypeterm_aggregation.md) | Term | Content type  |
|[ContentTypeGroupTermAggregation](contenttypegroupterm_aggregation.md) | Term | Content type group |
|[DateMetadataRangeAggregation](datemetadatarange_aggregation.md) | Range | Date metadata |
|[LanguageTermAggregation](languageterm_aggregation.md) | Term | Content language |
|[LocationChildrenTermAggregation](locationchildrenterm_aggregation.md) | Term | Children on a Location |
|[ObjectStateTermAggregation](objectstateterm_aggregation.md) | Term | Object state |
|[RawRangeAggregation](rawrange_aggregation.md) | Range | Search index field |
|[RawStatsAggregation](rawstats_aggregation.md) | Stats | Search index field |
|[RawTermAggregation](rawterm_aggregation.md) | Term | Search index field |
|[SectionTermAggregation](sectionterm_aggregation.md) | Term | Section |
|[SubtreeTermAggregation](subtreeterm_aggregation.md) | Term | Location subtree path |
|[UserMetadataTermAggregation](usermetadataterm_aggregation.md) | Term | Content owner/owner group or modifier |
|[VisibilityTermAggregation](visibilityterm_aggregation.md) | Term | Content/Location visibility |

## Field aggregations

|Name | Type | Based on field|
|---|---|---|
|[AuthorTermAggregation](authorterm_aggregation.md) | Term | [Author](authorfield.md) |
|[CheckboxTermAggregation](checkboxterm_aggregation.md) | Term |[Checkbox](checkboxfield.md)|
|[CountryTermAggregation](countryterm_aggregation.md) | Term |[Country](countryfield.md)|
|[DateRangeAggregation](daterange_aggregation.md) | Range |[Date](datefield.md)|
|[DateTimeRangeAggregation](datetimerange_aggregation.md) | Range |[DateTime](dateandtimefield.md)|
|[FloatRangeAggregation](floatrange_aggregation.md) | Range |[Float](floatfield.md)|
|[FloatStatsAggregation](floatstats_aggregation.md) | Stats |[Float](floatfield.md)|
|[IntegerRangeAggregation](integerrange_aggregation.md) | Range |[Integer](integerfield.md)|
|[IntegerStatsAggregation](integerstats_aggregation.md) | Stats |[Integer](integerfield.md)|
|[KeywordTermAggregation](keywordterm_aggregation.md) | Term |[Keyword](keywordfield.md)|
|[SelectionTermAggregation](selectionterm_aggregation.md) | Term |[Selection](selectionfield.md)|
|[TimeRangeAggregation](timerange_aggregation.md) | Range |[Time](timefield.md)|

## Product aggregations

|Name | Type | Based on|
|---|---|---|
|[Product attribute](product_attribute_aggregations.md) | Term / Range | Product attribute values |
|[ProductAvailabilityTerm](productavailabilityterm_aggregation.md) | Term | Product availability |
|[ProductStockRange](productstockrange_aggregation.md) | Range | Product stock |
|[ProductPriceRange](productpricerange_aggregation.md) | Range | Product price |
|[ProductTypeTerm](producttypeterm_aggregation.md) | Term | Product type |
