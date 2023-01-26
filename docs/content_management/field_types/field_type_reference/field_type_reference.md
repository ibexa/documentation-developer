---
description: Ibexa DXP offers a range of built-in Field Types that cover most common needs when creating content.
---

# Field Type reference

A Field Type is the underlying building block of the content model. It consists of two entities: Field value and Field definition. Field value is determined by values entered into the Content Field. Field definition is provided by the Content Type, and holds any user defined rules used by Field Type to determine how a Field Value is validated, stored, retrieved, formatted and so on.

[[= product_name =]] comes with a collection of Field Types that can be used to build powerful and complex content structures. In addition, it is possible to extend the system by creating custom types for special needs.

!!! tip

    For general Field Type documentation, see [Field Type](field_types.md).

Custom Field Types have to be programmed in PHP. However, the built-in Field Types are usually sufficient enough for typical scenarios. The following table gives an overview of the supported Field Types that come with [[= product_name =]].


## Available Field Types

| Field Type | Description | Searchable in Legacy Storage engine | Searchable with Solr/Elasticsearch |
|------------|-------------|-------------------------------------|----------------------|
| [Author](authorfield.md) | Stores a list of authors, each consisting of author name and author email. | No | Yes |
| [BinaryFile](binaryfilefield.md) | Stores a file.| Yes | Yes |
| [Checkbox](checkboxfield.md) | Stores a boolean value. | Yes | Yes |
| [Content query](contentqueryfield.md) | Maps an executable Repository query to a Field. | No | No |
| [Country](countryfield.md) | Stores country names as a string. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [Customer group](customergroupfield.md) | Stores customer group to which a user belongs.
| [DateAndTime](dateandtimefield.md) | Stores a full date including time information. | Yes | Yes |
| [Date](datefield.md) | Stores date information. | Yes | Yes  |
| [EmailAddress](emailaddressfield.md) | Validates and stores an email address. | Yes  | Yes  |
| [Float](floatfield.md) | Validates and stores a floating-point number. | No | Yes |
| [Form](formfield.md) | Stores a form. | No | Yes |
| [Image](imagefield.md) | Validates and stores an image. | No | Yes |
|[ImageAsset](imageassetfield.md)|Stores images in independent Content items of a generic Image Content Type.| No | Yes |
| [Integer](integerfield.md) | Validates and stores an integer value. | Yes | Yes |
| [ISBN](isbnfield.md) | Handles International Standard Book Number (ISBN) in 10-digit or 13-digit format.  | Yes | Yes |
| [Keyword](keywordfield.md) | Stores keywords. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [MapLocation](maplocationfield.md) | Stores map coordinates. | Yes, with [`MapLocationDistance` Criterion](maplocationdistance_criterion.md) | Yes |
| [Matrix](matrixfield.md) | Represents and handles a table of rows and columns of data. | No | No |
| [Measurement](measurementfield.md) | Validates and stores a unit of measure, and either a single measurement value, or top and bottom values of a measurement range. | Yes | Yes |
| [Media](mediafield.md) | Validates and stores a media file. | No | Yes |
| [Null](nullfield.md) | Used as fallback for missing Field Types and for testing purposes. | N/A | N/A |
| [Page](pagefield.md) | Stores a Page with a layout consisting of multiple zones. | N/A | N/A |
| [Relation](relationfield.md) | Validates and stores a relation to a Content item. | Yes, with both [`Field`](fieldrelation_criterion.md) Criteria | Yes |
| [RelationList](relationlistfield.md) | Validates and stores a list of relations to Content items. | Yes, with [`FieldRelation` Criterion](fieldrelation_criterion.md) | Yes |
| [RichText](richtextfield.md) | Validates and stores structured rich text in DocBook xml format, and exposes it in several formats. Available via [RichTextBundle](https://github.com/ibexa/richtext). | Yes[^1^](#1-note-on-legacy-search-engine)  | Yes |
| [Selection](selectionfield.md) | Validates and stores a single selection or multiple choices from a list of options. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [SesExternaldata](sesexternaldata.md) | Uses external storage to store data. |||
| [SesProfiledata](sesprofiledata.md) | Stores address data for a customer. | No | No |
| [SesSelection](sesselection.md) | Stores a single selection choice based on options from a YAML file. | Yes | Yes |
| [SpecificationsType](specificationstype.md) | Stores a structured list of specification data for products. | Yes | Yes |
| [TextBlock](textblockfield.md) | Validates and stores a larger block of text. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TextLine](textlinefield.md) | Validates and stores a single line of text. | Yes | Yes |
| [Time](timefield.md) | Stores time information. | Yes | Yes |
| [Url](urlfield.md) | Stores a URL / address. | No | Yes |
| [User](userfield.md) | Validates and stores information about a user. | No | No |

<a id="1-note-on-legacy-search-engine"></a>**^[1]^ Note on Legacy Search Engine**

Legacy Search/Storage Engine index is limited to 255 characters in database design,
so formatted and unformatted text blocks will only index the first part.
In case of multiple selection Field Types like Keyword, Selection, Country, etc.,
only the first choices are indexed. They are indexed only as a text blob separated by string separator.
Proper indexing of these Field Types is done with [Solr Search engine](solr_search_engine.md).
