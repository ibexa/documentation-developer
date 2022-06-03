# Field Type reference

A Field Type is the underlying building block of the content model. It consists of two entities: Field value and Field definition. Field value is determined by values entered into the Content Field. Field definition is provided by the Content Type, and holds any user defined rules used by Field Type to determine how a Field Value is validated, stored, retrieved, formatted and so on.

[[= product_name =]] comes with a collection of Field Types that can be used to build powerful and complex content structures. In addition, it is possible to extend the system by creating custom types for special needs.

!!! tip

    For general Field Type documentation, see [Field Type API](../api/field_type_api.md).

Custom Field Types have to be programmed in PHP. However, the built-in Field Types are usually sufficient enough for typical scenarios. The following table gives an overview of the supported Field Types that come with [[= product_name =]].


## Available Field Types

| Field Type | Description | Searchable in Legacy Storage engine | Searchable with Solr/Elasticsearch |
|------------|-------------|-------------------------------------|----------------------|
| [Author](field_types_reference/authorfield.md) | Stores a list of authors, each consisting of author name and author email. | No | Yes |
| [BinaryFile](field_types_reference/binaryfilefield.md) | Stores a file.| Yes | Yes |
| [Checkbox](field_types_reference/checkboxfield.md) | Stores a boolean value. | Yes | Yes |
| [Content query](field_types_reference/contentqueryfield.md) | Maps an executable Repository query to a Field. | No | No |
| [Country](field_types_reference/countryfield.md) | Stores country names as a string. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [Customer group](field_types_reference/customergroupfield.md) | Stores customer group to which a user belongs.
| [DateAndTime](field_types_reference/dateandtimefield.md) | Stores a full date including time information. | Yes | Yes |
| [Date](field_types_reference/datefield.md) | Stores date information. | Yes | Yes  |
| [EmailAddress](field_types_reference/emailaddressfield.md) | Validates and stores an email address. | Yes  | Yes  |
| [Float](field_types_reference/floatfield.md) | Validates and stores a floating-point number. | No | Yes |
| [Form](field_types_reference/formfield.md) | Stores a form. | No | Yes |
| [Image](field_types_reference/imagefield.md) | Validates and stores an image. | No | Yes |
|[ImageAsset](field_types_reference/imageassetfield.md)|Stores images in independent Content items of a generic Image Content Type.| No | Yes |
| [Integer](field_types_reference/integerfield.md) | Validates and stores an integer value. | Yes | Yes |
| [ISBN](field_types_reference/isbnfield.md) | Handles International Standard Book Number (ISBN) in 10-digit or 13-digit format.  | Yes | Yes |
| [Keyword](field_types_reference/keywordfield.md) | Stores keywords. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [MapLocation](field_types_reference/maplocationfield.md) | Stores map coordinates. | Yes, with [`MapLocationDistance` Criterion](../guide/search/criteria_reference/maplocationdistance_criterion.md) | Yes |
| [Matrix](field_types_reference/matrixfield.md) | Represents and handles a table of rows and columns of data. | No | No |
| [Measurement](field_types_reference/measurementfield.md) | Validates and stores a unit of measure, and either a single measurement value, or top and bottom values of a measurement range. | Yes | Yes |
| [Media](field_types_reference/mediafield.md) | Validates and stores a media file. | No | Yes |
| [Null](field_types_reference/nullfield.md) | Used as fallback for missing Field Types and for testing purposes. | N/A | N/A |
| [Page](field_types_reference/pagefield.md) | Stores a Page with a layout consisting of multiple zones. | N/A | N/A |
| [Relation](field_types_reference/relationfield.md) | Validates and stores a relation to a Content item. | Yes, with both [`Field`](../guide/search/criteria_reference/field_criterion.md) and [`FieldRelation`](../guide/search/criteria_reference/fieldrelation_criterion.md) Criteria | Yes |
| [RelationList](field_types_reference/relationlistfield.md) | Validates and stores a list of relations to Content items. | Yes, with [`FieldRelation` Criterion](../guide/search/criteria_reference/fieldrelation_criterion.md) | Yes |
| [RichText](field_types_reference/richtextfield.md) | Validates and stores structured rich text in DocBook xml format, and exposes it in several formats. Available via [RichTextBundle](https://github.com/ibexa/richtext). | Yes[^1^](#1-note-on-legacy-search-engine)  | Yes |
| [Selection](field_types_reference/selectionfield.md) | Validates and stores a single selection or multiple choices from a list of options. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [SesExternaldata](field_types_reference/sesexternaldata.md) | Uses external storage to store data. |||
| [SesProfiledata](field_types_reference/sesprofiledata.md) | Stores address data for a customer. | No | No |
| [SesSelection](field_types_reference/sesselection.md) | Stores a single selection choice based on options from a YAML file. | Yes | Yes |
| [SpecificationsType](field_types_reference/specificationstype.md) | Stores a structured list of specification data for products. | Yes | Yes |
| [TextBlock](field_types_reference/textblockfield.md) | Validates and stores a larger block of text. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TextLine](field_types_reference/textlinefield.md) | Validates and stores a single line of text. | Yes | Yes |
| [Time](field_types_reference/timefield.md) | Stores time information. | Yes | Yes |
| [Url](field_types_reference/urlfield.md) | Stores a URL / address. | No | Yes |
| [User](field_types_reference/userfield.md) | Validates and stores information about a user. | No | No |

<a id="1-note-on-legacy-search-engine"></a>**^[1]^ Note on Legacy Search Engine**

Legacy Search/Storage Engine index is limited to 255 characters in database design,
so formatted and unformatted text blocks will only index the first part.
In case of multiple selection Field Types like Keyword, Selection, Country, etc.,
only the first choices are indexed. They are indexed only as a text blob separated by string separator.
Proper indexing of these Field Types is done with [Solr Search engine](../guide/search/solr.md).

### Other Field Types

|FieldType|Description|Searchable|Editing support in Platform UI|Planned to be included in the future|
|------|------|------|------|------|
| [XmlText](field_types_reference/xmltextfield.md)|Validates and stores multiple lines of formatted text using XML format.|Yes|Partial *(Raw XML editing)*|No *(has been superseded by [RichText](field_types_reference/richtextfield.md))*</br>The XmlText Field Type is not enabled by default in [[= product_name =]].|

### Field Types provided by Community

|FieldType|Description|Searchable|Editing support in Platform UI|Planned to be included in the future|
|------|------|------|------|------|
|[Tags](https://github.com/netgen/TagsBundle)|Tags Field and full-fledged taxonomy management|Yes|Yes, since Netgen Tags v3.0.0|No (but can be previewed in Studio Demo)|
|[Price](https://github.com/ezcommunity/EzPriceBundle)|Price Field for use in product catalogs|Yes|No|Yes|

### Generate new Field Type

You can also make use of the [Field Type Generator Bundle](https://github.com/Smile-SA/EzFieldTypeGeneratorBundle) from our partner Smile.
It helps you get started by creating a skeleton for a Field Type, including templates for the editorial interface. 
