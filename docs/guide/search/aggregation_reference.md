# Aggregation reference

[Aggregation](../../api/public_php_api_search.md#aggregation) is used to group search results into categories.

There are three types of aggregations:

- Term aggregations group by value and count object in each group
- Range aggregations count values in specified ranges
- Stats aggregations compute stats over numeric fields: minimum, average and maximum value, count and sum of values

## Content aggregations

|Name | Type | Based on|
|---|---|---|
|ContentTypeTermAggregation | Term | Content Type  |
|ContentTypeGroupTermAggregation | Term | Content Type group |
|DateMetadataRangeAggregation | Range | Content creation/modification/publication date |
|LanguageTermAggregation | Term | Content language |
|ObjectStateTermAggregation | Term | Object state |
|SectionTermAggregation | Term | Section |
|SubtreeTermAggregation | Term | Content Type  |
|UserMetadataTermAggregation | Term | Content owner/owner group or modifier |
|VisibilityTermAggregation | Term | Content/Location visibility |

## Field aggregations

|Name | Type | Based on Field|
|---|---|---|
|AuthorTermAggregation | Term | [Author](../../api/field_type_reference.md#author-field-type) |
|CheckboxTermAggregation | Term |[Checkbox](../../api/field_type_reference.md#checkbox-field-type)|
|CountryTermAggregation | Term |[Country](../../api/field_type_reference.md#country-field-type)|
|DateRangeAggregation | Range |[Date](../../api/field_type_reference.md#date-field-type)|
|DateTimeRangeAggregation | Range |[DateTime](../../api/field_type_reference.md#dateandtime-field-type)|
|FloatRangeAggregation | Range |[Float](../../api/field_type_reference.md#float-field-type)|
|FloatStatsAggregation | Stats |[Float](../../api/field_type_reference.md#float-field-type)|
|IntegerRangeAggregation | Range |[Integer](../../api/field_type_reference.md#integer-field-type)|
|IntegerStatsAggregation | Stats |[Integer](../../api/field_type_reference.md#integer-field-type)|
|KeywordTermAggregation | Term |[Keyword](../../api/field_type_reference.md#keyword-field-type)|
|SelectionTermAggregation | Term |[Selection](../../api/field_type_reference.md#selection-field-type)|
|TimeRangeAggregation | Range |[Time](../../api/field_type_reference.md#time-field-type)|
