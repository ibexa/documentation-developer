# Aggregation reference

Aggregations help fine-tune search for content and Locations by grouping results into categories.

[Aggregation](../../search_api/index.md#aggregation) is used to group search results into categories.

There are three types of aggregations:

- Term aggregations group by value and count object in each group
- Range aggregations count values in specified ranges
- Stats aggregations compute stats over numeric fields: minimum, average and maximum value, count, and sum of values

> **Tip: Tip**
>
> Aggregations aren't available in the Legacy Search engine.

## Content aggregations

| Name                                                                                                                                  | Type  | Based on                              |
| ------------------------------------------------------------------------------------------------------------------------------------- | ----- | ------------------------------------- |
| [ContentTypeTermAggregation](../contenttypeterm_aggregation/index.md)           | Term  | Content type                          |
| [ContentTypeGroupTermAggregation](../contenttypegroupterm_aggregation/index.md) | Term  | Content type group                    |
| [DateMetadataRangeAggregation](../datemetadatarange_aggregation/index.md)       | Range | Date metadata                         |
| [LanguageTermAggregation](../languageterm_aggregation/index.md)                 | Term  | Content language                      |
| [LocationChildrenTermAggregation](../locationchildrenterm_aggregation/index.md) | Term  | Children on a Location                |
| [ObjectStateTermAggregation](../objectstateterm_aggregation/index.md)           | Term  | Object state                          |
| [RawRangeAggregation](../rawrange_aggregation/index.md)                         | Range | Search index field                    |
| [RawStatsAggregation](../rawstats_aggregation/index.md)                         | Stats | Search index field                    |
| [RawTermAggregation](../rawterm_aggregation/index.md)                           | Term  | Search index field                    |
| [SectionTermAggregation](../sectionterm_aggregation/index.md)                   | Term  | Section                               |
| [SubtreeTermAggregation](../subtreeterm_aggregation/index.md)                   | Term  | Location subtree path                 |
| [TaxonomyEntryIdAggregation](../taxonomyentryid_aggregation/index.md)           | Term  | Taxonomy entry                        |
| [UserMetadataTermAggregation](../usermetadataterm_aggregation/index.md)         | Term  | Content owner/owner group or modifier |
| [VisibilityTermAggregation](../visibilityterm_aggregation/index.md)             | Term  | Content/Location visibility           |

## Field aggregations

| Name                                                                                                                    | Type  | Based on field                                                                                                        |
| ----------------------------------------------------------------------------------------------------------------------- | ----- | --------------------------------------------------------------------------------------------------------------------- |
| [AuthorTermAggregation](../authorterm_aggregation/index.md)       | Term  | [Author](../../../content_management/field_types/field_type_reference/authorfield/index.md)        |
| [CheckboxTermAggregation](../checkboxterm_aggregation/index.md)   | Term  | [Checkbox](../../../content_management/field_types/field_type_reference/checkboxfield/index.md)    |
| [CountryTermAggregation](../countryterm_aggregation/index.md)     | Term  | [Country](../../../content_management/field_types/field_type_reference/countryfield/index.md)      |
| [DateRangeAggregation](../daterange_aggregation/index.md)         | Range | [Date](../../../content_management/field_types/field_type_reference/datefield/index.md)            |
| [DateTimeRangeAggregation](../datetimerange_aggregation/index.md) | Range | [DateTime](../../../content_management/field_types/field_type_reference/dateandtimefield/index.md) |
| [FloatRangeAggregation](../floatrange_aggregation/index.md)       | Range | [Float](../../../content_management/field_types/field_type_reference/floatfield/index.md)          |
| [FloatStatsAggregation](../floatstats_aggregation/index.md)       | Stats | [Float](../../../content_management/field_types/field_type_reference/floatfield/index.md)          |
| [IntegerRangeAggregation](../integerrange_aggregation/index.md)   | Range | [Integer](../../../content_management/field_types/field_type_reference/integerfield/index.md)      |
| [IntegerStatsAggregation](../integerstats_aggregation/index.md)   | Stats | [Integer](../../../content_management/field_types/field_type_reference/integerfield/index.md)      |
| [KeywordTermAggregation](../keywordterm_aggregation/index.md)     | Term  | [Keyword](../../../content_management/field_types/field_type_reference/keywordfield/index.md)      |
| [SelectionTermAggregation](../selectionterm_aggregation/index.md) | Term  | [Selection](../../../content_management/field_types/field_type_reference/selectionfield/index.md)  |
| [TimeRangeAggregation](../timerange_aggregation/index.md)         | Range | [Time](../../../content_management/field_types/field_type_reference/timefield/index.md)            |

## Product aggregations

| Name                                                                                                                             | Type         | Based on                 |
| -------------------------------------------------------------------------------------------------------------------------------- | ------------ | ------------------------ |
| [Product attribute](../product_attribute_aggregations/index.md)            | Term / Range | Product attribute values |
| [BasePriceStats](../basepricestats_aggregation/index.md)                   | Stats        | Product base price       |
| [CustomPriceStats](../custompricestats_aggregation/index.md)               | Stats        | Product custom price     |
| [ProductAvailabilityTerm](../productavailabilityterm_aggregation/index.md) | Term         | Product availability     |
| [ProductStockRange](../productstockrange_aggregation/index.md)             | Range        | Product stock            |
| [ProductPriceRange](../productpricerange_aggregation/index.md)             | Range        | Product price            |
| [ProductTypeTerm](../producttypeterm_aggregation/index.md)                 | Term         | Product type             |
| [TaxonomyEntryIdAggregation](../taxonomyentryid_aggregation/index.md)      | Term         | Product category         |
