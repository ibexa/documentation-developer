---
description: Search Criteria help define and fine-tune search queries for content and Locations.
---

# Search Criteria reference

Search Criteria are filters for Content and Location Search and
[Repository filtering](search_api.md#repository-filtering).

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
|[Ancestor](ancestor_criterion.md)|Whether the Content item is an ancestor of the provided Location|Content and Location Search; Filtering|
|[ContentId](contentid_criterion.md)|Content item's ID|Content and Location Search; Filtering|
|[ContentTypeGroupId](contenttypegroupid_criterion.md)|ID of the Content item's Content Type group|Content and Location Search; Filtering|
|[ContentTypeId](contenttypeid_criterion.md)|ID of the Content item's Content Type|Content and Location Search; Filtering|
|[ContentTypeIdentifier](contenttypeidentifier_criterion.md)|Identifier of the Content item's Content Type|Content and Location Search; Filtering|
|[CurrencyCodeCriterion](currencycode_criterion.md)|Currency code|Content and Location Search; Filtering|
|[DateMetadata](datemetadata_criterion.md)|The date when content was created or last modified|Content and Location Search; Filtering|
|[Depth](depth_criterion.md)|Location depth in the Content tree|Location Search, Filtering|
|[Field](field_criterion.md)|Content of one of Content item's Fields|Content and Location Search|
|[FieldRelation](fieldrelation_criterion.md)|Content items the content in question has Relations to|Content and Location Search|
|[FullText](fulltext_criterion.md)|Full text content of a Content item's Fields|Content and Location Search|
|[IsCurrencyEnabledCriterion](iscurrencyenabled_criterion.md)|Whethe a specificed currency is enabled in the system||
|[IsFieldEmpty](isfieldempty_criterion.md)|Whether a specified Field of a Content item is empty or not|Content and Location Search
|[IsMainLocation](ismainlocation_criterion.md)|Whether a Location is the main Location of a Content item|Location Search, Filtering|
|[IsProductBased](isproductbased_criterion.md)|Whether content represents a product|Content and Location Search; Filtering|
|[IsUserBased](isuserbased_criterion.md)|Whether content represents a User account|Content and Location Search; Filtering|
|[IsUserEnabled](isuserenabled_criterion.md)|Whether a User account is enabled|Content and Location Search; Filtering|
|[LanguageCode](languagecode_criterion.md)|Whether a Content item is translated into the selected language|Content and Location Search; Filtering|
|[LocationId](locationid_criterion.md)|Location ID|Content and Location Search; Filtering|
|[LocationRemoteId](locationremoteid_criterion.md)|Location remote ID|Content and Location Search; Filtering|
|[MapLocationDistance](maplocationdistance_criterion.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content and Location Search|
|[MatchAll](matchall_criterion.md)|Returns all search results|Content and Location Search; Filtering|
|[MatchNone](matchnone_criterion.md)|Returns no search results|Content and Location Search; Filtering|
|[ObjectStateId](objectstateid_criterion.md)|Object State ID|Content and Location Search; Filtering|
|[ObjectStateIdentifier](objectstateidentifier_criterion.md)|Object State Identifier|Content and Location Search; Filtering|
|[ParentLocationId](parentlocationid_criterion.md)|Location ID of a Content item's parent|Content and Location Search; Filtering|
|[Priority](priority_criterion.md)|Location priority|Location Search, Filtering|
|[RemoteId](remoteid_criterion.md)|Remote content ID|Content and Location Search; Filtering|
|[SectionId](sectionid_criterion.md)|ID of the Section content is assigned to|Content and Location Search; Filtering|
|[SectionIdentifier](sectionidentifier_criterion.md)|Identifier of the Section content is assigned to|Content and Location Search; Filtering|
|[Sibling](sibling_criterion.md)|Locations that are children of the same parent|Content and Location Search; Filtering|
|[Subtree](subtree_criterion.md)|Location subtree|Content and Location Search; Filtering|
|[TaxonomyEntryId](taxonomy_entry_id.md)|Content tagged with Entry ID|Content and Tag Search; Filtering|
|[UserEmail](useremail_criterion.md)|Email address of a User account|Content and Location Search; Filtering|
|[UserId](userid_criterion.md)|User ID|Content and Location Search; Filtering|
|[UserLogin](userlogin_criterion.md)|User login|Content and Location Search; Filtering|
|[UserMetadata](usermetadata_criterion.md)|The creator or modifier of a Content item|Content and Location Search; Filtering|
|[Visibility](visibility_criterion.md)|Whether the Content item is visible or not|Content and Location Search; Filtering|

### Product search

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[CheckboxAttribute](checkboxattribute_criterion.md)|Value of product's checkbox attribute|Product search|
|[ColorAttribute](colorattribute_criterion.md)|Value of product's color attribute|Product search|
|[CreatedAt](createdat_criterion.md)|Date and time when product was created|Product search|
|[CreatedAtRange](createdatrange_criterion.md)|Date and time range when product was created|Product search|
|[FloatAttribute](floatattribute_criterion.md)|Value of product's float attribute|Product search|
|[IntegerAttribute](integerattribute_criterion.md)|Value of product's integer attribute|Product search|
|[SelectionAttribute](selectionattribute_criterion.md)|Value of product's selection attribute|Product search|
|[ProductAvailability](productavailability_criterion.md)|Product's availability|Content and Location Search; Filtering|
|[ProductCategory](productcategory_criterion.md)|Product category assigned to product|Product search|
|[ProductCode](productcode_criterion.md)|Product's code|Content and Location Search; Filtering|
|[ProductName](productname_criterion.md)|Product's name|Content and Location Search; Filtering|
|[RangeMeasurementAttributeMinimum](rangemeasurementattributeminimum_criterion.md)|Minimum value of product's measurement attribute|Product search|
|[RangeMeasurementAttributeMaximum](rangemeasurementattributemaximum_criterion.md)|Maximum value of product's measurement attribute|Product search|
|[SimpleMeasurementAttribute](simplemeasurementattribute_criterion.md)|Value of product's measurement attribute|Product search|
|[BasePrice](baseprice_criterion.md)|Product's base price|Product search|
|[CustomPrice](customprice_criterion.md)|Product's custom price|Product search|
|[ProductType](producttype_criterion.md)|Product type|Content and Location Search; Filtering|

### Logical operators

|Search Criterion|Search based on|Supported by|
|-----|-----|-----|
|[LogicalAnd](logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location Search; Filtering|
|[LogicalNot](logicalnot_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content and Location Search; Filtering|
|[LogicalOr](logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches.|Content and Location Search; Filtering|
