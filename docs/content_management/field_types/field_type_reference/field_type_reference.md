---
description: Cohesivo offers a range of built-in field types that cover most common needs when creating content.
page_type: reference
month_change: false
---

# Field type reference

A field type is the underlying building block of the content model.
It consists of two entities: field value and field definition.
Field value is determined by values entered into the content field.
Field definition is provided by the content type, and holds any user defined rules used by field type to determine how a field value is, for example, validated, stored, retrieved, or formatted.

[[= product_name =]] comes with a collection of field types that can be used to build powerful and complex content structures.

!!! tip

    For general field type documentation, see [field type](field_types.md).

The following table gives an overview of the supported field types that come with [[= product_name =]].

Each field type reference page describes the JSON structure that the REST API returns for a field of that type, and that you send when you create or update it.
The **Internal name** column holds the value that the REST API uses as `fieldTypeIdentifier` in field payloads and as `fieldType` in field definitions.

## Available field types

| Field type | Internal name | Description | Searchable in Legacy Storage engine | Searchable with Solr/Elasticsearch |
|---|---|---|---|---|
| [Address](addressfield.md) | `ibexa_address` | Stores an address. | No | No |
| [Author](authorfield.md) | `ibexa_author` | Stores a list of authors, each consisting of author name and author email. | No | Yes |
| [BinaryFile](binaryfilefield.md) | `ibexa_binaryfile` | Stores a file. | Yes | Yes |
| [Checkbox](checkboxfield.md) | `ibexa_boolean` | Stores a boolean value. | Yes | Yes |
| [Country](countryfield.md) | `ibexa_country` | Stores country names as a string. | Yes | Yes |
| [Customer group](customergroupfield.md) | `ibexa_customer_group` | Stores customer group to which a user belongs. | Yes, in [Search](customergroupid_criterion.md) and [Price Search](price_customergroup_criterion.md) | Yes |
| [DateAndTime](dateandtimefield.md) | `ibexa_datetime` | Stores a full date including time information. | Yes | Yes |
| [Date](datefield.md) | `ibexa_date` | Stores date information. | Yes | Yes |
| [EmailAddress](emailaddressfield.md) | `ibexa_email` | Validates and stores an email address. | Yes | Yes |
| [Float](floatfield.md) | `ibexa_float` | Validates and stores a floating-point number. | No | Yes |
| [Form](formfield.md) | `ibexa_form` | Stores a form. | No | Yes |
| [Image](imagefield.md) | `ibexa_image` | Validates and stores an image. | No | Yes |
| [ImageAsset](imageassetfield.md) | `ibexa_image_asset` | Stores images in independent content items of a generic Image content type. | No | Yes |
| [Integer](integerfield.md) | `ibexa_integer` | Validates and stores an integer value. | Yes | Yes |
| [ISBN](isbnfield.md) | `ibexa_isbn` | Handles International Standard Book Number (ISBN) in 10-digit or 13-digit format. | Yes | Yes |
| [Keyword](keywordfield.md) | `ibexa_keyword` | Stores keywords. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [MapLocation](maplocationfield.md) | `ibexa_gmap_location` | Stores map coordinates. | Yes, with [`MapLocationDistance` Criterion](maplocationdistance_criterion.md) | Yes |
| [Matrix](matrixfield.md) | `ibexa_matrix` | Represents and handles a table of rows and columns of data. | No | No |
| [Measurement](measurementfield.md) | `ibexa_measurement` | Validates and stores a unit of measure, and either a single measurement value, or a pair of range values. | Yes | Yes |
| [Media](mediafield.md) | `ibexa_media` | Validates and stores a media file. | No | Yes |
| [Page](pagefield.md) | `ibexa_landing_page` | Stores a Page with a layout consisting of multiple zones. | N/A | N/A |
| [ProductSpecification](productspecificationfield.md) | `ibexa_product_specification` | Stores product attributes and VAT | Yes but only with [Product Search](product_search_criteria.md) | Yes |
| [Relation](relationfield.md) | `ibexa_object_relation` | Validates and stores a relation to a content item. | Yes, with both [`Field`](field_criterion.md) and [`FieldRelation`](fieldrelation_criterion.md) Criteria | Yes |
| [RelationList](relationlistfield.md) | `ibexa_object_relation_list` | Validates and stores a list of relations to content items. | Yes, with [`FieldRelation` Criterion](fieldrelation_criterion.md) | Yes |
| [RichText](richtextfield.md) | `ibexa_richtext` | Validates and stores structured rich text in XML. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [Selection](selectionfield.md) | `ibexa_selection` | Validates and stores a single selection or multiple choices from a list of options. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TaxonomyEntry](taxonomyentryfield.md) | `ibexa_taxonomy_entry` | Stores information about the Taxonomy tree. | No | Yes |
| [TaxonomyEntryAssignment](taxonomyentryassignmentfield.md) | `ibexa_taxonomy_entry_assignment` | Makes content taggable by Taxonomy. | No | Yes |
| [TextBlock](textblockfield.md) | `ibexa_text` | Validates and stores a larger block of text. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TextLine](textlinefield.md) | `ibexa_string` | Validates and stores a single line of text. | Yes | Yes |
| [Time](timefield.md) | `ibexa_time` | Stores time information. | Yes | Yes |
| [Url](urlfield.md) | `ibexa_url` | Stores a URL / address. | No | Yes |
| [User](userfield.md) | `ibexa_user` | Validates and stores information about a user. | No | No |
