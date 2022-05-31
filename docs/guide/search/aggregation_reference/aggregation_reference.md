# Aggregation reference

[Aggregation](../../../api/public_php_api_search.md#aggregation) is used to group search results into categories.

There are three types of aggregations:

- Term aggregations group by value and count object in each group
- Range aggregations count values in specified ranges
- Stats aggregations compute stats over numeric fields: minimum, average and maximum value, count and sum of values

## Content aggregations

|Name | Type | Based on|
|---|---|---|
|[ContentTypeTermAggregation](contenttypeterm_aggregation.md) | Term | Content Type  |
|[ContentTypeGroupTermAggregation](contenttypegroupterm_aggregation.md) | Term | Content Type group |
|[DateMetadataRangeAggregation](datemetadatarange_aggregation.md) | Range | Date metadata |
|[LocationChildrenTermAggregation](locationchildrenterm_aggregation.md) | Term | Children on a Location |
|[LanguageTermAggregation](languageterm_aggregation.md) | Term | Content language |
|[ObjectStateTermAggregation](objectstateterm_aggregation.md) | Term | Object state |
|[RawRangeAggregation](rawrange_aggregation.md) | Range | Search index field |
|[RawStatsAggregation](rawstats_aggregation.md) | Stats | Search index field |
|[RawTermAggregation](rawterm_aggregation.md) | Term | Search index field |
|[SectionTermAggregation](sectionterm_aggregation.md) | Term | Section |
|[SubtreeTermAggregation](subtreeterm_aggregation.md) | Term | Location subtree path |
|[UserMetadataTermAggregation](usermetadataterm_aggregation.md) | Term | Content owner/owner group or modifier |
|[VisibilityTermAggregation](visibilityterm_aggregation.md) | Term | Content/Location visibility |

## Field aggregations

|Name | Type | Based on Field|
|---|---|---|
|[AuthorTermAggregation](authorterm_aggregation.md) | Term | [Author](../../../api/field_types_reference/authorfield.md) |
|[CheckboxTermAggregation](checkboxterm_aggregation.md) | Term |[Checkbox](../../../api/field_types_reference/checkboxfield.md)|
|[CountryTermAggregation](countryterm_aggregation.md) | Term |[Country](../../../api/field_types_reference/countryfield.md)|
|[DateRangeAggregation](daterange_aggregation.md) | Range |[Date](../../../api/field_types_reference/datefield.md)|
|[DateTimeRangeAggregation](datetimerange_aggregation.md) | Range |[DateTime](../../../api/field_types_reference/dateandtimefield.md)|
|[FloatRangeAggregation](floatrange_aggregation.md) | Range |[Float](../../../api/field_types_reference/floatfield.md)|
|[FloatStatsAggregation](floatstats_aggregation.md) | Stats |[Float](../../../api/field_types_reference/floatfield.md)|
|[IntegerRangeAggregation](integerrange_aggregation.md) | Range |[Integer](../../../api/field_types_reference/integerfield.md)|
|[IntegerStatsAggregation](integerstats_aggregation.md) | Stats |[Integer](../../../api/field_types_reference/integerfield.md)|
|[KeywordTermAggregation](keywordterm_aggregation.md) | Term |[Keyword](../../../api/field_types_reference/keywordfield.md)|
|[SelectionTermAggregation](selectionterm_aggregation.md) | Term |[Selection](../../../api/field_types_reference/selectionfield.md)|
|[TimeRangeAggregation](timerange_aggregation.md) | Range |[Time](../../../api/field_types_reference/timefield.md)|
