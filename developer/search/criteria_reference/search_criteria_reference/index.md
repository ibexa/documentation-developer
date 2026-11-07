# Search Criteria reference

Search Criteria help define and fine-tune search queries for content and locations.

Search Criteria are filters for content and location Search and [Repository filtering](../../search_api/index.md#repository-filtering).

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - constants on `Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria don't expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData` - additional value data, required by some Criteria, for instance `MapLocationDistance`

Support and capabilities of individual Criteria can depend on the search engine.

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design. Due to this storage limitation, searching content using the Country field type or Keyword when there are multiple values selected may not return all the expected results.

## Search Criteria

| Search Criterion                                                                                                          | Search based on                                                                             | Content Search | Location Search | Filtering | Trash |
| ------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | -------------- | --------------- | --------- | ----- |
| [Ancestor](../ancestor_criterion/index.md)                             | Whether the content item is an ancestor of the provided location                            | Yes            | Yes             | Yes       |       |
| [ContentId](../contentid_criterion/index.md)                           | Content item's ID                                                                           | Yes            | Yes             | Yes       |       |
| [ContentName](../contentname_criterion/index.md)                       | Content item's name                                                                         | Yes            | Yes             | Yes       | Yes   |
| [ContentTypeGroupId](../contenttypegroupid_criterion/index.md)         | ID of the content item's content type group                                                 | Yes            | Yes             | Yes       |       |
| [ContentTypeId](../contenttypeid_criterion/index.md)                   | ID of the content item's content type                                                       | Yes            | Yes             | Yes       | Yes   |
| [ContentTypeIdentifier](../contenttypeidentifier_criterion/index.md)   | Identifier of the content item's content type                                               | Yes            | Yes             | Yes       |       |
| [CurrencyCodeCriterion](../currencycode_criterion/index.md)            | Currency code                                                                               | Yes            | Yes             | Yes       |       |
| [CustomField](../customfield_criterion/index.md)                       | Custom field                                                                                | Yes            | Yes             |           |       |
| [DateMetadata](../datemetadata_criterion/index.md)                     | The date when content was created or last modified                                          | Yes            | Yes             | Yes       | Yes   |
| [Depth](../depth_criterion/index.md)                                   | Location depth in the content tree                                                          |                | Yes             | Yes       |       |
| [Field](../field_criterion/index.md)                                   | Content of one of content item's fields                                                     | Yes            | Yes             |           |       |
| [FieldRelation](../fieldrelation_criterion/index.md)                   | Content items the content in question has Relations to                                      | Yes            | Yes             |           |       |
| [FullText](../fulltext_criterion/index.md)                             | Full text content of a content item's fields                                                | Yes            | Yes             |           |       |
| [Image](../image_criterion/index.md)                                   | Image by specified image attributes                                                         | Yes            | Yes             |           |       |
| [ImageDimensions](../imagedimensions_criterion/index.md)               | Image dimensions: height and width                                                          | Yes            | Yes             |           |       |
| [ImageFileSize](../imagefilesize_criterion/index.md)                   | Image size in MB                                                                            | Yes            | Yes             |           |       |
| [ImageHeight](../imageheight_criterion/index.md)                       | Image height in pixels                                                                      | Yes            | Yes             |           |       |
| [ImageMimeType](../imagemimetype_criterion/index.md)                   | Image type                                                                                  | Yes            | Yes             |           |       |
| [ImageOrientation](../imageorientation_criterion/index.md)             | Image orientation                                                                           | Yes            | Yes             |           |       |
| [ImageWidth](../imagewidth_criterion/index.md)                         | Image width in pixels                                                                       | Yes            | Yes             |           |       |
| [IsBookmarked](../isbookmarked_criterion/index.md)                     | Whether a location is bookmarked or not                                                     |                | Yes             | Yes       |       |
| [IsContainer](../iscontainer_criterion/index.md)                       | Whether a content item is a container (can contain other content items)                     | Yes            | Yes             | Yes       |       |
| [IsCurrencyEnabledCriterion](../iscurrencyenabled_criterion/index.md)  | Whether a specified currency is enabled in the system                                       |                |                 |           |       |
| [IsFieldEmpty](../isfieldempty_criterion/index.md)                     | Whether a specified field of a content item is empty or not                                 | Yes            | Yes             |           |       |
| [IsMainLocation](../ismainlocation_criterion/index.md)                 | Whether a location is the main location of a content item                                   |                | Yes             | Yes       |       |
| [IsProductBased](../isproductbased_criterion/index.md)                 | Whether content represents a product                                                        | Yes            | Yes             | Yes       |       |
| [IsUserBased](../isuserbased_criterion/index.md)                       | Whether content represents a User account                                                   | Yes            | Yes             | Yes       |       |
| [IsUserEnabled](../isuserenabled_criterion/index.md)                   | Whether a User account is enabled                                                           | Yes            | Yes             | Yes       |       |
| [LanguageCode](../languagecode_criterion/index.md)                     | Whether a content item is translated into the selected language                             | Yes            | Yes             | Yes       |       |
| [LocationId](../locationid_criterion/index.md)                         | Location ID                                                                                 | Yes            | Yes             | Yes       |       |
| [LocationRemoteId](../locationremoteid_criterion/index.md)             | Location remote ID                                                                          | Yes            | Yes             | Yes       |       |
| [MapLocationDistance](../maplocationdistance_criterion/index.md)       | Distance between the location contained in a MapLocation field and the provided coordinates | Yes            | Yes             |           |       |
| [MatchAll](../matchall_criterion/index.md)                             | Returns all search results                                                                  | Yes            | Yes             | Yes       | Yes   |
| [MatchNone](../matchnone_criterion/index.md)                           | Returns no search results                                                                   | Yes            | Yes             | Yes       | Yes   |
| [ObjectStateId](../objectstateid_criterion/index.md)                   | Object state ID                                                                             | Yes            | Yes             | Yes       |       |
| [ObjectStateIdentifier](../objectstateidentifier_criterion/index.md)   | Object state Identifier                                                                     | Yes            | Yes             | Yes       |       |
| [ParentLocationId](../parentlocationid_criterion/index.md)             | Location ID of a content item's parent                                                      | Yes            | Yes             | Yes       |       |
| [ParentLocationRemoteId](../parentlocationremoteId_criterion/index.md) | Location remote ID of a content item's parent                                               | Yes            | Yes             |           |       |
| [Priority](../priority_criterion/index.md)                             | Location priority                                                                           |                | Yes             | Yes       |       |
| [RemoteId](../remoteid_criterion/index.md)                             | Remote content ID                                                                           | Yes            | Yes             | Yes       |       |
| [SectionId](../sectionid_criterion/index.md)                           | ID of the Section content is assigned to                                                    | Yes            | Yes             | Yes       | Yes   |
| [SectionIdentifier](../sectionidentifier_criterion/index.md)           | Identifier of the Section content is assigned to                                            | Yes            | Yes             | Yes       |       |
| [Sibling](../sibling_criterion/index.md)                               | Locations that are children of the same parent                                              | Yes            | Yes             | Yes       |       |
| [Subtree](../subtree_criterion/index.md)                               | Location subtree                                                                            | Yes            | Yes             | Yes       |       |
| [TaxonomyEntryId](../taxonomy_entry_id/index.md)                       | Content tagged with Entry ID                                                                | Yes            | Yes             | Yes       |       |
| [TaxonomyNoEntries](../taxonomy_no_entries/index.md)                   | Content with no entries assigned from a given taxonomy                                      | Yes            | Yes             | Yes       |       |
| [TaxonomySubtree](../taxonomy_subtree/index.md)                        | Content assigned to a taxonomy entry or any of its descendants                              | Yes            | Yes             |           |       |
| [UserEmail](../useremail_criterion/index.md)                           | Email address of a User account                                                             | Yes            | Yes             | Yes       |       |
| [UserId](../userid_criterion/index.md)                                 | User ID                                                                                     | Yes            | Yes             | Yes       |       |
| [UserLogin](../userlogin_criterion/index.md)                           | User login                                                                                  | Yes            | Yes             | Yes       |       |
| [UserMetadata](../usermetadata_criterion/index.md)                     | The creator or modifier of a content item                                                   | Yes            | Yes             | Yes       | Yes   |
| [Visibility](../visibility_criterion/index.md)                         | Whether the content item is visible or not                                                  | Yes            | Yes             | Yes       |       |

### Logical operators

All Logical operators are supported by Content and Location Search and [Repository filtering](../../search_api/index.md#repository-filtering).

| Search Criterion                                                                                  | Search based on                                                                                 |
| ------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------- |
| [LogicalAnd](../logicaland_criterion/index.md) | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.           |
| [LogicalNot](../logicalnot_criterion/index.md) | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.         |
| [LogicalOr](../logicalor_criterion/index.md)   | Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches. |
