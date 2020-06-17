# Search reference

Search Criteria are filters for Content and Location Search.

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific Field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - constants on `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria do not expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData` - additional value data, required by some Criteria, for instance `MapLocationDistance`

Support and capabilities of individual Criteria can depend on the search engine.

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the eZ Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

## Search Criteria

|Search Criterion|Search based on|Search type|
|-----|-----|-----|
|[Ancestor](criteria_reference/ancestor_criterion.md)|Whether the Content item is an ancestor of the provided Location|Content and Location|
|[ContentId](criteria_reference/contentid_criterion.md)|Content item's ID|Content and Location|
|[ContentTypeGroupId](criteria_reference/contenttypegroupid_criterion.md)|ID of the Content item's Content Type group|Content and Location|
|[ContentTypeId](criteria_reference/contenttypeid_criterion.md)|ID of the Content item's Content Type|Content and Location|
|[ContentTypeIdentifier](criteria_reference/contenttypeidentifier_criterion.md)|Identifier of the Content item's Content Type|Content and Location|
|[DateMetadata](criteria_reference/datemetadata_criterion.md)|The date when content was created or last modified|Content and Location|
|[Depth](criteria_reference/depth_criterion.md)|Location depth in the Content tree|Location only|
|[Field](criteria_reference/field_criterion.md)|Content of one of Content item's Fields|Content and Location|
|[FieldRelation](criteria_reference/fieldrelation_criterion.md)|Content items the content in question has Relations to|Content and Location|
|[FullText](criteria_reference/fulltext_criterion.md)|Full text content of a Content item's Fields|Content and Location|
|[IsFieldEmpty](criteria_reference/isfieldempty_criterion.md)|Whether a specified Field of a Content item is empty or not|Content and Location
|[IsMainLocation](criteria_reference/ismainlocation_criterion.md)|Whether a Location is the main Location of a Content item|Location only|
|[IsUserBased](criteria_reference/isuserbased_criterion.md)|Whether content represents a User account|Content and Location|
|[IsUserEnabled](criteria_reference/isuserenabled_criterion.md)|Whether a User account is enabled|Content and Location|
|[LanguageCode](criteria_reference/languagecode_criterion.md)|Whether a Content item is translated into the selected language|Content and Location|
|[LocationId](criteria_reference/locationid_criterion.md)|Location ID|Content and Location|
|[LocationRemoteId](criteria_reference/locationremoteid_criterion.md)|Location remote ID|Content and Location|
|[MapLocationDistance](criteria_reference/maplocationdistance_criterion.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content and Location|
|[MatchAll](criteria_reference/matchall_criterion.md)|Returns all search results|Content and Location|
|[MatchNone](criteria_reference/matchnone_criterion.md)|Returns no search results|Content and Location|
|[ObjectStateId](criteria_reference/objectstateid_criterion.md)|Object State ID|Content and Location|
|[ObjectStateIdentifier](criteria_reference/objectstateidentifier_criterion.md)|Object State Identifier|Content and Location|
|[ParentLocationId](criteria_reference/parentlocationid_criterion.md)|Location ID of a Content item's parent|Content and Location|
|[Priority](criteria_reference/priority_criterion.md)|Location priority|Location only|
|[RemoteId](criteria_reference/remoteid_criterion.md)|Remote content ID|Content and Location|
|[SectionId](criteria_reference/sectionid_criterion.md)|ID of the Section content is assigned to|Content and Location|
|[SectionIdentifier](criteria_reference/sectionidentifier_criterion.md)|Identifier of the Section content is assigned to|Content and Location|
|[Sibling](criteria_reference/sibling_criterion.md)|Locations that are children of the same parent|Content and Location|
|[Subtree](criteria_reference/subtree_criterion.md)|Location subtree|Content and Location|
|[UserEmail](criteria_reference/useremail_criterion.md)|Email address of a User account|Content and Location|
|[UserId](criteria_reference/userid_criterion.md)|User ID|Content and Location|
|[UserLogin](criteria_reference/userlogin_criterion.md)|User login|Content and Location|
|[UserMetadata](criteria_reference/usermetadata_criterion.md)|The creator or modifier of a Content item|Content and Location|
|[Visibility](criteria_reference/visibility_criterion.md)|Whether the Content item is visible or not|Content and Location|

### Logical operators

|Search Criterion|Search based on|Search type|
|-----|-----|-----|
|[LogicalAnd](criteria_reference/logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location|
|[LogicalNot](criteria_reference/logicalnot_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content and Location|
|[LogicalOr](criteria_reference/logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria match.|Content and Location|
