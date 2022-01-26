# Search reference

Search Criteria are filters for Content and Location Search and
[Repository filtering](../../api/public_php_api_search.md#repository-filtering).

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific Field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - constants on `Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria do not expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData` - additional value data, required by some Criteria, for instance `MapLocationDistance`

Support and capabilities of individual Criteria can depend on the search engine.

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

## Search Criteria

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[Ancestor](criteria_reference/ancestor_criterion.md)|Whether the Content item is an ancestor of the provided Location|Content and Location Search; Filtering|
|[ContentId](criteria_reference/contentid_criterion.md)|Content item's ID|Content and Location Search; Filtering|
|[ContentTypeGroupId](criteria_reference/contenttypegroupid_criterion.md)|ID of the Content item's Content Type group|Content and Location Search; Filtering|
|[ContentTypeId](criteria_reference/contenttypeid_criterion.md)|ID of the Content item's Content Type|Content and Location Search; Filtering|
|[ContentTypeIdentifier](criteria_reference/contenttypeidentifier_criterion.md)|Identifier of the Content item's Content Type|Content and Location Search; Filtering|
|[CurrencyCodeCriterion](criteria_reference/currencycode_criterion.md)|Currency code|Content and Location Search; Filtering|
|[DateMetadata](criteria_reference/datemetadata_criterion.md)|The date when content was created or last modified|Content and Location Search; Filtering|
|[Depth](criteria_reference/depth_criterion.md)|Location depth in the Content tree|Location Search, Filtering|
|[Field](criteria_reference/field_criterion.md)|Content of one of Content item's Fields|Content and Location Search|
|[FieldRelation](criteria_reference/fieldrelation_criterion.md)|Content items the content in question has Relations to|Content and Location Search|
|[FullText](criteria_reference/fulltext_criterion.md)|Full text content of a Content item's Fields|Content and Location Search|
|[IsCurrencyEnabledCriterion](cirteria_reference/iscurrencyenabled_criterion.md)|Whethe a specificed currency is enabled in the system||
|[IsFieldEmpty](criteria_reference/isfieldempty_criterion.md)|Whether a specified Field of a Content item is empty or not|Content and Location Search
|[IsMainLocation](criteria_reference/ismainlocation_criterion.md)|Whether a Location is the main Location of a Content item|Location Search, Filtering|
|[IsProductBased](criteria_reference/isproductbased_criterion.md)|Whether content represents a product|Content and Location Search; Filtering|
|[IsUserBased](criteria_reference/isuserbased_criterion.md)|Whether content represents a User account|Content and Location Search; Filtering|
|[IsUserEnabled](criteria_reference/isuserenabled_criterion.md)|Whether a User account is enabled|Content and Location Search; Filtering|
|[LanguageCode](criteria_reference/languagecode_criterion.md)|Whether a Content item is translated into the selected language|Content and Location Search; Filtering|
|[LocationId](criteria_reference/locationid_criterion.md)|Location ID|Content and Location Search; Filtering|
|[LocationRemoteId](criteria_reference/locationremoteid_criterion.md)|Location remote ID|Content and Location Search; Filtering|
|[MapLocationDistance](criteria_reference/maplocationdistance_criterion.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content and Location Search|
|[MatchAll](criteria_reference/matchall_criterion.md)|Returns all search results|Content and Location Search; Filtering|
|[MatchNone](criteria_reference/matchnone_criterion.md)|Returns no search results|Content and Location Search; Filtering|
|[ObjectStateId](criteria_reference/objectstateid_criterion.md)|Object State ID|Content and Location Search; Filtering|
|[ObjectStateIdentifier](criteria_reference/objectstateidentifier_criterion.md)|Object State Identifier|Content and Location Search; Filtering|
|[ParentLocationId](criteria_reference/parentlocationid_criterion.md)|Location ID of a Content item's parent|Content and Location Search; Filtering|
|[Priority](criteria_reference/priority_criterion.md)|Location priority|Location Search, Filtering|
|[ProductCode](criteria_reference/productcode_criterion.md)|Product's code|Content and Location Search; Filtering|
|[ProductName](criteria_reference/productname_criterion.md)|Product's name|Content and Location Search; Filtering|
|[ProductType](criteria_reference/producttype_criterion.md)|Product type|Content and Location Search; Filtering|
|[RemoteId](criteria_reference/remoteid_criterion.md)|Remote content ID|Content and Location Search; Filtering|
|[SectionId](criteria_reference/sectionid_criterion.md)|ID of the Section content is assigned to|Content and Location Search; Filtering|
|[SectionIdentifier](criteria_reference/sectionidentifier_criterion.md)|Identifier of the Section content is assigned to|Content and Location Search; Filtering|
|[Sibling](criteria_reference/sibling_criterion.md)|Locations that are children of the same parent|Content and Location Search; Filtering|
|[Subtree](criteria_reference/subtree_criterion.md)|Location subtree|Content and Location Search; Filtering|
|[UserEmail](criteria_reference/useremail_criterion.md)|Email address of a User account|Content and Location Search; Filtering|
|[UserId](criteria_reference/userid_criterion.md)|User ID|Content and Location Search; Filtering|
|[UserLogin](criteria_reference/userlogin_criterion.md)|User login|Content and Location Search; Filtering|
|[UserMetadata](criteria_reference/usermetadata_criterion.md)|The creator or modifier of a Content item|Content and Location Search; Filtering|
|[Visibility](criteria_reference/visibility_criterion.md)|Whether the Content item is visible or not|Content and Location Search; Filtering|

### Logical operators

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[LogicalAnd](criteria_reference/logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location Search; Filtering|
|[LogicalNot](criteria_reference/logicalnot_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content and Location Search; Filtering|
|[LogicalOr](criteria_reference/logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches.|Content and Location Search; Filtering|
