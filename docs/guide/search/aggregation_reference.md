# Aggregation reference

[Aggregation](../../api/public_php_api_search.md#aggregation) is used to group search results into categories.

There are three types of aggregations:

- Term aggregations group by value and count object in each group
- Range aggregations count values in specified ranges
- Stats aggregations compute stats over numeric fields: minimum, average and maximum value, count and sum of values

## Content aggregations

|Name | Type | Based on|
|---|---|---|
|[ContentTypeTermAggregation](aggregation_reference/contenttypeterm_aggregation.md) | Term | Content Type  |
|[ContentTypeGroupTermAggregation](aggregation_reference/contenttypegroupterm_aggregation.md) | Term | Content Type group |
|[DateMetadataRangeAggregation](aggregation_reference/datemetadatarange_aggregation.md) | Range | Date metadata |
|[LanguageTermAggregation](aggregation_reference/languageterm_aggregation.md) | Term | Content language |
|[ObjectStateTermAggregation](aggregation_reference/objectstateterm_aggregation.md) | Term | Object state |
|[RawRangeAggregation](aggregation_reference/rawrange_aggregation.md) | Range | Search index field |
|[RawStatsAggregation](aggregation_reference/rawstats_aggregation.md) | Stats | Search index field |
|[RawTermAggregation](aggregation_reference/rawterm_aggregation.md) | Term | Search index field |
|[SectionTermAggregation](aggregation_reference/sectionterm_aggregation.md) | Term | Section |
|[SubtreeTermAggregation](aggregation_reference/subtreeterm_aggregation.md) | Term | Location subtree path |
|[UserMetadataTermAggregation](aggregation_reference/usermetadataterm_aggregation.md) | Term | Content owner/owner group or modifier |
|[VisibilityTermAggregation](aggregation_reference/visibilityterm_aggregation.md) | Term | Content/Location visibility |

## Field aggregations

|Name | Type | Based on Field|
|---|---|---|
|[AuthorTermAggregation](aggregation_reference/authorterm_aggregation.md) | Term | [Author](../../api/field_type_reference.md#author-field-type) |
|[CheckboxTermAggregation](aggregation_reference/checkboxterm_aggregation.md) | Term |[Checkbox](../../api/field_type_reference.md#checkbox-field-type)|
|[CountryTermAggregation](aggregation_reference/countryterm_aggregation.md) | Term |[Country](../../api/field_type_reference.md#country-field-type)|
|[DateRangeAggregation](aggregation_reference/daterange_aggregation.md) | Range |[Date](../../api/field_type_reference.md#date-field-type)|
|[DateTimeRangeAggregation](aggregation_reference/datetimerange_aggregation.md) | Range |[DateTime](../../api/field_type_reference.md#dateandtime-field-type)|
|[FloatRangeAggregation](aggregation_reference/floatrange_aggregation.md) | Range |[Float](../../api/field_type_reference.md#float-field-type)|
|[FloatStatsAggregation](aggregation_reference/floatstats_aggregation.md) | Stats |[Float](../../api/field_type_reference.md#float-field-type)|
|[IntegerRangeAggregation](aggregation_reference/integerrange_aggregation.md) | Range |[Integer](../../api/field_type_reference.md#integer-field-type)|
|[IntegerStatsAggregation](aggregation_reference/integerstats_aggregation.md) | Stats |[Integer](../../api/field_type_reference.md#integer-field-type)|
|[KeywordTermAggregation](aggregation_reference/keywordterm_aggregation.md) | Term |[Keyword](../../api/field_type_reference.md#keyword-field-type)|
|[SelectionTermAggregation](aggregation_reference/selectionterm_aggregation.md) | Term |[Selection](../../api/field_type_reference.md#selection-field-type)|
|[TimeRangeAggregation](aggregation_reference/timerange_aggregation.md) | Range |[Time](../../api/field_type_reference.md#time-field-type)|
