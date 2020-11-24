# Field Types reference

A Field Type is the underlying building block of the content model. It consists of two entities: Field value and Field definition. Field value is determined by values entered into the Content Field. Field definition is provided by the Content Type, and holds any user defined rules used by Field Type to determine how a Field Value is validated, stored, retrieved, formatted and so on.

[[= product_name =]] comes with a collection of Field Types that can be used to build powerful and complex content structures. In addition, it is possible to extend the system by creating custom types for special needs.

!!! tip

    For general Field Type documentation, see [Field Type API](../api/field_type_api.md).

Custom Field Types have to be programmed in PHP. However, the built-in Field Types are usually sufficient enough for typical scenarios. The following table gives an overview of the supported Field Types that come with [[= product_name =]].


## Available Field Types

| Field Type | Description | Searchable in Legacy Storage engine | Searchable with Solr |
|------------|-------------|-------------------------------------|----------------------|
| [Author](#author-field-type) | Stores a list of authors, each consisting of author name and author email. | No | Yes |
| [BinaryFile](#binaryfile-field-type) | Stores a file.| Yes | Yes |
| [Checkbox](#checkbox-field-type) | Stores a boolean value. | Yes | Yes |
| [Country](#country-field-type) | Stores country names as a string. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [DateAndTime](#dateandtime-field-type) | Stores a full date including time information. | Yes | Yes |
| [Date](#date-field-type) | Stores date information. | Yes | Yes  |
| [EmailAddress](#emailaddress-field-type) | Validates and stores an email address. | Yes  | Yes  |
| [Float](#float-field-type) | Validates and stores a floating-point number. | No | Yes |
| [Form](#form-field-type) | Stores a form. | No | Yes |
| [Image](#image-field-type) | Validates and stores an image. | No | Yes |
|[ImageAsset](#imageasset-field-type)|Stores images in independent content items of a generic Image content type.| No | Yes |
| [Integer](#integer-field-type) | Validates and stores an integer value. | Yes | Yes |
| [ISBN](#isbn-field-type) | Handles International Standard Book Number (ISBN) in 10-digit or 13-digit format.  | Yes | Yes |
| [Keyword](#keyword-field-type) | Stores keywords. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [MapLocation](#maplocation-field-type) | Stores map coordinates. | Yes, with [`MapLocationDistance` Criterion](../guide/search/criteria_reference/maplocationdistance_criterion.md) | Yes |
| [Matrix](#matrix-field-type) | Represents and handles a table of rows and columns of data. | No | No |
| [Media](#media-field-type) | Validates and stores a media file. | No | Yes |
| [Null](#null-field-type) | Used as fallback for missing Field Types and for testing purposes. | N/A | N/A |
| [Page](#page-field-type) | Stores a Page with a layout consisting of multiple zones. | N/A | N/A |
| [Rating](#rating-field-type) | **Deprecated** | N/A | N/A |
| [Relation](#relation-field-type) | Validates and stores a relation to a Content item. | Yes, with both [`Field`](../guide/search/criteria_reference/field_criterion.md) and [`FieldRelation`](../guide/search/criteria_reference/fieldrelation_criterion.md) Criteria | Yes |
| [RelationList](#relationlist-field-type) | Validates and stores a list of relations to Content items. | Yes, with [`FieldRelation` Criterion](../guide/search/criteria_reference/fieldrelation_criterion.md) | Yes |
| [RichText](#richtext-field-type) | Validates and stores structured rich text in DocBook xml format, and exposes it in several formats. Available via [RichTextBundle](https://github.com/ezsystems/ezplatform-richtext). | Yes[^1^](#1-note-on-legacy-search-engine)  | Yes |
| [Selection](#selection-field-type) | Validates and stores a single selection or multiple choices from a list of options. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TextBlock](#textblock-field-type) | Validates and stores a larger block of text. | Yes[^1^](#1-note-on-legacy-search-engine) | Yes |
| [TextLine](#textline-field-type) | Validates and stores a single line of text. | Yes | Yes |
| [Time](#time-field-type) | Stores time information. | Yes | Yes |
| [Url](#url-field-type) | Stores a URL / address. | No | Yes |
| [User](#user-field-type) | Validates and stores information about a user. | No | No |

<a id="1-note-on-legacy-search-engine"></a>**^[1]^ Note on Legacy Search Engine**

Legacy Search/Storage Engine index is limited to 255 characters in database design,
so formatted and unformatted text blocks will only index the first part.
In case of multiple selection Field Types like Keyword, Selection, Country, etc.,
only the first choices are indexed. They are indexed only as a text blob separated by string separator.
Proper indexing of these Field Types is done with [Solr Search Bundle](../guide/search/solr.md).

### Other Field Types

|FieldType|Description|Searchable|Editing support in Platform UI|Planned to be included in the future|
|------|------|------|------|------|
| [XmlText](#xmltext-field-type)|Validates and stores multiple lines of formatted text using XML format.|Yes|Partial *(Raw XML editing)*|No *(has been superseded by [RichText](#richtext-field-type))*</br>The XmlText Field Type is not enabled by default in [[= product_name =]].|

### Field Types provided by Community

|FieldType|Description|Searchable|Editing support in Platform UI|Planned to be included in the future|
|------|------|------|------|------|
|[Tags](https://github.com/netgen/TagsBundle)|Tags Field and full-fledged taxonomy management|Yes|Yes, since Netgen Tags v3.0.0|No (but can be previewed in Studio Demo)|
|[Price](https://github.com/ezcommunity/EzPriceBundle)|Price Field for use in product catalogs|Yes|No|Yes|

### Generate new Field Type

You can also make use of the [Field Type Generator Bundle](https://github.com/Smile-SA/EzFieldTypeGeneratorBundle) from our partner Smile.
It helps you get started by creating a skeleton for a Field Type, including templates for the editorial interface. 

## Author Field Type

This Field Type allows the storage and retrieval of one or more authors. For each author, it can handle a name and an email address. It is typically used to store information about additional authors who have written/created different parts of a Content item.

| Name     | Internal name | Expected input | Output   |
|----------|---------------|----------------|----------|
| `Author` | `ezauthor`    | mixed        | `string` |



### PHP API Field Type

#### Value Object

###### Properties

|Attribute|Type|Description|Example|
|------|------|------|------|
|`authors`|`\eZ\Publish\Core\FieldType\Author\Author[] `|List of authors.|See below|

Example:

``` php
$authorList = Author\Value([
   new Author\Author([
       'id' => 1,
       'name' => 'Boba Fett',
       'email' => 'boba.fett@example.com'
   ]),
   new Author\Author([
       'id' => 2,
       'name' => 'Darth Vader',
       'email' => 'darth.vader@example.com'
   ]),
]);
```

#### Hash format

The hash format mostly matches the value object. It has the following key `authors`.


Example

``` php
[
    [
       'id' => 1,
       'name' => 'Boba Fett',
       'email' => 'boba.fett@example.com'
    ],
    [
       'id' => 2,
       'name' => 'Darth Vader',
       'email' => 'darth.vader@example.com'
    ]
]
```

###### String representation

The string will contain all the authors with their names and emails.

Example: `John Doe john@doe.com`

#### Validation

This Field Type does not perform any special validation of the input value.

#### Settings

The Field definition of this Field Type can be configured with a single option:

|Name|Type|Default value|Description|
|------|------|------|------|
|`defaultAuthor`|`mixed`|`Type::DEFAULT_VALUE_EMPTY`|One of the `DEFAULT_*` constants, used by the administration interface for setting the default Field value. See below for more details.|

Following `defaultAuthor` default value options are available as constants in the `eZ\Publish\Core\FieldType\Author\Type` class:

|Constant|Description|
|------|------|
|`DEFAULT_VALUE_EMPTY`|Default value will be empty.|
|`DEFAULT_CURRENT_USER`|Default value will use currently logged user.|

``` php
// Author Field Type example settings

use eZ\Publish\Core\FieldType\Author\Type;

$settings = [
    "defaultAuthor" => Type::DEFAULT_VALUE_EMPTY
];
```

## BinaryFile Field Type

This Field Type represents and handles a single binary file. It also counts the number of times the file has been downloaded from the `content/download` module.

It is capable of handling virtually any file type and is typically used for storing legacy document types such as PDF files, Word documents, spreadsheets, etc. The maximum allowed file size is determined by the "Max file size" class attribute edit parameter and the `upload_max_filesize` directive in the main PHP configuration file (`php.ini`).

| Name         | Internal name  | Expected input | Output  |
|--------------|----------------|----------------|---------|
| `BinaryFile` | `ezbinaryfile` | mixed        | mixed |

### PHP API Field Type

#### Value Object

###### Properties


Note that both `BinaryFile` and `Media` Value and Type inherit from the `BinaryBase` abstract Field Type, and share common properties.

`eZ\Publish\Core\FieldType\BinaryFile\Value` offers the following properties:

|Attribute|Type|Description|Example|
|------|------|------|------|
|`id`|string|Binary file identifier. This ID depends on the [IO Handler](../guide/clustering.md#dfs-io-handler) that is being used. With the native, default handlers (FileSystem and Legacy), the ID is the file path, relative to the binary file storage root dir (`var/<vardir>/storage/original` by default).|application/63cd472dd7.pdf|
|`fileName`|string|The human-readable file name, as exposed to the outside. Used when sending the file for download in order to name the file.|20130116_whitepaper.pdf|
|`fileSize`|int|File size, in bytes.|1077923|
|`mimeType`|string|The file's MIME type.|application/pdf|
|`uri`|string|The binary file's `content/download` URI. If the URI doesn't include a host or protocol, it applies to the request domain.|/content/download/210/2707|
|`downloadCount`|integer|Number of times the file was downloaded|0|
|`path`|string|**deprecated**|N/A|


#### Hash format

The hash format mostly matches the value object. It has the following keys:

- `id`
- `path` (for backwards compatibility)
- `fileName`
- `fileSize`
- `mimeType`
- `uri`
- `downloadCount`

Example:

```php
[
    'id' => 'some/file/here',
    'fileName' => 'sindelfingen.jpg',
    'fileSize' => 2342,
    'downloadCount' => 0,
    'mimeType' => 'image/jpeg',
    'uri' => 'http://some/file/here',
]
```

### REST API specifics

Used in the REST API, a BinaryFile Field will mostly serialize the hash described above. However there are a couple specifics worth mentioning.

#### Reading content: `url` property

When reading the contents of a Field of this type, an extra key is added: `url`. This key gives you the absolute file URL, protocol and host included.

Example: <http://example.com/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf>

#### Creating content: data property

When creating BinaryFile content with the REST API, it is possible to provide data as a base64 encoded string, using the `data` fieldValue key:

``` xml
<field>
    <fieldDefinitionIdentifier>file</fieldDefinitionIdentifier>
    <languageCode>eng-GB</languageCode>
    <fieldValue>
        <value key="fileName">My file.pdf</value>
        <value key="fileSize">17589</value>
        <value key="data"><![CDATA[/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG
...
...]]></value>
    </fieldValue>
</field>
```

## Checkbox Field Type

The Checkbox Field Type stores the current status for a checkbox input, checked or unchecked, by storing a boolean value.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `Checkbox` | `ezboolean`   | `boolean`           |

### PHP API Field Type 

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type      | Default value | Description|
|----------|-----------|---------------|------------|
| `$bool`  | `boolean` | `false`       | This property is used for the checkbox status, represented by a boolean value. |

``` php
//Value object content examples
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a default state (false)
$checkboxValue = new Checkbox\Value();
 
// Checked
$value->bool = true;

// Unchecked
$value->bool = false;
```

###### Constructor

The `Checkbox\Value` constructor accepts a boolean value:

``` php
// Constructor example
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```

###### String representation

As this Field Type is not a string but a boolean, it will return "1" (true) or "0" (false) in cases where it is cast to string.

## Content query Field Type

This Field Type maps an executable Repository query to a Field.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Content query` | `ezcontentquery`   | `string`        |

The Content query Field Type is available via the Query Field Type Bundle
provided by the [ezplatform-query-fieldtype](https://github.com/ezsystems/ezplatform-query-fieldtype) package.

For information on the Field Type's usage, see [Query Field Type in controller documentation](../guide/controllers.md#query-field-type).

## Country Field Type

This Field Type represents one or multiple countries.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Country` | `ezcountry`   | `array`        |

### PHP API Field Type 

#### Input expectations

Example array:

``` php
[
    "JP" => [
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    ]
];
```

When you set an array directly on a Content field you don't need to provide all this information, the Field Type will assume it is a hash and in this case will accept a simplified structure described below under [Hash format](#hash-format).

#### Validation

This Field Type validates whether multiple countries are allowed by the Field definition, and whether the [Alpha2](https://www.iso.org/iso-3166-country-codes.html) is valid according to the countries configured in [[= product_name =]].

#### Settings

The Field definition of this Field Type can be configured with one option:

| Name         | Type      | Default value | Description|
|--------------|-----------|---------------|------------|
| `isMultiple` | `boolean` | `false`       | This setting allows (if true) or prohibits (if false) the selection of multiple countries. |

``` php
// Country FieldType example settings
$settings = [
    "isMultiple" => true
];
```

#### Hash format

The format used for serialization is simpler than the full format. It is also available when setting value on the content field, by setting the value to an array instead of the Value object. Example of that shown below:

``` php
// Value object content example
$content->fields["countries"] = [ "JP", "NO" ];
```

The format used by the toHash method is the Alpha2 value, however the input is capable of accepting either Name, Alpha2 or Alpha3 value as shown below in the Value object section.

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property     | Type      | Description|
|--------------|-----------|------------|
| `$countries` | `array[]` | This property is used for the country selection provided as input, as its attributes. |

``` php
// Value object content example
$value->countries = [
    "JP" => [
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    ]
];
```

###### Constructor

The `Country\Value` constructor will initialize a new Value object with the value provided. It expects an array as input.

``` php
// Constructor example

// Instantiates a Country Value object
$countryValue = new Country\Value(
    [
        "JP" => [
            "Name" => "Japan",
            "Alpha2" => "JP",
            "Alpha3" => "JPN",
            "IDC" => 81
        ]
    ]
);
```

## DAM Field Type

This Field Type stores asset information from a DAM system.
It replaces the [ImageAsset Field Type](#imageasset-field-type).

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Image Asset` | `ezimageasset`      | mixed             |

#### Value object

###### Properties

Value object of `dam` contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `destinationContentId`  |  `string` | Related content ID. |
| `alternativeText`  |  `string` |  The alternative image text. |
| `source` | `string` | Source of the DAM asset. |

## Date Field Type

This Field Type represents a date without time information.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Date` | `ezdate`      | mixed             |

##### PHP API Field Type 

#### Input expectations

If input value is in `string` or `integer` format, it will be passed directly to [PHP's built-in `\DateTime` class constructor](http://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It is also possible to directly pass an instance of `\DateTime`.

|Type|Example|
|------|------|
|`string`|`"2012-08-28 12:20 Europe/Berlin"`|
|`integer`|`1346149200`|
|`\DateTime`|`new \DateTime()`|

Time information is **not stored**.

Before storing, the provided input value will be set to the beginning of the day in the given or the environment timezone.

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type        | Description|
|----------|-------------|------------|
| `$date`  | `\DateTime` | This property will be used for the text content. |

###### String representation

String representation of the date value will generate the date string in the format "l d F Y" as accepted by [PHP's built-in `date()` function](http://www.php.net/manual/en/function.date.php).

|Character|Description|Example|
|---------|----------|--------|
|l|Textual representation of a day of the week, range Monday to Sunday|Wednesday|
|d|Two digit representation of a day, range 01 to 31|22|
|F|Textual representation of a month, range January to December|May|
|Y|Four digit representation of a year|2016|

Example: `Wednesday 22 May 2016`

###### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of [PHP's built-in `\DateTime` class](http://www.php.net/manual/en/datetime.construct.php).

#### Hash format

Hash value of this Field Type is an array with two keys:

|Key|Type|Description|Example|
|------|------|------|------|
|`timestamp`|`integer`|Time information in [unix format timestamp](http://en.wikipedia.org/wiki/Unix_time).|`1400856992`|
|`rfc850`|`string`|Time information as a string in [RFC 850 date format](http://tools.ietf.org/html/rfc850). As input, this will have higher precedence over the timestamp value.|`"Friday, 23-May-14 14:56:14 GMT+0000"`|

``` php
// Example of the hash value in PHP
$hash = [
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
];
```

#### Validation

This Field Type does not perform any special validation of the input value.

#### Settings

The Field definition of this Field Type can be configured with a single option:

|Name|Type|Default value|Description|
|------|------|------|------|
|`defaultType`|`mixed`|`Type::DEFAULT_EMPTY`|One of the `DEFAULT_*` constants, used by the administration interface for setting the default Field value. See below for more details.|

Following `defaultType` default value options are available as constants in the `eZ\Publish\Core\FieldType\Date\Type` class:

|Constant|Description|
|------|------|
|`DEFAULT_EMPTY`|Default value will be empty.|
|`DEFAULT_CURRENT_DATE`|Default value will use current date.|

``` php
// Date Field Type example settings

use eZ\Publish\Core\FieldType\Date\Type;

$settings = [
    "defaultType" => Type::DEFAULT_EMPTY
];
```

### Template rendering

The template called by [the `ez_render_field()` Twig function](../guide/twig_functions_reference.md#ez_render_field) while rendering a Date Field has access to the following parameters:

| Parameter | Type     |Description|
|-----------|----------|------------|
| `locale`  | `string` |Internal parameter set by the system based on current request locale or if not set, calculated based on the language of the Field. |

Example:

``` html+twig
{{ ez_render_field(content, 'date') }}
```

## DateAndTime Field Type

This Field Type represents a full date and time information.

| Name          | Internal name | Expected input type |
|---------------|---------------|---------------------|
| `DateAndTime` | `ezdatetime`  | mixed             |

### PHP API Field Type 

#### Input expectations

If input value is of type `string` or `integer`, it will be passed directly to the [PHP's built-in `\DateTime` class constructor](http://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It is also possible to directly pass an instance of `\DateTime`.

|Type|Example|
|------|------|
|`integer`|`"2017-08-28 12:20 Europe/Berlin"`|
|`integer`|`1346149200`|
|`\DateTime`|`new \DateTime()`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type        | Description|
|----------|-------------|------------|
| `$value` | `\DateTime` | The date and time value as an instance of `\DateTime`. |

###### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of PHP's built-in `\DateTime` class.

###### String representation

String representation of the date value will generate the date string in the format `D Y-d-m H:i:s` as accepted by [PHP's built-in `date()` function](http://www.php.net/manual/en/function.date.php).

|Character|Description|Example|
|---------|----------|--------|
|D|Three letter representation of a day, range Mon to Sun|Wed|
|Y|Four digit representation of a year|2016|
|d|Two digit representation of a day, range 01 to 31|22|
|m|Two digit representation of a month, range 01 to 12|05|
|H|Two digit representation of an hour, 24-hour format, range 00 to 23 |12|
|i|Two digit representation of minutes, range 00 to 59|19|
|s|Two digit representation of seconds, range 00 to 59|18|

Example: `Wed 2016-22-05 12:19:18`

#### Hash format

Hash value of this Field Type is an array with two keys:

|Key|Type|Description|Example|
|------|------|------|------|
|`timestamp`|`integer`|Time information in [Unix format timestamp](http://en.wikipedia.org/wiki/Unix_time).|`1400856992`|
|`rfc850`|`string`|Time information as a string in [RFC 850 date format](http://tools.ietf.org/html/rfc850). As input, this will have precedence over the timestamp value.|`"Friday, 23-May-14 14:56:14 GMT+0000"`|

``` php
$hash = [
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
];
```

#### Validation

This Field Type does not perform any special validation of the input value.

#### Settings

The Field definition of this Field Type can be configured with several options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`useSeconds`|`boolean`|`false`|Used to control displaying of seconds in the output.|
|`defaultType`|`mixed`|`Type::DEFAULT_EMPTY`|One of the `DEFAULT_*` constants, used by the administration interface for setting the default Field value. See below for more details.|
|`dateInterval`|`null|\DateInterval`|`null`|This setting complements `defaultType` setting and can be used only when the latter is set to `Type::DEFAULT_CURRENT_DATE_ADJUSTED`. In that case the default input value when using administration interface will be adjusted by the given `\DateInterval`.|

Following `defaultType` default value options are available as constants in the `eZ\Publish\Core\FieldType\DateAndTime\Type` class:

|Constant|Description|
|------|------|
|`DEFAULT_EMPTY`|Default value will be empty.|
|`DEFAULT_CURRENT_DATE`|Default value will use current date.|
|`DEFAULT_CURRENT_DATE_ADJUSTED`|Default value will use current date, adjusted by the interval defined in `dateInterval` setting.|

``` php
// DateAndTime FieldType example settings

use eZ\Publish\Core\FieldType\DateAndTime\Type;

$settings = [
    "useSeconds" => false,
    "defaultType" => Type::DEFAULT_EMPTY,
    "dateInterval" => null
];
```

### Template rendering

The template called by the [`ez_render_field()` Twig function](../guide/twig_functions_reference.md#ez_render_field) while rendering a Date Field has access to the following parameters:

| Parameter | Type     | Default | Description|
|-----------|----------|---------|------------|
| `locale`  | `string` |   n/a   | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the Field. |

Example:

``` php
{{ ez_render_field(content, 'datetime') }}
```

## EmailAddress Field Type

The EmailAddress Field Type represents an email address, in the form of a string.

| Name           | Internal name | Expected input type |
|----------------|---------------|---------------------|
| `EmailAddress` | `ezemail`     | `string`            |

### PHP API Field Type 

#### Value object

###### Properties

The `Value` class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$email` | `string` | This property will be used for the input string provided as email address. |

``` php
// Value object content example

use eZ\Publish\Core\FieldType\EmailAddress\Type;

// Instantiates an EmailAddress Value object with default value (empty string)
$emailaddressValue = new Type\Value();

// Email definition
$emailaddressValue->email = "someuser@example.com";
```

###### Constructor

The `EmailAddress\Value` constructor will initialize a new Value object with the value provided. It accepts a string as input.

``` php
// Constructor example

use eZ\Publish\Core\FieldType\EmailAddress\Type;
 
// Instantiates an EmailAddress Value object
$emailaddressValue = new Type\Value( "someuser@example.com" );
```

###### String representation

String representation of the Field Type's Value object is the email address contained in it.

Example: `someuser@example.com`

#### Hash format

Hash value for this Field Type's Value is simply the email address as a string.

Example: `someuser@example.com`

#### Validation

This Field Type uses the `EmailAddressValidator` validator as a resource which will test the string supplied as input against a pattern, to make sure that a valid email address has been provided.
If the validations fail, a `ValidationError` is thrown, specifying the error message.

#### Settings

This Field Type does not support settings.

## Float Field Type

This Field Type stores numeric values which will be provided as floats.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Float` | `ezfloat`     | `float`        |

### PHP API Field Type 

#### Input expectations

The Field Type expects a number as input. Both decimal and integer numbers are accepted.

|Type|Example|
|------|------|
|`float`|`194079.572`|
|`int`|`144`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type    | Description|
|----------|---------|------------|
| `$value` | `float` | This property will be used to store the value provided as a float. |

``` php
// Value object content example

use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value();

$float->value = 284.773
```

###### Constructor

The `Float\Value` constructor will initialize a new Value object with the value provided. It expects a numeric value with or without decimals.

``` php
// Constructor example

use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value( 284.773 );
```

#### Validation

This Field Type supports `FloatValueValidator`, defining maximum and minimum float value:

|Name|Type|Default value|Description|
|------|------|------|------|
|`minFloatValue`|`float`|`null|This setting defines the minimum value this Field Type will allow as input.|
|`maxFloatValue`|`float`|`null|This setting defines the maximum value this Field Type will allow as input.|

``` php
// Validator configuration example in PHP

use eZ\Publish\Core\FieldType\Float\Type;

$contentTypeService = $repository->getContentTypeService();
$floatFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "float", "ezfloat" );

// Accept only numbers between 0.1 and 203.99
$floatFieldCreateStruct->validatorConfiguration = [
    "FileSizeValidator" => [
        "minFloatValue" => 0.1,
        "maxFloatValue" => 203.99
    ]
];
```

#### Settings

This Field Type does not support settings.

## Form Field Type [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

| Name    | Internal name |
|---------|---------------|
| `Image` | `ezform`      |

The Form Field Type stores a Form consisting of one or more form fields.

See [Extending Form Builder](../extending/extending_form_builder.md) for more information
about working with Forms.

## Image Field Type

| Name    | Internal name |
|---------|---------------|
| `Image` | `ezimage`     |

The Image Field Type allows you to store an image file.

A **variation service** handles the conversion of the original image into different formats and sizes through a set of preconfigured named variations: large, small, medium, black and white thumbnail, etc.

### PHP API Field Type

#### Value object

The `value` property of an Image Field will return an `\eZ\Publish\Core\FieldType\Image\Value` object with the following properties:

###### Properties

|Property|Type|Example|Description|
|------|------|------|------|
|`id`|string|`0/8/4/1/1480-1-eng-GB/image.png`|The image's unique identifier. Usually the path, or a part of the path. To get the full path, use the `uri` property.|
|`alternativeText`|string|`Picture of an apple.`|The alternative text, as entered in the Field's properties|
|`fileName`|string|`image.png`|The original image's filename, without the path|
|`fileSize`|int|`37931`|The original image's size, in bytes|
|`uri`|string|`var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image.png`|The original image's URI|
|`imageId`|string|`240-1480`|A special image ID, used by REST|
|`inputUri`|string|`var/storage/images/test/199-2-eng-GB/image.png`|Input image file URI.|
|`width`*|int|`null`|Original image width in pixels. For more details see Caution note below.|
|`height`*|int|`null`|Original image height in pixels. For more details see Caution note below.|

!!! caution

    Properties marked with an asterisk are currently unsupported. They are available but their value is always `null`.

    Follow [EZP-27987](https://jira.ez.no/browse/EZP-27987) for future progress on this issue.

#### Settings

This Field Type does not support settings.

#### Image Variations

Using the variation Service, variations of the original image can be obtained. They are `\eZ\Publish\SPI\Variation\Values\ImageVariation` objects with the following properties:

| Property       | Type     | Example  | Description|
|----------------|----------|----------|------------|
| `width`*       | int      | `null`    | The variation's width in pixels. For more details see Caution note below.|
| `height`*      | int      | `null`    | The variation's height in pixels. For more details see Caution note below.|
| `name`         | string   | `medium` | The variation's identifier, name of the image alias|
| `info`         | mixed    |n/a| Extra information about the image, depending on the image type, such as EXIF data. If there is no information, the `info` value will be `null`.|
| `fileSize`     | int      |`31010` |Size (in byte) of current variation|
| `mimeType`     | string   |`image/png`|The MIME type|
| `fileName`     | string   |`my_image.png`|The name of the file|
| `dirPath`      | string   |`var/storage/images/test/199-2-eng-GB`|The path to the file|
| `uri`          | string   |`var/storage/images/test/199-2-eng-GB/apple.png`| The variation's URI. Complete path with a name of image file|
| `lastModified` | DateTime |``"2017-08-282 12:20 Europe/Berlin"``| When the variation was last modified |

!!! caution

    Properties marked with an asterisk are currently unsupported. They are available but their value is always `null`.

    Follow [EZP-27987](https://jira.ez.no/browse/EZP-27987) for future progress on this issue.

#### Field Definition options

The Image Field Type supports one `FieldDefinition` option: the maximum size for the file.

!!!note

    Maximum size is rounded to 1 MB (legacy storage limitation).

!!! note

    As the default value for maximum size is set to 10MB, we recommend setting the `upload_max_filesize` key in the `php.ini` configuration file to a value equal to or higher than that. It will prevent validation errors while editing Content Types.

### Using an Image Field

To read more about handling images and image variations, see the [Images documentation](../guide/images.md).

#### Template Rendering

When displayed using `ez_render_field`, an Image Field will output this type of HTML:

``` html+twig
<img src="var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image_medium.png" width="844" height="430" alt="Alternative text" />
```

The template called by the [`ez_render_field()` Twig function](../guide/twig_functions_reference.md#ez_render_field) while rendering a Image Field accepts the following parameters:

| Parameter | Type     | Default        | Description |
|-----------|----------|----------------|-------------|
| `alias`   | `string` | `"original"` | The image variation name, must be defined in your SiteAccess's `image_variations` settings. Defaults to "original", the originally uploaded image.|
| `width`   | `int`    |   n/a        | Optionally to specify a different width set on the image HTML tag then then one from image alias. |
| `height`  | `int`    |   n/a        | Optionally to specify a different height set on the image HTML tag then then one from image alias. |
| `class`   | `string` |   n/a        | Optionally to specify a specific html class for use in custom JavaScript and/or CSS. |

Example: 

``` html+twig
{{ ez_render_field( content, 'image', { 'parameters':{ 'alias': 'imagelarge', 'width': 400, 'height': 400 } } ) }}
```

The raw Field can also be used if needed. Image variations for the Field's content can be obtained using the `ez_image_alias` Twig helper:

``` html+twig
{% set imageAlias = ez_image_alias( field, versionInfo, 'medium' ) %}
```

The variation's properties can be used to generate the required output:

``` html+twig
<img src="{{ asset( imageAlias.uri ) }}" width="{{ imageAlias.width }}" height="{{ imageAlias.height }}" alt="{{ field.value.alternativeText }}" />
```

#### With the REST API

Image Fields within REST are exposed by the `application/vnd.ez.api.Content` media-type. An Image Field will look like this:

``` xml
<field>
    <id>1480</id>
    <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
    <languageCode>eng-GB</languageCode>
    <fieldValue>
        <value key="inputUri">/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
        <value key="alternativeText"></value>
        <value key="fileName">kidding.png</value>
        <value key="fileSize">37931</value>
        <value key="imageId">240-1480</value>
        <value key="uri">/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
        <value key="variations">
            <value key="articleimage">
                <value key="href">/api/ezp/v2/content/binary/images/240-1480/variations/articleimage</value>
            </value>
            <value key="articlethumbnail">
                <value key="href">/api/ezp/v2/content/binary/images/240-1480/variations/articlethumbnail</value>
            </value>
        </value>
    </fieldValue>
</field>
```

Children of the `fieldValue` node will list the general properties of the Field's original image (`fileSize`, `fileName`, `inputUri`, etc.), as well as variations. For each variation, a URI is provided. Requested through REST, this resource will generate the variation if it doesn't exist yet, and list the variation details:

``` xml
<ContentImageVariation media-type="application/vnd.ez.api.ContentImageVariation+xml" href="/api/ezp/v2/content/binary/images/240-1480/variations/tiny">
  <uri>/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding_tiny.png</uri>
  <contentType>image/png</contentType>
  <width>30</width>
  <height>30</height>
  <fileSize>1361</fileSize>
</ContentImageVariation>
```

#### From PHP code

##### Getting an image variation

The variation service, `ezpublish.fieldType.ezimage.variation_service`, can be used to generate/get variations for a Field. It expects a VersionInfo, the Image Field, and the variation name as a string (`large`, `medium`, etc.)

``` php
$variation = $imageVariationHandler->getVariation(
    $imageField, $versionInfo, 'large'
);

echo $variation->uri;
```

### Manipulating image content

#### From PHP

As for any Field Type, there are several ways to input content to a Field. For an Image, the quickest is to call `setField()` on the ContentStruct:

``` php
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$createStruct->setField( 'image', '/tmp/image.png' );
```

In order to customize the Image's alternative texts, you must first get an `Image\Value` object, and set this property. For that, you can use the `Image\Value::fromString()` method that accepts the path to a local file:

``` php
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$imageField = \eZ\Publish\Core\FieldType\Image\Value::fromString( '/tmp/image.png' );
$imageField->alternativeText = 'My alternative text';
$createStruct->setField( 'image', $imageField );
```

You can also provide a hash of `Image\Value` properties, either to `setField()`, or to the constructor:

``` php
$imageValue = new \eZ\Publish\Core\FieldType\Image\Value(
    [
        'id' => '/tmp/image.png',
        'fileSize' => 37931,
        'fileName' => 'image.png',
        'alternativeText' => 'My alternative text'
    ]
);

$createStruct->setField( 'image', $imageValue );
```

#### From REST

The REST API expects Field values to be provided in a hash-like structure. Those keys are identical to those expected by the `Image\Value` constructor: `fileName`, `alternativeText`. In addition, image data can be provided using the `data` property, with the image's content encoded as base64.

##### Creating an Image Field

```
<?xml version="1.0" encoding="UTF-8"?>
<ContentCreate>
    <!-- [...metadata...] -->

    <fields>
        <field>
            <id>247</id>
            <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
            <languageCode>eng-GB</languageCode>
            <fieldValue>
                <value key="fileName">rest-rocks.jpg</value>
                <value key="alternativeText">HTTP</value>
                <value key="data"><![CDATA[/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG
                    BwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2[...]</value>
            </fieldValue>
        </field>
    </fields>
</ContentCreate>
```

#### Updating an Image Field

Updating an Image Field requires that you re-send existing data. This can be done by re-using the Field obtained via REST, **removing the variations key**, and updating `alternativeText`, `fileName` or `data`. If you do not want to change the image itself, do not provide the `data` key.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<VersionUpdate>
    <fields>
        <field>
            <id>247</id>
            <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
            <languageCode>eng-GB</languageCode>
            <fieldValue>
                <value key="id">media/images/507-1-eng-GB/Existing-image.png</value>
                <value key="alternativeText">Updated alternative text</value>
                <value key="fileName">Updated-filename.png</value>
            </fieldValue>
        </field>
    </fields>
</VersionUpdate>
```

### Naming

Each storage engine determines how image files are named.

#### Legacy Storage Engine naming

Images are stored within the following directory structure:

`<varDir>/<StorageDir>/<ImagesStorageDir>/<FieldId[-1]>/<FieldId[-2]>/<FieldId[-3]>/<FieldId[-4]>/<FieldId>-<VersionNumber>-<LanguageCode>/`

With the following values:

- `VarDir` = `var` (default)
- `StorageDir` = `storage` (default)
- `ImagesStorageDir` = `images` (default)
- `FieldId` = `1480`
- `VersionNumber` = `1`
- `LanguageCode` = `eng-GB`

Images will be stored in `web/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB`.

Using the Field ID digits in reverse order as the folder structure maximizes sharding of files through multiple folders on the filesystem.

Within this folder, images will be named like the uploaded file, suffixed with an underscore and the variation name:

- `MyImage.png`
- `MyImage_large.png`
- `MyImage_rss.png`

## ImageAsset Field Type

ImageAsset Field Type enables storing images in independent Content items of a generic Image content type, in the media library. It makes them reusable across system.

#### Input expectations

Example array:

|Type|Description|Example|
|------|------|------|
|`eZ\Publish\Core\FieldType\ImageAsset\Value`|ImageAsset Field Type value object|See below.|
|`eZ\Publish\API\Repository\Values\Content\ContentInfo`|ContentInfo instance of the Asset Content item |n/a|
|`string`| ID of the Asset Content item |`"150"`|
|`integer`| ID of the Asset Content item | `150`|

#### Value object

###### Properties

Value object of `ezimageasset` contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `destinationContentId`  |  `int` | Related content ID. |
| `alternativeText`  |  `string` |  The alternative image text (for example "Picture of an apple."). |

``` php
// Value object content example

$imageAssetValue->destinationContentId = $contentInfo->id;
$imageAssetValue->alternativeText = "Picture of an apple.";
```

###### Constructor

The `ImageAsset\Value` constructor will initialize a new value object with the value provided. It expects an ID of content object representing asset and the alternative text.

``` php
// Constructor example

// Instantiates a ImageAsset Value object
$imageAssetValue  = new ImageAsset\Value($contentInfo->id, "Picture of an apple.");
```

#### Validation

This Field Type validates if:

- `destinationContentId` points to Content Object which has correct Content Type

#### Configuration

ImageAsset Field Type allows configuring the following options:

|Name|Description|Default value|
|----|-----------|-------------|
|`content_type_identifier`|Content type used to store assets.|`image`|
|`content_field_identifier`|Field identifier used for asset data.|`image`|
|`name_field_identifier`|Field identifier used for asset name.|`name`|
|`parent_location_id`|Location where the assets are created.|`51`|

Example configuration:

``` yaml
ezplatform:
    system:
       default:
            fieldtypes:
                ezimageasset:
                    content_type_identifier: photo
                    content_field_identifier: image
                    name_field_identifier: title
                    parent_location_id: 106
```

### Customizing ImageAsset Field Type rendering

Internally the Image Asset Type is rendered via subrequest (similar to other relation types). Rendering customization is possible by configuring view type `asset_image`:

```php
ezplatform:
    system:
       default:           
            content_view:
                asset_image:
                    default:
                        template: ::custom_image_asset_template.html.twig
                        match: []
```

### Generating image variation from the Image Asset

Thanks to the `eZ\Bundle\EzPublishCoreBundle\Imagine\ImageAsset\AliasGenerator` decorator you can work with `\eZ\Publish\SPI\Variation\VariationHandler` in the same way as with [Image Field Type](#image-field-type).

## Integer Field Type

This Field Type represents an integer value.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Integer` | `ezinteger`   | `integer`      |

### PHP API Field Type 

#### Input expectations

|Type|Example|
|-------|------|
|`integer`|`2397`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `$value` | `int` | This property is used to store the value provided as an integer. |

``` php
// Value object content example
$integer->value = 8
```

###### Constructor

The `Integer\Value` constructor will initialize a new Value object with the value provided. It expects a numeric, integer value.

``` php
// Constructor example
use eZ\Publish\Core\FieldType\Integer;
 
// Instantiates a Integer Value object
$integerValue = new Integer\Value( 8 );
```

#### Hash format

Hash value of this Field Type is an integer value as a string.

Example: `"8"`

#### String representation

String representation of the Field Type's value will return the integer value as a string.

Example: `"8"`

#### Validation

This Field Type supports `IntegerValueValidator`, defining maximum and minimum float value:

|Name|Type|Default value|Description|
|------|------|------|------|
|`minIntegerValue`|`int`|`0`|This setting defines the minimum value this Field Type will allow as input.|
|`maxIntegerValue`|`int`|`null`|This setting defines the maximum value this Field Type will allow as input.|

``` php
// Example of validator configuration in PHP
$validatorConfiguration = [
    "minIntegerValue" => 1,
    "maxIntegerValue" => 24
];
```

#### Settings

This Field Type does not support settings.

## ISBN Field Type

This Field Type represents an ISBN string either an ISBN-10 or ISBN-13 format.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `ISBN` | `ezisbn`      | `string`            |

### PHP API Field Type 

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$isbn`  | `string` | This property will be used for the ISBN string. |

###### String representation

An ISBN's string representation is the `$isbn` property's value, as a string.

###### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts a string as argument and will set it to the `isbn` attribute.

#### Validation

The input passed into this Field Type is subject of ISBN validation depending on the Field settings in its FieldDefinition stored in the Content Type. An example of this Field setting is shown below and will control if input is validated as ISBN-13 or ISBN-10:

``` php
Array
(
    [isISBN13] => true
)
```


## Keyword Field Type

This Field Type stores one or several comma-separated keywords as a string or array of strings.

| Name      | Internal name | Expected input|
|-----------|---------------|---------------|
| `Keyword` | `ezkeyword`   | `string[]|string` |

### PHP API Field Type 

#### Input expectations

|Type|Example|
|------|------|
|`string`|`"documentation"`|
|`string`|`"php, Ibexa Platform, html5"`|
|`string[]`|`[ "Ibexa", "Enterprise", "User Experience Management" ]`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type       | Description|
|----------|------------|------------|
| `$value` | `string[]` | Holds an array of keywords as strings.|

``` php
// Value object content example
use eZ\Publish\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object
$keywordValue = new Value();
 
// Sets an array of keywords as a value
$keyword->value = [ "php", "css3", "html5", "Ibexa Platform" ];
```

##### Constructor

The `Keyword\Value` constructor will initialize a new Value object with the value provided.

It expects a list of keywords, either comma-separated in a string or as an array of strings.

``` php
// Constructor example
use eZ\Publish\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object with an array of keywords
$keywordValue = new Value( [ "php5", "css3", "html5" ] );
 
// Instantiates a Value object with a list of keywords in a string
// This is equivalent to the example above
$keywordValue = new Value( "php5,css3,html5" );
```

## MapLocation Field Type

This Field Type represents a geographical location.

As input it expects three values:
- two float values latitude and longitude,
- a string value, corresponding to the name or address of the location.

| Name          | Internal name    | Expected input |
|---------------|------------------|----------------|
| `MapLocation` | `ezgmaplocation` | `mixed`        |

### PHP API Field Type 

#### Input expectations

|Type|Example|
|------|------|
|`array`|`[ 'latitude' => 59.928732, 'longitude' => 10.777888, 'address' => "Ibexa Nordics" ]`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

|Property|Type|Description|
|------|------|------|
|`$latitude`|`float`|This property stores the latitude value of the map location reference.|
|`$longitude`|`float`|This property stores the longitude value of the map location reference.|
|`$address`|`string`|This property stores the address of map location.|

###### Constructor

The `MapLocation\Value` constructor will initialize a new Value object with values provided as hash. Accepted keys are `latitude` (`float`), `longitude` (`float`), `address` (`string`).

``` php
// Constructor example

// Instantiates a MapLocation Value object
$MapLocationValue = new MapLocation\Value(
                        [
                            'latitude' => 59.928732,
                            'longitude' => 10.777888,
                            'address' => "Ibexa Nordics"
                        ]
                    );
```

### Template rendering

The template called by [the `ez_render_field()` Twig function](../guide/twig_functions_reference.md#ez_render_field) while rendering a Map Location Field accepts the following parameters:

|Parameter|Type|Default|Description|
|------|------|------|------|
|`draggable`|`boolean`|`true`|Whether to enable a draggable map|
|`height`|`string|false`|`"200px"`|The height of the rendered map with its unit (for example "200px" or "20em"), set to false to not set any height style inline.|
|`mapType`|`string`|`"ROADMAP"`|[One of the GMap types of map](https://developers.google.com/maps/documentation/javascript/maptypes#BasicMapTypes)|
|`scrollWheel`|`boolean`|`true`| Allows you to disable scroll wheel starting to zoom when mouse comes over the map as user scrolls down a page.|
|`showInfo`|`booolean`|`true`|Whether to show a latitude, longitude and the address outside of the map|
|`showMap`|`boolean`|`true`|Whether to show a Google Map|
|`width`|`string|false`|`"500px"`|The width of the rendered map with its unit (for example "500px" or "50em"), set to false to not set any width style inline.|
|`zoom`|`integer`|`13`|The initial zoom level on the map|

Example:

``` html+twig
{{ ez_render_field(content, 'location', {'parameters': {'width': '100%', 'height': '330px', 'showMap': true, 'showInfo': false}}) }}
```

#### Configuration

| Config | SiteAccess/Group-aware | Description |
|--------|-------------------------|-------------|
| `api_keys.google_maps` | yes | Google maps requires the use of an API key for serving maps to web pages. This setting allows you to specify your personal [Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key) used during template rendering. |

Example use:

``` yaml
# ezplatform.yaml
ezplatform:
    system:
        site_group:
            api_keys: { google_maps: MY_KEY }
```

!!! note

    The option to automatically get user coordinates through the "Locate me" button
    is only available when the back office is served through the `https://` protocol.

## Matrix Field Type

This Field represents and handles a table of rows and columns of data.

| Name     | Internal name | Expected input |
|----------|---------------|----------------|
| `Matrix` | `ezmatrix`    | `array`        |

The Matrix Field Type is available via the Matrix Bundle
provided by the [ezplatform-matrix-fieldtype](https://github.com/ezsystems/ezplatform-matrix-fieldtype) package.

### PHP API Field Type

#### Input expectations

|Type|Description|Example|
|------|------|------|
|`array`|array of `EzSystems\EzPlatformMatrixFieldtype\FieldType\Value\Row` objects which contain column data|see below|

Example of input:

```php
new FieldType\Value([
    new FieldType\Value\Row(['col1' => 'Row 1, Col 1', 'col2' => 'Row 1, Col 2']),
    new FieldType\Value\Row(['col1' => 'Row 2, Col 1', 'col2' => 'Row 2, Col 2']),
    new FieldType\Value\Row(['col1' => 'Row 3, Col 1', 'col2' => 'Row 3, Col 2']),
]);
```

#### Value Object

`EzSystems\EzPlatformMatrixFieldtype\FieldType\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`rows`|`RowsCollection`|Array of `Row` objects containing an array of cells (`Row::getCells()` returns array `['col1' => 'Value 1', /* ... */]`)|

#### Validation

The minimum number of rows is set on Content Type level for each Field.

Validation checks for empty rows. A row is considered empty if it contains only empty cells (or cells containing only spaces). Empty rows are removed.

If, after removing empty rows, the number of rows does not fulfill the configured `Minimum number of rows`, the Field will not validate.

For example, the following input will not validate if `Minimum number of rows` is set to 3, because the second row is empty:

```php
new FieldType\Value([
    new FieldType\Value\Row(['col1' => 'Row 1, Col 1', 'col2' => 'Row 1, Col 2']),
    new FieldType\Value\Row(['col1' => '', 'col2' => '']),
    new FieldType\Value\Row(['col1' => 'Row 3, Col 1', 'col2' => 'Row 3, Col 2']),
]);
```

### GraphQL Field Type operations

To get a Field of the Matrix Field Type with GraphQL, you will need to specify a Content ID, a Content Type, and a Field Type.

The types that are returned are named after the Type and the Field:

- `{TypeIdentifier}{FieldIdentifier}Row`

The example below shows a GraphQL query for a Recipe Content item (belonging to a Content Type with a Matrix Field added), that has two Fields:

- `name`: `ezstring`
- `ingredients`: `ezmatrix` with two columns: `ingredient` and `quantity`

```
{
  content {
    recipe(id: 123) {
      name
      ingredients {
        ingredient
        quantity
      }
    }
  }
}
```

The Type returned for the Matrix Field exposes columns defined in the Field definition:

```
{
  "data": {
    "content": {
      "recipe": {
        "name": "Cake ingredients",
        "ingredients": [
          {
            "ingredient": "Butter",
            "quantity": "200 grams"
          },
          {
            "ingredient": "Sugar",
            "quantity": "100 grams"
          }
        ]
      }
    }
  }
}
```

#### Query for the Field Type and Field definition's details

With this query you can inspect details of specific Content Type. In case of a Matrix Field, you can ask for the list of columns, their names and identifiers.

```
{
  content {
    _types {
      recipe {
        ingredients {
          settings {
            minimumRows
            columns {
              name
              identifier
            }
          }
        }
      }
    }
  }
}
```

The response will list the exposed Field Type settings:

- minimumRows
- columns
    - name
    - identifier

Example response:

```
{
  "data": {
    "content": {
      "_types": {
        "recipe": {
          "ingredients": {
            "settings": {
              "minimumRows": 1,
              "columns": [
                {
                  "name": "ingredient",
                  "identifier": "ingredient"
                },
                {
                  "name": "quantity",
                  "identifier": "quantity"
                }
              ]
            }
          }
        }
      }
    }
  }
}
```

#### Mutation

To create a Matrix Field Type you need to define Field Type and Field definition identifiers.
The types that are used for input are named after the Type and the Field:

- `{TypeIdentifier}{FieldIdentifier}RowInput` e.g. `dish.nutritionFacts`, `event.agenda`: `DishNutritionFactsRowInput`, `EventAgendaRowInput`

The example below shows how to create a Recipe Content item (belonging to a Content Type with a Matrix Field Type added) that has two Fields:

- `name`: `"Cake Ingredient List"`
- `ingredients`: `ezmatrix` with two columns: `ingredient` and `quantity`

```
 mutation AddRecipe {
  createRecipe(
    language: eng_GB
    parentLocationId: 2,
    input: {
      name: "Cake Ingredient List",
      ingredients: [
        {ingredient: "sugar", quantity: "100 grams"}
        {ingredient: "butter", quantity: "200 grams"}
      ]
    }
  ) {
    name
  }
}
```

The response will confirm creation of the new Recipe Field:

```
{
  "data": {
    "createRecipe": {
      "name": "Cake Ingredient List"
    }
  }
}

```

## Media Field Type

This Field Type represents and handles a media (audio/video) binary file.

It is capable of handling the following types of files:

- Apple QuickTime
- Adobe Flash
- Microsoft Windows Media
- Real Media
- Silverlight
- HTML5 Video
- HTML5 Audio

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Media` | `ezmedia`     | mixed        |

### PHP API Field Type 

#### Input expectations

| Type | Description | Example|
|------|-------------|--------|
| `string` | Path to the media file.| `/Users/jane/butterflies.mp4`     |
| `eZ\Publish\Core\FieldType\Media\Value` | Media Field Type Value Object with path to the media file as the value of `id` property. | See below. |

#### Value object

###### Properties

`eZ\Publish\Core\FieldType\Media\Value` offers the following properties.

Note that both `Media` and `BinaryFile` Value and Type inherit from the `BinaryBase` abstract Field Type and share common properties.

|Property|Type|Description|Example|
|------|------|------|------|
|`id`|string|Media file identifier. This ID depends on the [IO Handler](../guide/clustering.md#dfs-io-handler) that is being used. With the native, default handlers (FileSystem and Legacy), the ID is the file path, relative to the binary file storage root dir (`var/<vardir>/storage/original` by default).|application/63cd472dd7819da7b75e8e2fee507c68.mp4|
|`fileName`|string|	The human-readable file name, as exposed to the outside. Used to name the file when sending it for download.|butterflies.mp4|
|`fileSize`|int|File size, in bytes.|1077923|
|`mimeType`|string|The file's MIME type.|video/mp4|
|`uri`|string|The binary file's HTTP URI. If the URI doesn't include a host or protocol, it applies to the request domain. **The URI is not publicly readable, and must NOT be used to link to the file for download.** Use `ez_render_field` to generate a valid link to the download controller.|/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.mp4|
|`hasController`|boolean|Whether the media has a controller when being displayed.|true|
|`autoplay`|boolean|Whether the media should be automatically played.|true|
|`loop`|boolean|Whether the media should be played in a loop.|false|
|`height`|int|Height of the media.|300|
|`width`|int|Width of the media.|400|
|`path`|string|**deprecated**||

#### Hash format

The hash format mostly matches the value object. It has the following keys:

- `id`
- `path` (for backwards compatibility)
- `fileName`
- `fileSize`
- `mimeType`
- `uri`
- `hasController`
- `autoplay`
- `loop`
- `height`
- `width`

#### Validation

The Field Type supports `FileSizeValidator`, defining maximum size of media file in bytes:

|Name|Type|Default value|Description|
|------|------|------|------|
|`maxFileSize`|`int`|`false`|Maximum size of the file in bytes.|

``` php
// Example of using Media Field Type validator in PHP

use eZ\Publish\Core\FieldType\Media\Type;

$contentTypeService = $repository->getContentTypeService();
$mediaFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "media", "ezmedia" );

// Setting maximum file size to 5 megabytes
$mediaFieldCreateStruct->validatorConfiguration = [
    "FileSizeValidator" => [
        "maxFileSize" => 5 * 1024 * 1024
    ]
];
```

#### Settings

The Field Type supports the `mediaType` setting, defining how the media file should be handled in output.

|Name|Type|Default value|Description|
|------|------|------|------|
|`mediaType`|mixed|`Type::TYPE_HTML5_VIDEO`|Type of the media, accepts one of the predefined constants.|

List of all available `mediaType` constants is defined in the `eZ\Publish\Core\FieldType\Media\Type` class:

|Name|Description|
|------|------|
|`TYPE_FLASH`|Adobe Flash|
|`TYPE_QUICKTIME`|Apple QuickTime|
|`TYPE_REALPLAYER`|Real Media|
|`TYPE_SILVERLIGHT`|Silverlight|
|`TYPE_WINDOWSMEDIA`|Microsoft Windows Media|
|`TYPE_HTML5_VIDEO`|HTML5 Video|
|`TYPE_HTML5_AUDIO`|HTML5 Audio|

``` php
// Example of using Media Field Type settings in PHP

use eZ\Publish\Core\FieldType\Media\Type;
 
$contentTypeService = $repository->getContentTypeService();
$mediaFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "media", "ezmedia" );

// Setting Adobe Flash as the media type
$mediaFieldCreateStruct->fieldSettings = [
    "mediaType" => Type::TYPE_FLASH,
];
```

## Null Field Type

This Field Type is used as fallback for migration scenarios, and for testing purposes.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Null` | variable    | mixed             |

### Description

The Null Field Type serves as an aid when migrating from eZ Publish Platform and earlier legacy versions. It is a dummy for legacy Field Types that are not implemented in [[= product_name =]].

Null Field Type will accept anything provided as a value and is usually combined with:
- NullConverter: Makes it not store anything to the legacy storage engine (database), nor will it read any data.
- Unindexed: Indexable class making sure nothing is indexed to configured search engine.

This Field Type does not have its own fixed internal name. Its identifier is instead configured as needed by passing it as an argument to the constructor.

#### Example for usage of Null Field Type

The following example shows how an `example` Field Type could be configured as a Null Field Type:

``` yaml
# Null Fieldtype example configuration
services:
    ezpublish.fieldType.example:
        class: eZ\Publish\Core\FieldType\Null\Type
        autowire: true
        autoconfigure: false
        arguments: [example]
        tags: [{name: ezplatform.field_type, alias: example}]
    ezpublish.fieldType.example.converter:
        class: eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ezplatform.field_type.legacy_storage.converter, alias: example}]
    ezpublish.fieldType.example.indexable:
    class: '%ezpublish.fieldType.indexable.unindexed.class%'
    tags: [{name: ezplatform.field_type.indexable, alias: example}]
```

## Page Field Type [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Page Field Type represents a Page with a layout consisting of multiple zones. Each zone can in turn contain blocks.

Page Field Type is only used in the Page Content Type that is included in [[= product_name_exp =]].

| Name           | Internal name   | Expected input  |
|----------------|-----------------|-----------------|
| `Landing page` | `ezlandingpage` | `string (JSON)` |

!!! caution "Page Builder"

    If you create Content Type with both `ezlandingpage` and `ezuser` Field Types,
     you will not be redierected to Page Builder after selecting `Edit` or `Create`.
      This is caused by `ezuser` Field Type which requires separate handling. You will be redirected to the standard AdminUI edit or create mode.

### Layout and zones

Layout defines how a Page is divided into zones.

The placement of zones is defined in a template which is a part of the layout configuration. You can modify the template in order to define your own zone layout.

For information on how to create and configure new blocks for the Page, see [Page layouts](../guide/page_rendering.md#page-layouts).

### Blocks

For information on how to create and configure new blocks for the Page, see [Creating Page blocks](../extending/extending_page.md#creating-page-blocks).

### Rendering Pages

Page rendering takes place while editing or viewing.

When rendering a Page, its zones are passed to the layout as a `zones` array with a `blocks` array each. You can access them using twig (e.g. `{{ zones[0].id }}` ).

Each div that's a zone should have the `data-ez-zone-id` attribute with zone ID as a value for a zone container.

To render a block inside the layout, use the Twig `render_esi()` function to call `EzPlatformPageFieldTypeBundle:Block:render`.

The `renderAction` has the following parameters:

|Parameter|Description|
|---------|-----------|
|`locationId`|ID of the Location of the Content item which can be accessed by `contentInfo.id`|
|`blockId`|ID of the block which you want to render|
|`versionNo`|Version number of the Content item to render|
|`languageCode`|Language code of the Content item to render|

Example usage:

``` html+twig
{{ render_esi(controller('EzPlatformPageFieldTypeBundle\Controller\BlockController::renderAction', {
    'locationId': locationId,
    'blockId': block.id,
    'versionNo': versionInfo.versionNo,
    'languageCode': field.languageCode
})) }}
```

As a whole a sample layout could look as follows:

``` html+twig
<div>
    {# The required attribute for the displayed zone #}
    <div data-ez-zone-id="{{ zones[0].id }}">
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}
            {# for each block #}
            {% for block in blocks %}
                {# create a new layer with appropriate ID #}
                <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
                    {# render the block by using the "EzPlatformPageFieldTypeBundle\Controller\BlockController::renderAction" controller #}
                    {# location.id is the ID of the Location of the current Content item, block.id is the ID of the current block #}
                    {{ render_esi(controller('EzPlatformPageFieldTypeBundle\Controller\BlockController::renderAction', {
                        'locationId': locationId,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    })) }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```

## Rating Field Type

!!! caution

    The Rating Field Type is available in the back-end interface, but it does not have editing templates, which makes it unusable in practice.

    Follow [EZP-25802](https://jira.ez.no/browse/EZP-25802) for future progress on this Field Type.

## Relation Field Type

!!! caution "Deprecated"

    The Relation Field Type is deprecated since v2.0.

    Use [RelationList](#relationlist-field-type) with a selection limit instead.

This Field Type makes it possible to store and retrieve the value of a relation to another Content item.

| Name       | Internal name      | Expected input |
|------------|--------------------|----------------|
| `Relation` | `ezobjectrelation` | mixed        |

### PHP API Field Type 

#### Input expectations

|Type|Example|
|------|------|
|`string`|`"150"`|
|`integer`|`150`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property|Type| Description|
|---------|-----|-----------|
| `$destinationContentId` | `string|int|null` | This property is used to store the value provided, which represents the related content. |

``` php
// Value object content example

$relation->destinationContentId = $contentInfo->id;
```

###### Constructor

The `Relation\Value` constructor will initialize a new Value object with the value provided. It expects a mixed value.

``` php
// Constructor example

// Instantiates a Relation Value object
$relationValue = new Relation\Value( $contentInfo->id );
```

#### Validation

This Field Type validates whether the provided relation exists, but before that it will check that the value is either a string or an int.

#### Settings

The Field definition of this Field Type can be configured with three options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`selectionMethod`|`int`|`Relation\Type::SELECTION_BROWSE`| *This setting is not implemented yet, only one selection method is available.* |
|`selectionRoot`|`string`|`null`|This setting defines the selection root.|
|`selectionContentTypes`|`array`|`[]`|An array of Content Type IDs that are allowed for related Content|

``` php
// Relation FieldType example settings

use eZ\Publish\Core\FieldType\Relation\Type;

$settings = [
    "selectionMethod" => 1,
    "selectionRoot" => null,
    "selectionContentTypes" => []
];
```

## RelationList Field Type

This Field Type makes it possible to store and retrieve values of a relation to other Content items.

| Name           | Internal name          | Expected input |
|----------------|------------------------|----------------|
| `RelationList` | `ezobjectrelationlist` | `mixed`        |

### PHP API Field Type 

#### Input expectations

|Type|Description|Example|
|------|------|------|
|`int|string`|ID of the related Content item|`42`|
|`array`|An array of related Content IDs|`[ 24, 42 ]`|
|`eZ\Publish\API\Repository\Values\Content\ContentInfo`|ContentInfo instance of the related Content|n/a|
|`eZ\Publish\Core\FieldType\RelationList\Value`|RelationList Field Type Value Object|See below.|

#### Value Object

###### Properties

`eZ\Publish\Core\FieldType\RelationList\Value` contains the following properties:

|Property|Type|Description|Example|
|------|------|------|------|
|`destinationContentIds`|`array`|An array of related Content IDs|`[ 24, 42 ]`|

``` php
// Value object content example
$relationList->destinationContentId = [
    $contentInfo1->id,
    $contentInfo2->id,
    170
];
```

###### Constructor

The `RelationList\Value` constructor will initialize a new Value object with the value provided. It expects a mixed array as value.

``` php
//Constructor example

// Instantiates a RelationList Value object
$relationListValue = new RelationList\Value(
    [
        $contentInfo1->id,
        $contentInfo2->id,
        170
    ]
);
```

#### Validation

This Field Type validates if:

- the `selectionMethod` specified is `\eZ\Publish\Core\FieldType\RelationList\Type::SELECTION_BROWSE` or `\eZ\Publish\Core\FieldType\RelationList\Type::SELECTION_DROPDOWN`. A validation error is thrown if the value does not match.
- the `selectionDefaultLocation` specified is `null`, `string` or `integer`. If the type validation fails a validation error is thrown.
- the value specified in `selectionContentTypes` is an `array`. If not, a validation error in given.
- the number of Content items selected in the Field is not greater than the `selectionLimit`.

!!! note

    The dropdown selection method is not implemented yet.

#### Settings

The Field definition of this Field Type can be configured with the following options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`selectionMethod`|`mixed`|`SELECTION_BROWSE`|Method of selection in the back-end interface|
|`selectionDefaultLocation`|`string|integer`|`null`|ID of the default Location for the selection when using the back-end interface|
|`selectionContentTypes`|`array`|`[]`|An array of Content Type IDs that are allowed for related Content|

Following selection methods are available:

| Name| Description|
|-----|------------|
| `SELECTION_BROWSE` | Selection will use browse mode|
| `SELECTION_DROPDOWN` | *Not implemented yet* |

#### Validators

|Name|Type|Default value|Description|
|------|------|------|------|
|`RelationListValueValidator[selectionLimit]`|`integer`|`0`|The number of Content items that can be selected in the Field. When set to 0, any number can be selected|

``` php
// Example of using settings and validators configuration in PHP

use eZ\Publish\Core\FieldType\RelationList\Type;

$fieldSettings = [
    "selectionMethod" => Type::SELECTION_BROWSE,
    "selectionDefaultLocation" => null,
    "selectionContentTypes" => []
 ];

$validators = [
    "RelationListValueValidator" => [
        "selectionLimit" => 0,
    ]
];
```

## RichText Field Type

The RichText Field Type is available via the RichText Field Type Bundle provided by the [ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext) package.

This Field Type validates and stores structured rich text, and exposes it in several formats.

|Name|Internal name|Expected input|
|------|------|------|
|`RichText`|`ezrichtext`|mixed|

### PHP API Field Type 

#### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|XML document in one of the Field Type's input formats as a string.|See the example below.|
|`DOMDocument`|XML document in one of the Field Type's input formats as a `DOMDocument` object.|See the example below.|
|`EzSystems\EzPlatformRichText\eZ\FieldType\RichText\Value`|An instance of the Field Type's `Value` object.|See the example below.|

###### Input formats

The Field Type works with XML and also expects an XML value as input, whether as a string, `DOMDocument` object or Field Type's `Value` object. When the value is given as a string or a `DOMDocument` object, it will be checked for conformance with one of the supported input formats, then dispatched to the appropriate converter, to be converted to the Field Type's internal format. No conversion will be performed if providing the value in Field Type's internal format or as Field Type's `Value` object. In the latter case it will be expected that the `Value` object holds the value in the Field Type's internal format.

Currently supported input formats are described in the table below:

|Name|Description|
|------|------|
|[[= product_name =]]'s DocBook variant|Field Type's internal format|
|XHTML5 editing format|Typically used with in-browser HTML editor|
|Legacy eZXML format|Compatibility with legacy XML format, used by [XmlText Field Type](#xmltext-field-type)|

###### Example of the Field Type's internal format

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://docbook.org/ns/docbook"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml"
         xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom"
         version="5.0-variant ezpublish-1.0">
    <title ezxhtml:level="2">This is a title.</title>
    <para ezxhtml:class="paraClass">This is a paragraph.</para>
</section>
```

###### Example of the Field Type's XHTML5 edit format

This format is used by [[= product_name =]]'s Online Editor.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://ez.no/namespaces/ezpublish5/xhtml5/edit">
    <h2>This is a title.</h2>
    <p class="paraClass">This is a paragraph.</p>
</section>
```

For more information about internal format and input formats, see [Field Type's conversion test fixtures on GitHub](https://github.com/ezsystems/ezplatform-richtext/tree/master/tests/lib/eZ/RichText/Converter/Xslt/_fixtures).

For example, eZXML does not use explicit level attributes for `<header>` elements, instead `<header>` element levels are indicated through the level of nesting inside `<section>` elements.

###### Example of using XML document in internal format as a string

``` php
...

$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();

$contentType = $contentTypeService->loadContentTypeByIdentifier( "article" );
$contentCreateStruct = $contentService->newContentCreateStruct( $contentType, "eng-GB" );

$inputString = <<<DOCBOOK
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://docbook.org/ns/docbook"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml"
         xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom"
         version="5.0-variant ezpublish-1.0">
    <title ezxhtml:level="2">This is a title.</title>
    <para ezxhtml:class="paraClass">This is a paragraph.</para>
</section>
DOCBOOK;

$contentCreateStruct->setField( "description", $inputString );

...
```

#### Value object

`EzSystems\EzPlatformRichText\eZ\FieldType\RichText\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`xml`|`DOMDocument`|Internal format value as an instance of `DOMDocument`.|

### REST API specifics

#### Creating or updating Content

When creating RichText content with the REST API, it is possible to provide data as a string, using the `xml` fieldValue key:

``` xml
<fieldValue>
    <value key="xml">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0"&gt;
&lt;title ezxhtml:level="2"&gt;This is a title.&lt;/title&gt;
&lt;/section&gt;
</value>
</fieldValue>
```

When the value given over REST API is transformed into a Field Type's `Value` object, it will be treated as a string. This means you can use any supported input format for input over REST API.

## Selection Field Type

The Selection Field Type stores single selections or multiple choices from a list of options, by populating a hash with the list of selected values.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `Selection` | `ezselection` | mixed             |

### PHP API Field Type

#### Input expectations

| Type    | Example         |
|---------|-----------------|
| `array` | `[ 1, 2 ]` |

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property     | Type    | Description|
|--------------|---------|------------|
| `$selection` | `int[]` | This property is used for the list of selections, which is a list of integer values, or one single integer value. |

``` php
// Value object content examples

// Single selection
$value->selection = 1;

// Multiple selection
$value->selection = [ 1, 4, 5 ];
```

###### Constructor

The `Selection\Value` constructor accepts an array of selected element identifiers.

``` php
// Constructor example

// Instanciates a selection value with items #1 and #2 selected
$selectionValue = new Selection\Value( [ 1, 2 ] );
```

###### String representation

String representation of this Field Type is its list of selections as a string, concatenated with a comma.

Example: `"1,2,24,42"`

#### Hash format

Hash format of this Field Type is the same as Value object's `selection` property.

``` php
// Example of value in hash format

$hash = [ 1, 2 ];
```

#### Validation

This Field Type validates the input, verifying if all selected options exist in the Field definition and checks if multiple selections are allowed in the Field definition.
If any of these validations fail, a `ValidationError` is thrown, specifying the error message. When option validation fails, a list with the invalid options is also presented.

#### Settings

| Name         | Type      | Default value | Description|
|--------------|-----------|---------------|------------|
| `isMultiple` | `boolean` | `false`       | Used to allow or prohibit multiple selection from the option list. |
| `options`    | `hash`    | `[]`     | Stores the list of options defined in the Field definition.    |

``` php
// Selection Field Type example settings

use eZ\Publish\Core\FieldType\Selection\Type;

$settings = [
    "isMultiple" => true,
    "options" => [1 => 'One', 2 => 'Two', 3 => 'Three']
];
```

## TextBlock Field Type

The Field Type handles a block of multiple lines of unformatted text. It is capable of handling up to 16,777,216 characters.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `TextBlock` | `eztext`      | `string`            |

### PHP API Field Type

#### Input expectations

|Type|Example|
|----|-------|
|`string`|`"This is a block of unformatted text"`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

|Property|Type|Description|
|--------|----|-----------|
|`$text`|`string`|This property will be used for the text content.|

###### String representation

A TextBlock's string representation is the `$text` property's value, as a string.

###### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `$text` attribute.

#### Validation

This Field Type does not perform any special validation of the input value.

#### Settings

Settings contain only one option:

| Name       | Type      | Default value | Description|
|------------|-----------|---------------|------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing box in the back-end interface. |

## TextLine Field Type

This Field Type makes possible to store and retrieve a single line of unformatted text. It is capable of handling up to 255 characters.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `TextLine` | `ezstring`    | `string`            |

### PHP API Field Type

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$text`  | `string` | This property will be used for the text content. |

###### String representation

A TextLine's string representation is the `$text` property's value, as a string.

###### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `$text` attribute.

#### Validation

The input passed into this Field Type is subject to validation by the `StringLengthValidator`. The length of the string provided must be between the minimum length defined in `minStringLength` and the maximum defined in `maxStringLength`. The default value for both properties is 0, which means that the validation is disabled by default.
To set the validation properties, the `validateValidatorConfiguration()` method needs to be inspected, which will receive an array with `minStringLength` and `maxStringLength` like in the following representation:

```
Array
(
    [minStringLength] => 1
    [maxStringLength] => 60
)
```

## Time Field Type

This Field Type represents time information.

Date information is **not stored**.

What is stored is the number of seconds, calculated from the beginning of the day in the given or the environment timezone.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Time` | `eztime`      | mixed             |

### PHP API Field Type

#### Input expectations

If input value is of type `string` or `integer`, it will be passed directly to the [PHP's built-in `\DateTime` class](http://www.php.net/manual/en/datetime.construct.php) constructor, therefore the same input format expectations apply.

It is also possible to directly pass an instance of `\DateTime`.

|Type|Example|
|------|------|
|`string`|`"2012-08-28 12:20 Europe/Berlin"`|
|`integer`|`1346149200`|
|`\DateTime`|`new \DateTime()`|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type           | Description|
|----------|----------------|------------|
| `$time`  | `integer|null` | Holds the time information as a number of seconds since the beginning of the day. |

###### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts an integer representing the number of seconds since the beginning of the day.

###### String representation

String representation of the date value will generate the date string in the format "H:i:s" as accepted by [PHP's built-in `date()` function](http://www.php.net/manual/en/function.date.php).

|Character|Description|Example|
|---------|----------|--------|
|H|Two digit representation of an hour, 24-hour format, range 00 to 23 |12|
|i|Two digit representation of minutes, range 00 to 59|14|
|s|Two digit representation of seconds, range 00 to 59|56|

Example: `"12:14:56"`

#### Hash format

Value in hash format is an integer representing a number of seconds since the beginning of the day.

Example: `36000`

#### Validation

This Field Type does not perform validation of the input value.

#### Settings

The Field definition of this Field Type can be configured with several options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`useSeconds`|`boolean`|`false`|Used to control displaying of seconds in the output.|
|`defaultType`|`Type::DEFAULT_EMPTY Type::DEFAULT_CURRENT_TIME`|`Type::DEFAULT_EMPTY`|The constant used here defines default input value when using back-end interface.|

``` php
// Time Field Type example settings
use eZ\Publish\Core\FieldType\Time\Type;

$settings = [
    "defaultType" => DateAndTime::DEFAULT_EMPTY
];
```

### Template rendering

The template called by [the `ez_render_field()` Twig function](../guide/twig_functions_reference.md#ez_render_field) while rendering a Date Field has access to the following parameters:

| Parameter | Type     | Default | Description|
|-----------|----------|---------|------------|
| `locale`  | `string` |   n/a   | Internal parameter set by the system based on current request locale or, if not set, calculated based on the language of the Field. |

Example:

``` php
{{ ez_render_field(content, 'time') }}
```
 
## URL Field Type

This Field Type makes it possible to store and retrieve a URL. It is formed by the combination of a link and the respective text.

| Name  | Internal name | Expected input |
|-------|---------------|----------------|
| `Url` | `ezurl`       | `string`       |

### PHP API Field Type

#### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|Link content provided to the value.|"http://www.ibexa.co"|
|`string`|Text content that represents the stored link.|"Ibexa"|

#### Value object

###### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$link`  | `string` | This property stores the link provided to the value of this Field Type.                              |
| `$text`  | `string` | This property stores the text to represent the stored link provided to the value of this Field Type. |

``` php
// Value object content example

$url->link = "http://www.ibexa.co";
$url->text = "Ibexa";
```

###### Constructor

The `Url\Value` constructor initializes a new Value object with the provided value. It expects two comma-separated strings, corresponding to the link and text.

``` php
// Constructor example

// Instantiates an Url Value object
$UrlValue = new Url\Value( "http://www.ibexa.co", "Ibexa" );
```
#### Hash format

|Key|Type|Description|Example|
|------|------|------|------|
|`link`|`string`|Link content.|"http://ibexa.co"|
|`text`|`string`|Text content.|"Ibexa"|

```php
// Example of the hash value in PHP
$hash = [
    "link" => "http://ibexa.co",
    "text" => "Ibexa"
];

```

#### Validation

This Field Type does not perform validation.

#### Settings

This Field Type does not have settings.

## User Field Type

This Field Type validates and stores information about a user.

| Name   | Internal name | Expected input |
|--------|---------------|----------------|
| `User` | `ezuser`      | ignored        |

### PHP API Field Type

#### Value Object

|Property|Type|Description|Example|
|------|------|------|------|
|`hasStoredLogin`|`boolean`|Denotes if user has stored login.|`true`|
|`contentId`|`int|string`|ID of the Content item corresponding to the user.|`42`|
|`login`|`string`|Username.|`john`|
|`email`|`string`|The user's email address.|`john@smith.com`|
|`passwordHash`|`string`|Hash of the user's password.|`1234567890abcdef`|
|`passwordHashType`|`mixed`|Algorithm user for generating password hash as a `PASSWORD_HASH_*` constant defined in `eZ\Publish\Core\Repository\Values\User\User` class.|`User::PASSWORD_HASH_PHP_DEFAULT`|
|`maxLogin`|`int`|Maximum number of concurrent logins.|`1000`|

###### Available password hash types

|Constant|Description|
|------|------|
|`eZ\Publish\Core\Repository\Values\User\User::DEFAULT_PASSWORD_HASH`|Default password hash, used when none is specified, may change over time.|
|`eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_PHP_DEFAULT`|Passwords hashed by PHP's default algorithm, which may change over time.|
|`eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_BCRYPT`|Bcrypt hash of the password.|

!!! caution

    Using the MD5-based deprecated hash types is a security risk, because if the hashes are leaked, they are too easily broken by brute-force attacks.
    The plaintext type offers no security. It was only ever intended for testing, and should never be used now.

    We strongly recommend switching to one of the new hash types. If you do, it will be used for new users.
    Existing users will also have their hashes updated to the new type when they log in.
    (A mass update of all hashes is not possible, because this requires knowing the passwords, which only the users themselves do.)

    Removal notice: https://doc.ibexa.co/en/latest/releases/ez_platform_v3.0_deprecations/#password-hashes

## XmlText Field Type

The XmlText Field Type isn't officially supported by [[= product_name =]]. It can be installed by requiring `ezsystems/ezplatform-xmltext-fieldtype`. PlatformUI does not support WYSIWYG editing of Fields of this type.

This Field Type validates and stores formatted text using the eZ Publish legacy format, eZXML. 

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `XmlText` | `ezxmltext`   | `mixed`        |

### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|XML document in the Field Type internal format as a string.|See the example below.|
|`eZ\Publish\Core\FieldType\XmlText\Input`|An instance of the class implementing the Field Type's abstract `Input` class.|See the example below.|
|`eZ\Publish\Core\FieldType\XmlText\Value`|An instance of the Field Type's `Value` object.|See the example below.|

#### Example of the Field Type's internal format

``` xml
<?xml version="1.0" encoding="utf-8"?>
<section
    xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"
    xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
    xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/">
    <paragraph>This is a paragraph.</paragraph>
</section>
```

#### For XHTML Input

The XML output uses `<strong>` and `<em>` by default, respecting the semantic XHTML notation.

Learn more about `<strong>`, `<b>`, `<em>`, `<i>`:

- Learn more [about the semantic tags vs the presentational tags.](http://html5doctor.com/i-b-em-strong-element/)

### Input object API

`Input` object is intended as a vector for different input formats. It should accept input value in a foreign format and convert it to the Field Type's internal format.

It should implement the abstract `eZ\Publish\Core\FieldType\XmlText\Input` class, which defines only one method:

|Method|Description|
|------|------|
|`getInternalRepresentation`|The method returns the input value in the internal format.|

At the moment there is only one implementation of the `Input` class, `eZ\Publish\Core\FieldType\XmlText\Input\EzXml`, which accepts input value in the internal format, and therefore only performs validation of the input value.

``` php
// Example of using the Input object

...
 
use eZ\Publish\Core\FieldType\XmlText\Input\EzXml as EzXmlInput;

...

$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
 
$contentType = $contentTypeService->loadContentTypeByIdentifier( "article" );
$contentCreateStruct = $contentService->newContentCreateStruct( $contentType, "eng-GB" );

$inputString = <<<EZXML
<?xml version="1.0" encoding="utf-8"?>
<section
    xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"
    xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
    xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/">
    <paragraph>This is a paragraph.</paragraph>
</section>
EZXML;
 
$ezxmlInput = new EzXmlInput( $inputString );

$contentCreateStruct->setField( "description", $ezxmlInput );
 
...
```

### Value object API

`eZ\Publish\Core\FieldType\XmlText\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`xml`|`DOMDocument`|Internal format value as an instance of `DOMDocument`.|

### Validation

Validation of the internal format is performed in the `eZ\Publish\Core\FieldType\XmlText\Input\EzXml` class.

### Settings

Following settings are available:

|Name|Type|Default value|Description|
|------|------|------|------|
|`numRows`|`int`|`10`|Defines the number of rows for the online editor in the back-end interface.|
|`tagPreset`|`mixed`|`Type::TAG_PRESET_DEFAULT`|Preset of tags for the online editor in the back-end interface.|

#### Tag presets

Following tag presets are available as constants in the `eZ\Publish\Core\FieldType\XmlText` class:

|Constant|Description|
|------|------|
|`TAG_PRESET_DEFAULT`|Default tag preset.|
|`TAG_PRESET_SIMPLE_FORMATTING`|Preset of tags for online editor intended for simple formatting options.|

``` php
// Example of using settings in PHP

...
 
use eZ\Publish\Core\FieldType\XmlText\Type;

...

$contentTypeService = $repository->getContentTypeService();
$xmltextFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "description", "ezxmltext" );

$xmltextFieldCreateStruct->fieldSettings = [
    "numRows" => 25,
    "tagPreset" => Type::TAG_PRESET_SIMPLE_FORMATTING
];
 
...
```
