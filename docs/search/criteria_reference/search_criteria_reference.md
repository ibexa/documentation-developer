---
description: Search Criteria help define and fine-tune search queries for content and locations.
month_change: false
---

# Search Criteria reference

Search Criteria are filters for content and location Search and [Repository filtering](search_api.md#repository-filtering).

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - constants on `Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria don't expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData` - additional value data, required by some Criteria, for instance `MapLocationDistance`

Support and capabilities of individual Criteria can depend on the search engine.

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the Country field type or Keyword when there are multiple values selected may not return all the expected results.

## Search Criteria

| Search Criterion                                              | Search based on                                                                             | Content Search | Location Search | Filtering | Trash    |
|---------------------------------------------------------------|---------------------------------------------------------------------------------------------|----------------|-----------------|-----------|----------|
| [Ancestor](ancestor_criterion.md)                             | Whether the content item is an ancestor of the provided location                            | &#10004;       | &#10004;        | &#10004;  |          |
| [ContentId](contentid_criterion.md)                           | Content item's ID                                                                           | &#10004;       | &#10004;        | &#10004;  |          |
| [ContentName](contentname_criterion.md)                       | Content item's name                                                                         | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [ContentTypeGroupId](contenttypegroupid_criterion.md)         | ID of the content item's content type group                                                 | &#10004;       | &#10004;        | &#10004;  |          |
| [ContentTypeId](contenttypeid_criterion.md)                   | ID of the content item's content type                                                       | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [ContentTypeIdentifier](contenttypeidentifier_criterion.md)   | Identifier of the content item's content type                                               | &#10004;       | &#10004;        | &#10004;  |          |
| [CurrencyCodeCriterion](currencycode_criterion.md)            | Currency code                                                                               | &#10004;       | &#10004;        | &#10004;  |          |
| [DateMetadata](datemetadata_criterion.md)                     | The date when content was created or last modified                                          | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [Depth](depth_criterion.md)                                   | Location depth in the content tree                                                          |                | &#10004;        | &#10004;  |          |
| [Field](field_criterion.md)                                   | Content of one of content item's fields                                                     | &#10004;       | &#10004;        |           |          |
| [FieldRelation](fieldrelation_criterion.md)                   | Content items the content in question has Relations to                                      | &#10004;       | &#10004;        |           |          |
| [FullText](fulltext_criterion.md)                             | Full text content of a content item's fields                                                | &#10004;       | &#10004;        |           |          |
| [Image](image_criterion.md)                                   | Image by specified image attributes                                                         | &#10004;       | &#10004;        |           |          |
| [ImageDimensions](imagedimensions_criterion.md)               | Image dimensions: height and width                                                          | &#10004;       | &#10004;        |           |          |
| [ImageFileSize](imagefilesize_criterion.md)                   | Image size in MB                                                                            | &#10004;       | &#10004;        |           |          |
| [ImageHeight](imageheight_criterion.md)                       | Image height in pixels                                                                      | &#10004;       | &#10004;        |           |          |
| [ImageMimeType](imagemimetype_criterion.md)                   | Image type                                                                                  | &#10004;       | &#10004;        |           |          |
| [ImageOrientation](imageorientation_criterion.md)             | Image orientation                                                                           | &#10004;       | &#10004;        |           |          |
| [ImageWidth](imagewidth_criterion.md)                         | Image width in pixels                                                                       | &#10004;       | &#10004;        |           |          |
| [IsBookmarked](isbookmarked_criterion.md)                     | Whether a location is bookmarked or not                                                     |                | &#10004;        | &#10004;  |          |
| [IsCurrencyEnabledCriterion](iscurrencyenabled_criterion.md)  | Whether a specified currency is enabled in the system                                       |                |                 |           |          |
| [IsFieldEmpty](isfieldempty_criterion.md)                     | Whether a specified field of a content item is empty or not                                 | &#10004;       | &#10004;        |           |          |
| [IsMainLocation](ismainlocation_criterion.md)                 | Whether a location is the main location of a content item                                   |                | &#10004;        | &#10004;  |          |
| [IsProductBased](isproductbased_criterion.md)                 | Whether content represents a product                                                        | &#10004;       | &#10004;        | &#10004;  |          |
| [IsUserBased](isuserbased_criterion.md)                       | Whether content represents a User account                                                   | &#10004;       | &#10004;        | &#10004;  |          |
| [IsUserEnabled](isuserenabled_criterion.md)                   | Whether a User account is enabled                                                           | &#10004;       | &#10004;        | &#10004;  |          |
| [LanguageCode](languagecode_criterion.md)                     | Whether a content item is translated into the selected language                             | &#10004;       | &#10004;        | &#10004;  |          |
| [LocationId](locationid_criterion.md)                         | Location ID                                                                                 | &#10004;       | &#10004;        | &#10004;  |          |
| [LocationRemoteId](locationremoteid_criterion.md)             | Location remote ID                                                                          | &#10004;       | &#10004;        | &#10004;  |          |
| [MapLocationDistance](maplocationdistance_criterion.md)       | Distance between the location contained in a MapLocation field and the provided coordinates | &#10004;       | &#10004;        |           |          |
| [MatchAll](matchall_criterion.md)                             | Returns all search results                                                                  | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [MatchNone](matchnone_criterion.md)                           | Returns no search results                                                                   | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [ObjectStateId](objectstateid_criterion.md)                   | Object state ID                                                                             | &#10004;       | &#10004;        | &#10004;  |          |
| [ObjectStateIdentifier](objectstateidentifier_criterion.md)   | Object state Identifier                                                                     | &#10004;       | &#10004;        | &#10004;  |          |
| [ParentLocationId](parentlocationid_criterion.md)             | Location ID of a content item's parent                                                      | &#10004;       | &#10004;        | &#10004;  |          |
| [ParentLocationRemoteId](parentlocationremoteId_criterion.md) | Location remote ID of a content item's parent                                               | &#10004;       | &#10004;        |           |
| [Priority](priority_criterion.md)                             | Location priority                                                                           |                | &#10004;        | &#10004;  |          |
| [RemoteId](remoteid_criterion.md)                             | Remote content ID                                                                           | &#10004;       | &#10004;        | &#10004;  |          |
| [SectionId](sectionid_criterion.md)                           | ID of the Section content is assigned to                                                    | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [SectionIdentifier](sectionidentifier_criterion.md)           | Identifier of the Section content is assigned to                                            | &#10004;       | &#10004;        | &#10004;  |          |
| [Sibling](sibling_criterion.md)                               | Locations that are children of the same parent                                              | &#10004;       | &#10004;        | &#10004;  |          |
| [Subtree](subtree_criterion.md)                               | Location subtree                                                                            | &#10004;       | &#10004;        | &#10004;  |          |
| [TaxonomyEntryId](taxonomy_entry_id.md)                       | Content tagged with Entry ID                                                                | &#10004;       | &#10004;        | &#10004;  |          |
| [UserEmail](useremail_criterion.md)                           | Email address of a User account                                                             | &#10004;       | &#10004;        | &#10004;  |          |
| [UserId](userid_criterion.md)                                 | User ID                                                                                     | &#10004;       | &#10004;        | &#10004;  |          |
| [UserLogin](userlogin_criterion.md)                           | User login                                                                                  | &#10004;       | &#10004;        | &#10004;  |          |
| [UserMetadata](usermetadata_criterion.md)                     | The creator or modifier of a content item                                                   | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [Visibility](visibility_criterion.md)                         | Whether the content item is visible or not                                                  | &#10004;       | &#10004;        | &#10004;  |          |

### Logical operators

All Logical operators are supported by Content and Location Search and
[Repository filtering](search_api.md#repository-filtering).

| Search Criterion                      | Search based on                                                                                 |
|---------------------------------------|-------------------------------------------------------------------------------------------------|
| [LogicalAnd](logicaland_criterion.md) | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.           |
| [LogicalNot](logicalnot_criterion.md) | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.         |
| [LogicalOr](logicalor_criterion.md)   | Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches. |
