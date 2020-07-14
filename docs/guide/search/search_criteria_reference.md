# Search reference

Search Criteria are filters for Content and Location Search and
[Repository filtering](../../api/public_php_api_filtering.md).

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific Field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - constants on `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria do not expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData` - additional value data, required by some Criteria, for instance `MapLocationDistance`

Support and capabilities of individual Criteria can depend on the search engine.

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the eZ Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

## Search Criteria

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[Ancestor](criteria_reference/ancestor_criterion.md)|Whether the Content item is an ancestor of the provided Location|Content & Location Search, Filtering|
|[ContentId](criteria_reference/contentid_criterion.md)|Content item's ID|Content & Location Search, Filtering|
|[ContentTypeGroupId](criteria_reference/contenttypegroupid_criterion.md)|ID of the Content item's Content Type group|Content & Location Search, Filtering|
|[ContentTypeId](criteria_reference/contenttypeid_criterion.md)|ID of the Content item's Content Type|Content & Location Search, Filtering|
|[ContentTypeIdentifier](criteria_reference/contenttypeidentifier_criterion.md)|Identifier of the Content item's Content Type|Content & Location Search, Filtering|
|[DateMetadata](criteria_reference/datemetadata_criterion.md)|The date when content was created or last modified|Content & Location Search, Filtering|
|[Depth](criteria_reference/depth_criterion.md)|Location depth in the Content tree|Location Search, Filtering|
|[Field](criteria_reference/field_criterion.md)|Content of one of Content item's Fields|Content & Location Search|
|[FieldRelation](criteria_reference/fieldrelation_criterion.md)|Content items the content in question has Relations to|Content & Location Search|
|[FullText](criteria_reference/fulltext_criterion.md)|Full text content of a Content item's Fields|Content & Location Search|
|[IsFieldEmpty](criteria_reference/isfieldempty_criterion.md)|Whether a specified Field of a Content item is empty or not|Content & Location Search
|[IsMainLocation](criteria_reference/ismainlocation_criterion.md)|Whether a Location is the main Location of a Content item|Location Search, Filtering|
|[IsUserBased](criteria_reference/isuserbased_criterion.md)|Whether content represents a User account|Content & Location Search, Filtering|
|[IsUserEnabled](criteria_reference/isuserenabled_criterion.md)|Whether a User account is enabled|Content & Location Search, Filtering|
|[LanguageCode](criteria_reference/languagecode_criterion.md)|Whether a Content item is translated into the selected language|Content & Location Search, Filtering|
|[LocationId](criteria_reference/locationid_criterion.md)|Location ID|Content & Location Search, Filtering|
|[LocationRemoteId](criteria_reference/locationremoteid_criterion.md)|Location remote ID|Content & Location Search, Filtering|
|[MapLocationDistance](criteria_reference/maplocationdistance_criterion.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content & Location Search|
|[MatchAll](criteria_reference/matchall_criterion.md)|Returns all search results|Content & Location Search, Filtering|
|[MatchNone](criteria_reference/matchnone_criterion.md)|Returns no search results|Content & Location Search, Filtering|
|[ObjectStateId](criteria_reference/objectstateid_criterion.md)|Object State ID|Content & Location Search, Filtering|
|[ObjectStateIdentifier](criteria_reference/objectstateidentifier_criterion.md)|Object State Identifier|Content & Location Search, Filtering|
|[ParentLocationId](criteria_reference/parentlocationid_criterion.md)|Location ID of a Content item's parent|Content & Location Search, Filtering|
|[Priority](criteria_reference/priority_criterion.md)|Location priority|Location Search, Filtering|
|[RemoteId](criteria_reference/remoteid_criterion.md)|Remote content ID|Content & Location Search, Filtering|
|[SectionId](criteria_reference/sectionid_criterion.md)|ID of the Section content is assigned to|Content & Location Search, Filtering|
|[SectionIdentifier](criteria_reference/sectionidentifier_criterion.md)|Identifier of the Section content is assigned to|Content & Location Search, Filtering|
|[Sibling](criteria_reference/sibling_criterion.md)|Locations that are children of the same parent|Content & Location Search, Filtering|
|[Subtree](criteria_reference/subtree_criterion.md)|Location subtree|Content & Location Search, Filtering|
|[UserEmail](criteria_reference/useremail_criterion.md)|Email address of a User account|Content & Location Search, Filtering|
|[UserId](criteria_reference/userid_criterion.md)|User ID|Content & Location Search, Filtering|
|[UserLogin](criteria_reference/userlogin_criterion.md)|User login|Content & Location Search, Filtering|
|[UserMetadata](criteria_reference/usermetadata_criterion.md)|The creator or modifier of a Content item|Content & Location Search, Filtering|
|[Visibility](criteria_reference/visibility_criterion.md)|Whether the Content item is visible or not|Content & Location Search, Filtering|

### Logical operators

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[LogicalAnd](criteria_reference/logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content & Location Search, Filtering|
|[LogicalNot](criteria_reference/logicalnot_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content & Location Search, Filtering|
|[LogicalOr](criteria_reference/logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches.|Content & Location Search, Filtering|
