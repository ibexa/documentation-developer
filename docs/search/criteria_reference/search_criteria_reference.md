---
description: Search Criteria help define and fine-tune search queries for content and locations.
month_change: false
---

# Search Criteria reference

Search Criteria are filters for content and location search.

You use them over the REST API, in the `Filter` or `Query` element of the payload of the
[`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request.
In the payload, the name of a Criterion has the `Criterion` suffix, for example, `ContentIdCriterion`.
Criteria that you provide in one `Filter` or `Query` element are combined with a logical AND.
To build more complex conditions, nest them in the [`AND`](logicaland_criterion.md),
[`OR`](logicalor_criterion.md), and [`NOT`](logicalnot_criterion.md) elements.

Criteria can take some of the following arguments:

- `target` - when the Criterion supports targeting a specific field, example: `FieldDefinition` or Metadata identifier
- `value` - the value(s) to filter on, typically a scalar or array of scalars
- `operator` - one of `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`. Most Criteria don't expose this and select `EQ` or `IN` depending on whether the value is scalar or an array. `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value

## Search Criteria

| Search Criterion                                              | Search based on                                                                             | Content Search | Location Search | Filtering |
|---------------------------------------------------------------|---------------------------------------------------------------------------------------------|----------------|-----------------|-----------|
| [Ancestor](ancestor_criterion.md)                             | Whether the content item is an ancestor of the provided location                            | &#10004;       | &#10004;        | &#10004;  |
| [ContentId](contentid_criterion.md)                           | Content item's ID                                                                           | &#10004;       | &#10004;        | &#10004;  |
| [ContentName](contentname_criterion.md)                       | Content item's name                                                                         | &#10004;       | &#10004;        | &#10004;  |
| [ContentTypeGroupId](contenttypegroupid_criterion.md)         | ID of the content item's content type group                                                 | &#10004;       | &#10004;        | &#10004;  |
| [ContentTypeId](contenttypeid_criterion.md)                   | ID of the content item's content type                                                       | &#10004;       | &#10004;        | &#10004;  |
| [ContentTypeIdentifier](contenttypeidentifier_criterion.md)   | Identifier of the content item's content type                                               | &#10004;       | &#10004;        | &#10004;  |
| [DateMetadata](datemetadata_criterion.md)                     | The date when content was created or last modified                                          | &#10004;       | &#10004;        | &#10004;  |
| [Field](field_criterion.md)                                   | Content of one of content item's fields                                                     | &#10004;       | &#10004;        |           |
| [FullText](fulltext_criterion.md)                             | Full text content of a content item's fields                                                | &#10004;       | &#10004;        |           |
| [Image](image_criterion.md)                                   | Image by specified image attributes                                                         | &#10004;       | &#10004;        |           |
| [ImageDimensions](imagedimensions_criterion.md)               | Image dimensions: height and width                                                          | &#10004;       | &#10004;        |           |
| [ImageFileSize](imagefilesize_criterion.md)                   | Image size in MB                                                                            | &#10004;       | &#10004;        |           |
| [ImageMimeType](imagemimetype_criterion.md)                   | Image type                                                                                  | &#10004;       | &#10004;        |           |
| [ImageOrientation](imageorientation_criterion.md)             | Image orientation                                                                           | &#10004;       | &#10004;        |           |
| [IsBookmarked](isbookmarked_criterion.md)                     | Whether a location is bookmarked or not                                                     |                | &#10004;        | &#10004;  |
| [IsContainer](iscontainer_criterion.md)                       | Whether a content item is a container (can contain other content items)                     | &#10004;       | &#10004;        | &#10004;  |
| [IsUserEnabled](isuserenabled_criterion.md)                   | Whether a User account is enabled                                                           | &#10004;       | &#10004;        | &#10004;  |
| [LanguageCode](languagecode_criterion.md)                     | Whether a content item is translated into the selected language                             | &#10004;       | &#10004;        | &#10004;  |
| [LocationId](locationid_criterion.md)                         | Location ID                                                                                 | &#10004;       | &#10004;        | &#10004;  |
| [LocationRemoteId](locationremoteid_criterion.md)             | Location remote ID                                                                          | &#10004;       | &#10004;        | &#10004;  |
| [ObjectStateId](objectstateid_criterion.md)                   | Object state ID                                                                             | &#10004;       | &#10004;        | &#10004;  |
| [ObjectStateIdentifier](objectstateidentifier_criterion.md)   | Object state Identifier                                                                     | &#10004;       | &#10004;        | &#10004;  |
| [ParentLocationId](parentlocationid_criterion.md)             | Location ID of a content item's parent                                                      | &#10004;       | &#10004;        | &#10004;  |
| [ParentLocationRemoteId](parentlocationremoteId_criterion.md) | Location remote ID of a content item's parent                                               | &#10004;       | &#10004;        |           |
| [RemoteId](remoteid_criterion.md)                             | Remote content ID                                                                           | &#10004;       | &#10004;        | &#10004;  |
| [SectionId](sectionid_criterion.md)                           | ID of the Section content is assigned to                                                    | &#10004;       | &#10004;        | &#10004;  |
| [SectionIdentifier](sectionidentifier_criterion.md)           | Identifier of the Section content is assigned to                                            | &#10004;       | &#10004;        | &#10004;  |
| [Sibling](sibling_criterion.md)                               | Locations that are children of the same parent                                              | &#10004;       | &#10004;        | &#10004;  |
| [Subtree](subtree_criterion.md)                               | Location subtree                                                                            | &#10004;       | &#10004;        | &#10004;  |
| [UserEmail](useremail_criterion.md)                           | Email address of a User account                                                             | &#10004;       | &#10004;        | &#10004;  |
| [UserId](userid_criterion.md)                                 | User ID                                                                                     | &#10004;       | &#10004;        | &#10004;  |
| [UserLogin](userlogin_criterion.md)                           | User login                                                                                  | &#10004;       | &#10004;        | &#10004;  |
| [UserMetadata](usermetadata_criterion.md)                     | The creator or modifier of a content item                                                   | &#10004;       | &#10004;        | &#10004;  |
| [Visibility](visibility_criterion.md)                         | Whether the content item is visible or not                                                  | &#10004;       | &#10004;        | &#10004;  |

### Logical operators

All Logical operators are supported by Content and Location Search.

| Search Criterion                      |
|---------------------------------------|
| [LogicalAnd](logicaland_criterion.md) |
| [LogicalNot](logicalnot_criterion.md) |
| [LogicalOr](logicalor_criterion.md)   |
