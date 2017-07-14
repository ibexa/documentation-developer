1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)
4.  [Under the Hood: How eZ Platform Works](31429659.html)
5.  [Content Model: Content is King!](31429709.html)
6.  [Content items, Content Types and Fields](31430275.html)

# Field Types reference

This page contains a reference of Field Types used in eZ Platform.

 

For the general Field Type documentation see [Field Type API and best practices](Field-Type-API-and-best-practices_31430767.html).If you are looking for the documentation on how to implement a custom Field Type, see the [Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html) tutorial.

A Field Type is the smallest possible entity of storage. It determines how a specific type of information should be validated, stored, retrieved, formatted and so on. eZ Platform comes with a collection of fundamental types that can be used to build powerful and complex content structures. In addition, it is possible to extend the system by creating custom Field Types for special needs. Custom Field Types have to be programmed in PHP. However, the built-in Field Types are usually sufficient enough for typical scenarios. The following table gives an overview of the supported Field Types that come with eZ Platform.

### Built in Field Types

| FieldType                                              | Description                                                                                         | Searchable in Legacy Storage engine               | Searchable with Solr |
|--------------------------------------------------------|-----------------------------------------------------------------------------------------------------|---------------------------------------------------|----------------------|
| [Author](Author-Field-Type_31430499.html)              | Stores a list of authors, each consisting of author name and author email.                          | No                                                | Yes                  |
| [BinaryFile](BinaryField-Field-Type_31430501.html)     | Stores a file.                                                                                      | Yes                                               | Yes                  |
| [Checkbox](Checkbox-Field-Type_31430497.html)          | Stores a boolean value.                                                                             | Yes                                               | Yes                  |
| [Country](Country-Field-Type_31430503.html)            | Stores country names as a string.                                                                   | Yes\*                                             | Yes                  |
|  [DateAndTime](DateAndTime-Field-Type_31430505.html)   | Stores a full date including time information.                                                      | Yes                                               | Yes                  |
|  [Date](Date-Field-Type_31430507.html)                 | Stores date information.                                                                            | Yes                                               | Yes                  |
|  [EmailAddress](EmailAddress-Field-Type_31430509.html) | Validates and stores an email address.                                                              | Yes                                               | Yes                  |
|  [Float](Float-Field-Type_31430511.html)               | Validates and stores a decimal value.                                                               | No                                                | Yes                  |
|  [Image](Image-Field-Type_31430513.html)               | Validates and stores an image.                                                                      | No                                                | Yes                  |
|  [Integer](Integer-Field-Type_31430515.html)           | Validates and stores an integer value.                                                              | Yes                                               | Yes                  |
|  [ISBN](ISBN-Field-Type_31430517.html)                 | Handles International Standard Book Number (ISBN) in 10-digit or 13-digit format.                   | Yes                                               | Yes                  |
|  [Keyword](Keyword-Field-Type_31430519.html)           | Stores keywords.                                                                                    | Yes\* &gt;= 1.7.0                                 | Yes                  |
| [Landing Page](31430521.html)                          | Stores a page with a layout consisting of multiple zones.                                           | N/A                                               | N/A                  |
|  [MapLocation](MapLocation-Field-Type_31430523.html)   | Stores map coordinates.                                                                             | Yes, with MapLocationDistance criterion           | Yes                  |
|  [Media](Media-Field-Type_31430525.html)               | Validates and stores a media file.                                                                  | No                                                | Yes                  |
|  [Null](Null-Field-Type_31430527.html)                 | Used as fallback for missing Field Types and for testing purposes.                                  | N/A                                               | N/A                  |
|  [Rating](Rating-Field-Type_31430531.html)             | Stores a rating.                                                                                    | No *(will need own Criterion)*                    | No                   |
|  [Relation](Relation-Field-Type_31430533.html)         | Validates and stores a relation to a Content item.                                                  | Yes, with both Field and FieldRelation criterions | Yes                  |
|  [RelationList](RelationList-Field-Type_31430535.html) | Validates and stores a list of relations to Content items.                                          | Yes, with FieldRelation criterion                 | Yes                  |
| [RichText](RichText-Field-Type_31430537.html)          | Validates and stores structured rich text in docbook xml format, and exposes it in several formats. | Yes\*                                             | Yes                  |
|  [Selection](Selection-Field-Type_31430539.html)       | Validates and stores a single selection or multiple choices from a list of options.                 | Yes\*                                             | Yes                  |
|  [TextBlock](TextBlock-Field-Type_31430541.html)       | Validates and stores a larger block of text.                                                        | Yes\* &gt;= 1.7.1                                 | Yes                  |
|  [TextLine](TextLine-Field-Type_31430545.html)         | Validates and stores a single line of text.                                                         | Yes                                               | Yes                  |
|  [Time](Time-Field-Type_31430543.html)                 | Stores time information.                                                                            | Yes                                               | Yes                  |
|  [Url](Url-Field-Type_31430547.html)                   | Stores a URL / address.                                                                             | No                                                | Yes                  |
|  [User](User-Field-Type_31430549.html)                 | Validates and stores information about a user.                                                      | No                                                | No                   |

*\*Legacy Search/Storage Engine index is limited to 255 characters in database design, so formatted or unformatted text blocks will only index first part, and in case of multiple selection field types like keyword, selection, country and so on only the first choices, and only as a text blob separated by string separator. Proper indexing of these field types are done with [Solr Search Bundle](Solr-Bundle_31430592.html).*

### Field Types provided by Community

<table>
<thead>
<tr class="header">
<th>FieldType</th>
<th>Description</th>
<th>Searchable</th>
<th>Editing support in Platform UI</th>
<th>Planned to be incl in the future</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><a href="https://github.com/netgen/TagsBundle" class="external-link">Tags</a></td>
<td>Tags field and full fledge taxonomy management</td>
<td>Yes</td>
<td><span style="color: rgb(51,51,51);"><span style="color: rgb(153,51,0);"><span>Yes <span class="status-macro aui-lozenge aui-lozenge-success aui-lozenge-subtle">&gt;= 3.0.0 (BUNDLE VERSION)</span></span><br />
</span></span></td>
<td>Yes <span class="status-macro aui-lozenge aui-lozenge-success aui-lozenge-subtle">&gt;= 1.9.0 (IN STUDIO DEMO INSTALL)</span></td>
</tr>
<tr class="even">
<td><a href="https://github.com/ezcommunity/EzPriceBundle" class="external-link">Price</a></td>
<td>Price field for product catalog use</td>
<td>Yes</td>
<td><span style="color: rgb(153,51,0);">No</span></td>
<td>Yes</td>
</tr>
<tr class="odd">
<td><a href="https://github.com/ezcommunity/EzMatrixFieldTypeBundle" class="external-link">Matrix</a></td>
<td>Matrix field for matrix data</td>
<td>Yes</td>
<td><span style="color: rgb(153,51,0);">No</span></td>
<td>Yes</td>
</tr>
<tr class="even">
<td><span class="confluence-link"><a href="XmlText-Field-Type_31430551.html">XmlText</a> </span><span> </span></td>
<td><span>Validates and stores multiple lines of formatted text using xml format.</span></td>
<td>Yes</td>
<td>Partial <em>(Raw xml editing)</em></td>
<td>No <em>(has been superseded by RichText)</em></td>
</tr>
</tbody>
</table>

### Known missing Field Types

The following Field Types are configured using [Null Field Type](Null-Field-Type_31430527.html) to avoid exceptions if they exists in your database, but their functionality is currently not known to be implemented out of the box or by the community: [![](https://jira.ez.no/images/icons/issuetypes/story.png)EZP-20112](https://jira.ez.no/browse/EZP-20112?src=confmacro) - Some Shop FieldTypes are not supported by Public API Backlog [![](https://jira.ez.no/images/icons/issuetypes/story.png)EZP-20115](https://jira.ez.no/browse/EZP-20115?src=confmacro) - eZ Identifier FieldType not supported by Public API Backlog [![](https://jira.ez.no/images/icons/issuetypes/story.png)EZP-20118](https://jira.ez.no/browse/EZP-20118?src=confmacro) - eZ Password Expiry FieldType not supported by Public API Backlog *Missing something? For field types provided by community, like for instance `ezselection2`, unless otherwise mentioned it can be considered missing for the time being. If something should be listed here, add a comment.* 

### Generate new Field Type

Besides links in the top of this topic in regards to creating own field type, from partner Smile there is now a [Field Type Generator Bundle](https://github.com/Smile-SA/EzFieldTypeGeneratorBundle) helping you get started creating skeleton for eZ Platform field type, including templates for editorial interface. 

#### Related topics:

-   [Content items, Content Types and Fields](31430275.html)



# Author Field Type


Field Type representing a list of authors, consisting of author name, and author email.

 

| Name     | Internal name | Expected input | Output   |
|----------|---------------|----------------|----------|
| `Author` | `ezauthor`    | `Mixed`        | `String` |

## Description

This Field Type allows the storage and retrieval of additional authors. For each author, it is capable of handling a name and an e-mail address. It is typically useful when there is a need for storing information about additional authors who have written/created different parts of a Content item.

 
# BinaryField Field Type


This Field Type represents and handles a binary file. It also counts the number of times the file has been downloaded from the `content/download` module.

| Name         | Internal name  | Expected input | Output  |
|--------------|----------------|----------------|---------|
| `BinaryFile` | `ezbinaryfile` | `Mixed`        | `Mixed` |

## Description

This Field Type allows the storage and retrieval of a single file. It is capable of handling virtually any file type and is typically used for storing legacy document types such as PDF files, Word documents, spreadsheets, etc. The maximum allowed file size is determined by the "Max file size" class attribute edit parameter and the "`upload_max_filesize`" directive in the main PHP configuration file ("php.ini").

## PHP API Field Type 

### Value Object

`eZ\Publish\Core\FieldType\BinaryFile\Value` offers the following properties.

Note that both `BinaryFile` and Media Value and Type inherit from the `BinaryBase` abstract Field Type, and share common properties.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Attribute</th>
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>id</code></td>
<td>string</td>
<td><span>Binary file identifier. This ID depends on the </span><a href="https://doc.ez.no/display/DEVELOPER/Clustering#Clustering-Binaryfilesclustering">IO Handler</a><span> that is being used. With the native, default handlers (FileSystem and Legacy), the ID is the file path, relative to the binary file storage root dir (<code>var/&lt;vardir&gt;/storage/original</code> by default).</span></td>
<td>application/63cd472dd7819da7b75e8e2fee507c68.pdf</td>
</tr>
<tr class="even">
<td><code>fileName</code></td>
<td>string</td>
<td>The human readable file name, as exposed to the outside. Used when sending the file for download in order to name the file.</td>
<td>20130116_whitepaper_ezpublish5 light.pdf</td>
</tr>
<tr class="odd">
<td><code>fileSize</code></td>
<td>int</td>
<td>File size, in bytes.</td>
<td>1077923</td>
</tr>
<tr class="even">
<td><code>mimeType</code></td>
<td>string</td>
<td>The file's mime type.</td>
<td>application/pdf</td>
</tr>
<tr class="odd">
<td><code>uri</code></td>
<td>string</td>
<td><p>The binary file's content/download URI. If the URI doesn't include a host or protocol, it applies to the request domain.</p></td>
<td>/content/download/210/2707</td>
</tr>
<tr class="even">
<td><code>downloadCount</code></td>
<td>integer</td>
<td>Number of times the file was downloaded</td>
<td>0</td>
</tr>
<tr class="odd">
<td><code>path</code></td>
<td>string</td>
<td><p><strong>*deprecated*<br />
</strong> Renamed to <code>id</code> starting from eZ Publish 5.2. Can still be used, but it is recommended not to use it anymore as it will be removed.</p></td>
<td> </td>
</tr>
</tbody>
</table>

### Hash format

The hash format mostly matches the value object. It has the following keys:

-   `id`
-   `path` (for backwards compatibility)
-   `fileName`
-   `fileSize`
-   `mimeType`
-   `uri`
-   `downloadCount`

## REST API specifics

Used in the REST API, a BinaryFile Field will mostly serialize the hash described above. However there are a couple specifics worth mentioning.

### Reading content: url property

When reading the contents of a field of this type, an extra key is added: url. This key gives you the absolute file URL, protocol and host included.

Example: <http://example.com/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf>

### Creating content: data property

When creating BinaryFile content with the REST API, it is possible to provide data as a base64 encoded string, using the "`data`" fieldValue key:

``` brush:
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

 
# Checkbox Field Type


This field type represents a Checkbox status, checked or unchecked.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `Checkbox` | `ezboolean`   | `boolean`           |

## Description

The Checkbox Field Type stores the current status for a checkbox input, checked of unchecked, by storing a boolean value.

## PHP API Field Type 

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type      | Default value | Description                                                                                       |
|----------|-----------|---------------|---------------------------------------------------------------------------------------------------|
| `$bool`  | `boolean` | `false`       | This property will be used for the checkbox status, which will be represented by a boolean value. |

**Value object content examples**

``` brush:
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a default state (false)
$checkboxValue = new Checkbox\Value();
 
// Checked
$value->bool = true;

// Unchecked
$value->bool = false;
```

##### Constructor

The `Checkbox\Value` constructor accepts a boolean value:

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```

##### String representation

As this Field Type is not a string but a bool, it will return "1" (true) or "0" (false) in cases where it is cast to string.


# Country Field Type


This Field Type represents one or multiple countries.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Country` | `ezcountry`   | `array`        |

## Description

This Field Type makes possible to store and retrieve data representing countries.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>array</code></td>
<td><div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: true; theme: Eclipse" style="font-size:12px;"><code>array(
    &quot;JP&quot; =&gt; array(
        &quot;Name&quot; =&gt; &quot;Japan&quot;,
        &quot;Alpha2&quot; =&gt; &quot;JP&quot;,
        &quot;Alpha3&quot; =&gt; &quot;JPN&quot;,
        &quot;IDC&quot; =&gt; 81
    )
);</code></pre>
</div>
</div></td>
</tr>
</tbody>
</table>

Note: When you set an array directly on Content field you don't need to provide all this information, the Field Type will assume it is a hash and in this case will accept a simplified structure described below under [To / From Hash format](#CountryFieldType-ToFromHashFormat).

### Validation

This Field Type validates if the multiple countries are allowed by the field definition, and if the Alpha2 is valid according to the countries configured in eZ Platform.

### Settings

The field definition of this Field Type can be configured with one option:

| Name         | Type      | Default value | Description                                                                             |
|--------------|-----------|---------------|-----------------------------------------------------------------------------------------|
| `isMultiple` | `boolean` | `false`       | This setting allows (if true) or denies (if false) the selection of multiple countries. |

**Country FieldType example settings**

``` brush:
$settings = array(
    "isMultiple" => true
);
```

### To / From Hash format

The format used for serialization is simpler than the full format, this is also available when setting value on the content field, by setting the value to an array instead of the Value object. Example of that shown below:

**Value object content example**

``` brush:
$content->fields["countries"] = array( "JP", "NO" );
```

The format used by the toHash method is the Alpha2 value, however the input is capable of accepting either Name, Alpha2 or Alpha3 value as shown below in the Value object section.

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property     | Type      | Description                                                                                |
|--------------|-----------|--------------------------------------------------------------------------------------------|
| `$countries` | `array[]` | This property will be used for the country selection provided as input, as its attributes. |

**Value object content example**

``` brush:
$value->countries = array(
    "JP" => array(
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    )
)
```

##### Constructor

The `Country``\Value` constructor will initialize a new Value object with the value provided. It expects an array as input.

**Constructor example**

``` brush:
// Instantiates a Country Value object
$countryValue = new Country\Value(
    array(
        "JP" => array(
            "Name" => "Japan",
            "Alpha2" => "JP",
            "Alpha3" => "JPN",
            "IDC" => 81
        )
    )
);
```

 

# Date Field Type


This Field Type represents a date without time information.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Date` | `ezdate`      | `mixed`             |

## Description

This Field Type makes it possible to store and retrieve date information.

#### PHP API Field Type 

### Input expectations

If input value is of type **`string`** or **`integer`**, it will be passed directly to the [PHP's built-in **`\DateTime`** class constructor](http://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It is also possible to directly pass an instance of **`\DateTime`**.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><code>&quot;2012-08-28 12:20 Europe/Berlin&quot;</code></td>
</tr>
<tr class="even">
<td><pre><code>integer</code></pre></td>
<td><pre><code>1346149200</code></pre></td>
</tr>
<tr class="odd">
<td><pre><code>\DateTime</code></pre></td>
<td><pre><code>new \DateTime()</code></pre></td>
</tr>
</tbody>
</table>

Time information is **not stored**.

Before storing, the provided input value will be set to the the beginning of the day in the given or the environment timezone.

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description                                      |
|----------|-------------|--------------------------------------------------|
| `$date`  | `\DateTime` | This property will be used for the text content. |

##### String representation

String representation of the date value will generate the date string in the format "l d F Y" as accepted by [PHP's built-in **`date()`** function](http://www.php.net/manual/en/function.date.php).

Example:

> `Wednesday 22 May 2013`

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of [PHP's built-in **`\DateTime`** class](http://www.php.net/manual/en/datetime.construct.php).

### Hash format

Hash value of this Field Type is an array with two keys:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Key
</div></th>
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
<th><div class="tablesorter-header-inner">
Example
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>timestamp</code></p></td>
<td><code>integer</code></td>
<td>Time information as a <a href="http://en.wikipedia.org/wiki/Unix_time" class="external-link">timestamp</a>.</td>
<td><p><code>1400856992</code></p></td>
</tr>
<tr class="even">
<td><p><code>rfc850</code></p></td>
<td><code>string</code></td>
<td><p>Time information as a string in <a href="http://tools.ietf.org/html/rfc850" class="external-link">RFC 850 date format</a>.</p>
<p>As input, this will have higher precedence over the <strong><code>timestamp</code></strong> value.</p></td>
<td><code>&quot;Friday, 23-May-14 14:56:14 GMT+0000&quot;</code></td>
</tr>
</tbody>
</table>

**Example of the hash value in PHP**

``` brush:
$hash = array(
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
);
```

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

The field definition of this Field Type can be configured with one option:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>defaultType</code></pre></td>
<td><pre><code>mixed</code></pre></td>
<td><pre><code>Type::DEFAULT_EMPTY</code></pre></td>
<td><p>One of the <strong><code>DEFAULT_*</code></strong> constants, used by the administration interface for setting the default field value.</p>
<p>See below for more details.</p></td>
</tr>
</tbody>
</table>

Following **`defaultType`** default value options are available as constants in the **`eZ\Publish\Core\FieldType\Date\Type`**** **class:

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Constant</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>DEFAULT_EMPTY</code></pre></td>
<td>Default value will be empty.</td>
</tr>
<tr class="even">
<td><pre><code>DEFAULT_CURRENT_DATE</code></pre></td>
<td>Default value will use current date.</td>
</tr>
</tbody>
</table>

**Date FieldType example settings**

``` brush:
use eZ\Publish\Core\FieldType\Date\Type;

$settings = array(
    "defaultType" => Type::DEFAULT_EMPTY
);
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description                                                                                                                       |
|-----------|----------|---------|-----------------------------------------------------------------------------------------------------------------------------------|
| `locale`  | `string` |         | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` brush:
{{ ez_render_field(content, 'date') }}
```

 

# DateAndTime Field Type


This Field Type represents a full date including time information.

| Name          | Internal name | Expected input type |
|---------------|---------------|---------------------|
| `DateAndTime` | `ezdatetime`  | `mixed`             |

## Description

This Field Type makes possible to store and retrieve a full date including time information.

## PHP API Field Type 

### Input expectations

If input value is of type **`string`** or **`integer`**, it will be passed directly to the [PHP's built-in **`\DateTime`** class constructor](http://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It is also possible to directly pass an instance of **`\DateTime`**.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><code>&quot;2012-08-28 12:20 Europe/Berlin&quot;</code></td>
</tr>
<tr class="even">
<td><pre><code>integer</code></pre></td>
<td><pre><code>1346149200</code></pre></td>
</tr>
<tr class="odd">
<td><pre><code>\DateTime</code></pre></td>
<td><pre><code>new \DateTime()</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description                                                |
|----------|-------------|------------------------------------------------------------|
| `$value` | `\DateTime` | The date and time value as an instance of **`\DateTime`**. |

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of PHP's built-in **`\DateTime`** class.

##### String representation

String representation of the date value will generate the date string in the format "D Y-d-m H:i:s" as accepted by [PHP's built-in **`date()`** function](http://www.php.net/manual/en/function.date.php).

Example:

> `Wed 2013-22-05 12:19:18`
>
> ``

### Hash format

Hash value of this Field Type is an array with two keys:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Key</th>
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>timestamp</code></p></td>
<td><code>integer</code></td>
<td>Time information as a <a href="http://en.wikipedia.org/wiki/Unix_time" class="external-link">timestamp</a>.</td>
<td><p><code>1400856992</code></p></td>
</tr>
<tr class="even">
<td><p><code>rfc850</code></p></td>
<td><code>string</code></td>
<td><p>Time information as a string in <a href="http://tools.ietf.org/html/rfc850" class="external-link">RFC 850 date format</a>.</p>
<p>As input, this will have higher precedence over the <strong><code>timestamp</code></strong> value.</p></td>
<td><code>&quot;Friday, 23-May-14 14:56:14 GMT+0000&quot;</code></td>
</tr>
</tbody>
</table>

``` brush:
$hash = array(
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
);
```

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

The field definition of this Field Type can be configured with several options:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>useSeconds</code></td>
<td><code>boolean</code></td>
<td><code>false</code></td>
<td>Used to control displaying of seconds in the output.</td>
</tr>
<tr class="even">
<td><pre><code>defaultType</code></pre></td>
<td><pre><code>mixed</code></pre></td>
<td><pre><code>Type::DEFAULT_EMPTY</code></pre></td>
<td><p>One of the <strong><code>DEFAULT_*</code></strong> constants, used by the administration interface for setting the default field value.</p>
<p>See below for more details.</p></td>
</tr>
<tr class="odd">
<td><pre><code>dateInterval</code></pre></td>
<td><pre><code>null|\DateInterval</code></pre></td>
<td><pre><code>null</code></pre></td>
<td><p>This setting complements <strong><code>defaultType</code></strong> setting and can be used only when latter is set to <strong><code>Type::DEFAULT_CURRENT_DATE_ADJUSTED</code></strong>.</p>
<p>In that case the default input value when using administration interface will be adjusted by the given <strong><code>\DateInterval</code></strong>.</p></td>
</tr>
</tbody>
</table>

Following **`defaultType`** default value options are available as constants in the **`eZ\Publish\Core\FieldType\DateAndTime\Type`**** **class:

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Constant</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>DEFAULT_EMPTY</code></pre></td>
<td>Default value will be empty.</td>
</tr>
<tr class="even">
<td><pre><code>DEFAULT_CURRENT_DATE</code></pre></td>
<td>Default value will use current date.</td>
</tr>
<tr class="odd">
<td><pre><code>DEFAULT_CURRENT_DATE_ADJUSTED</code></pre></td>
<td><span><span>Default value will use current date, adjusted by the interval defined in </span></span><strong><code>dateInterval</code></strong><span style="line-height: 1.4285715;"> setting</span><span style="line-height: 1.4285715;">.</span></td>
</tr>
</tbody>
</table>

**DateAndTime FieldType example settings**

``` brush:
use eZ\Publish\Core\FieldType\DateAndTime\Type;

$settings = array(
    "useSeconds" => false,
    "defaultType" => Type::DEFAULT_EMPTY,
    "dateInterval" => null
);
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description                                                                                                                       |
|-----------|----------|---------|-----------------------------------------------------------------------------------------------------------------------------------|
| `locale`  | `string` |         | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` brush:
{{ ez_render_field(content, 'datetime') }}
```

 
# EmailAddress Field Type

This Field Type represents an email address, in the form of a string.

| Name           | Internal name | Expected input type |
|----------------|---------------|---------------------|
| `EmailAddress` | `ezemail`     | `string`            |

## Description

The EmailAddress Field Type stores an email address, which is provided as a string.

## PHP API Field Type 

### Value object

##### Properties

The **`Value`** class of this field type contains the following properties:

| Property | Type     | Description                                                                |
|----------|----------|----------------------------------------------------------------------------|
| `$email` | `string` | This property will be used for the input string provided as email address. |

**Value object content example**

``` brush:
use eZ\Publish\Core\FieldType\EmailAddress\Type;

// Instantiates an EmailAddress Value object with default value (empty string)
$emailaddressValue = new Type\Value();

// Email definition
$emailaddressValue->email = "someuser@example.com";
```

##### Constructor

The **`EmailAddress`****`\Value`** constructor will initialize a new Value object with the value provided. It accepts a string as input.

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\EmailAddress\Type;
 
// Instantiates an EmailAddress Value object
$emailaddressValue = new Type\Value( "someuser@example.com" );
```

##### String representation

String representation of the Field Type's Value object is the email address contained in it.

Example:

> `someuser@example.com`

### Hash format

Hash value for this Field Type's Value is simply the email address as a string.

Example:

> `someuser@example.com`

### Validation

This Field Type uses the **`EmailAddressValidator`** validator as a resource which will test the string supplied as input against a pattern, to make sure that a valid email address has been provided.
If the validations fail a **`ValidationError`**  is thrown, specifying the error message.

### Settings

This Field Type does not support settings.

 
# Float Field Type


This Field Type represents a float value.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Float` | `ezfloat`     | `float`        |

## Description

This Field Type stores numeric values which will be provided as floats.

## PHP API Field Type 

### Input expectations

The Field Type expects a number as input. Both decimal and integer numbers are accepted.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>float</code></td>
<td><p><code>194079.572</code></p></td>
</tr>
<tr class="even">
<td><code>int</code></td>
<td><code>144</code></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type    | Description                                                        |
|----------|---------|--------------------------------------------------------------------|
| `$value` | `float` | This property will be used to store the value provided as a float. |

**Value object content example**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value();

$float->value = 284.773
```

##### Constructor

The `Float``\Value` constructor will initialize a new Value object with the value provided. It expects a numeric value with or without decimals.

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value( 284.773 );
```

### Validation

This Field Type supports `FloatValueValidator`, defining maximal and minimal float value:

<table>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>minFloatValue</code></td>
<td><code>float</code></td>
<td><code>null</code><br />
</td>
<td>This setting defines the minimum value this FieldType will allow as input.</td>
</tr>
<tr class="even">
<td><code>maxFloatValue</code></td>
<td><code>float</code></td>
<td><code>null</code><br />
</td>
<td>This setting defines the maximum value this FieldType will allow as input.</td>
</tr>
</tbody>
</table>

**Validator configuration example in PHP**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

$contentTypeService = $repository->getContentTypeService();
$floatFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "float", "ezfloat" );

// Accept only numbers between 0.1 and 203.99
$floatFieldCreateStruct->validatorConfiguration = array(
    "FileSizeValidator" => array(  
        "minFloatValue" => 0.1,
        "maxFloatValue" => 203.99
    )
);
```

### Settings

This Field Type does not support settings.

 

# Image Field Type

Field Type identifier: `ezimage`
Validators: File size
Value object: `\eZ\Publish\Core\FieldType\Image\Value`
Associated Services: `ezpublish.fieldType.ezimage.variation_service`

The Image Field Type allows you to store an image file.

A **variation service** handles conversion of the original image into different formats and sizes through a set of preconfigured named variations: large, small, medium, black & white thumbnail, etc.

## PHP API Field Type

### Value object

The `value` property of an Image Field will return an `\eZ\Publish\Core\FieldType\Image\Value` object with the following properties:

##### Properties

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Example</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>id</code></td>
<td>string</td>
<td><code>0/8/4/1/1480-1-eng-GB/image.png  </code></td>
<td><p>The image's unique identifier. Usually the path, or a part of the path. To get the full path, use <code>URI</code> property.</p></td>
</tr>
<tr class="even">
<td><code>alternativeText</code></td>
<td>string</td>
<td><code>This is a piece of text</code></td>
<td>The alternative text, as entered in the Field's properties</td>
</tr>
<tr class="odd">
<td><code>fileName</code></td>
<td>string</td>
<td><code>image.png</code></td>
<td>The original image's filename, without the path</td>
</tr>
<tr class="even">
<td><code>fileSize</code></td>
<td>int</td>
<td><code>37931</code></td>
<td>The original image's size, in bytes</td>
</tr>
<tr class="odd">
<td><code>uri</code></td>
<td>string</td>
<td><code>var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image.png</code></td>
<td>The original image's URI</td>
</tr>
<tr class="even">
<td><code>imageId</code></td>
<td>string</td>
<td><code>240-1480</code></td>
<td>A special image ID, used by REST</td>
</tr>
</tbody>
</table>

# Float Field Type


This Field Type represents a float value.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Float` | `ezfloat`     | `float`        |

## Description

This Field Type stores numeric values which will be provided as floats.

## PHP API Field Type 

### Input expectations

The Field Type expects a number as input. Both decimal and integer numbers are accepted.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>float</code></td>
<td><p><code>194079.572</code></p></td>
</tr>
<tr class="even">
<td><code>int</code></td>
<td><code>144</code></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type    | Description                                                        |
|----------|---------|--------------------------------------------------------------------|
| `$value` | `float` | This property will be used to store the value provided as a float. |

**Value object content example**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value();

$float->value = 284.773
```

##### Constructor

The `Float``\Value` constructor will initialize a new Value object with the value provided. It expects a numeric value with or without decimals.

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value( 284.773 );
```

### Validation

This Field Type supports `FloatValueValidator`, defining maximal and minimal float value:

<table>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>minFloatValue</code></td>
<td><code>float</code></td>
<td><code>null</code><br />
</td>
<td>This setting defines the minimum value this FieldType will allow as input.</td>
</tr>
<tr class="even">
<td><code>maxFloatValue</code></td>
<td><code>float</code></td>
<td><code>null</code><br />
</td>
<td>This setting defines the maximum value this FieldType will allow as input.</td>
</tr>
</tbody>
</table>

**Validator configuration example in PHP**

``` brush:
use eZ\Publish\Core\FieldType\Float\Type;

$contentTypeService = $repository->getContentTypeService();
$floatFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "float", "ezfloat" );

// Accept only numbers between 0.1 and 203.99
$floatFieldCreateStruct->validatorConfiguration = array(
    "FileSizeValidator" => array(  
        "minFloatValue" => 0.1,
        "maxFloatValue" => 203.99
    )
);
```

### Settings

This Field Type does not support settings.


### Image Variations

Using the variation Service, variations of the original image can be obtained. Those are `\eZ\Publish\SPI\Variation\Values\ImageVariation` objects with the following properties:

| Property       | Type     | Example  | Description                          |
|----------------|----------|----------|--------------------------------------|
| `width`        | int      | `640`    | The variation's width in pixels      |
| `height`       | int      | `480`    | The variation's height in pixels     |
| `name`         | string   | `medium` | The variation's identifier           |
| `info`         | mixed    |          | Extra info, such as EXIF data        |
| `fileSize`     | int      |          |                                      |
| `mimeType`     | string   |          |                                      |
| `fileName`     | string   |          |                                      |
| `dirPath`      | string   |          |                                      |
| `uri`          | string   |          | The variation's uri                  |
| `lastModified` | DateTime |          | When the variation was last modified |

### Field Defintion options

The Image Field Type supports one FieldDefinition option: the maximum size for the file.

## Using an Image Field

### Template Rendering

When displayed using `ez_render_field`, an Image Field will output this type of HTML:

``` brush:
<img src="var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image_medium.png" width="844" height="430" alt="Alternative text" />
```

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Image field accepts the following the parameters:

| Parameter | Type     | Default        | Description                                                                                                                                       |
|-----------|----------|----------------|---------------------------------------------------------------------------------------------------------------------------------------------------|
| `alias`   | `string` | `"original``"` | The image variation name, must be defined in your site access `image_variations` settings. Defaults to "original", the originally uploaded image. |
| `width`   | `int`    |                | Optionally to specify a different width set on the image html tag then then one from image alias.                                                 |
| `height`  | int      |                | Optionally to specify a different height set on the image html tag then then one from image alias.                                                |
| `class`   | `string` |                | Optionally to specify a specific html class for use in custom javascript and/or css.                                                              |

 

Example: 

``` brush:
{{ ez_render_field( content, 'image', { 'parameters':{ 'alias': 'imagelarge', 'width': 400, 'height': 400 } } ) }}
```

The raw Field can also be used if needed. Image variations for the Field's content can be obtained using the `ez_image_alias` Twig helper:

``` brush:
{% set imageAlias = ez_image_alias( field, versionInfo, 'medium' ) %}
```

The variation's properties can be used to generate the required output:

``` brush:
<img src="{{ asset( imageAlias.uri ) }}" width="{{ imageAlias.width }}" height="{{ imageAlias.height }}" alt="{{ field.value.alternativeText }}" />
```

 

### With the REST API

Image Fields within REST are exposed by the `application/vnd.ez.api.Content` media-type. An Image Field will look like this:

inputUri

From 5.2 version, new images must be input using the `inputUri` property from `Image\Value`.

**The keys `id` and `path` still work, but a deprecation warning will be thrown.**

**Version &gt;= 5.2**

``` brush:
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

**Before 5.2**  Expand source

``` brush:
<field>
    <id>1480</id>
    <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
    <languageCode>eng-GB</languageCode>
    <fieldValue>
        <value key="id">var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
        <value key="path">/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
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

 

Children of the fieldValue node will list the general properties of the Field's original image (fileSize, fileName, inputUri, etc.), as well as variations. For each variation, a uri is provided. Requested through REST, this resource will generate the variation if it doesn't exist yet, and list the variation details:

``` brush:
<ContentImageVariation media-type="application/vnd.ez.api.ContentImageVariation+xml" href="/api/ezp/v2/content/binary/images/240-1480/variations/tiny">
  <uri>/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding_tiny.png</uri>
  <contentType>image/png</contentType>
  <width>30</width>
  <height>30</height>
  <fileSize>1361</fileSize>
</ContentImageVariation>
```

### From PHP code

#### Getting an image variation

The variation service, `ezpublish.fieldType.ezimage.variation_service`, can be used to generate/get variations for a Field. It expects a VersionInfo, the Image Field and the variation name, as a string (`large`, `medium`, etc.)

``` brush:
$variation = $imageVariationHandler->getVariation(
    $imageField, $versionInfo, 'large'
);

echo $variation->uri;
```

## Manipulating image content

### From PHP

As for any Field Type, there are several ways to input content to a Field. For an Image, the quickest is to call `setField()` on the ContentStruct:

``` brush:
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$createStruct->setField( 'image', '/tmp/image.png' );
```

In order to customize the Image's alternative texts, you must first get an Image\\Value object, and set this property. For that, you can use the `Image\Value::fromString()` method that accepts the path to a local file:

``` brush:
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$imageField = \eZ\Publish\Core\FieldType\Image\Value::fromString( '/tmp/image.png' );
$imageField->alternativeText = 'My alternative text';
$createStruct->setField( 'image', $imageField );
```

You can also provide a hash of `Image\Value` properties, either to `setField()`, or to the constructor:

``` brush:
$imageValue = new \eZ\Publish\Core\FieldType\Image\Value(
    array(
        'id' => '/tmp/image.png',
        'fileSize' => 37931,
        'fileName' => 'image.png',
        'alternativeText' => 'My alternative text'
    )
);

$createStruct->setField( 'image', $imageValue );
```

### From REST

The REST API expects Field values to be provided in a hash-like structure. Those keys are identical to those expected by the `Image\Value` constructor: `fileName`, `alternativeText`. In addition, image data can be provided using the `data` property, with the image's content encoded as base64.

#### Creating an image Field

``` brush:
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

#### Updating an image Field

Updating an Image Field requires that you re-send existing data. This can be done by re-using the Field obtained via REST, **removing the variations key**, and updating `alternativeText`, `fileName` or `data`. If you do not want to change the image itself, do not provide the `data` key.

``` brush:
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

## Naming

Each storage engine determines how image files are named.

### Legacy Storage Engine naming

Images are stored within the following directory structure:

`<varDir>/<StorageDir>/<ImagesStorageDir>/<FieIdId[-1]>/<FieIdId[-2]>/<FieIdId[-3]>/<FieIdId[-4]>/<FieldId>-<VersionNumber>-<LanguageCode>/`

With the following values:

-   `VarDir` = var (default)
-   `StorageDir` = `storage` (default)
-   `ImagesStorageDir` = `images` (default)
-   `FieldId` = `1480`
-   `VersionNumber` = `1`
-   `LanguageCode` = `eng-GB`

Images will be stored to `web/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB`.

Using the field ID digits in reverse order as the folder structure maximizes sharding of files through multiple folders on the filesystem.

Within this folder, images will be named like the uploaded file, suffixed with an underscore and the variation name:

-   MyImage.png
-   MyImage\_large.png
-   MyImage\_rss.png



# Integer Field Type

This Field Type represents an integer value.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Integer` | `ezinteger`   | `integer`      |

## Description

This Field Type stores numeric values which will be provided as integers.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>integer</code></td>
<td><p><code>2397</code></p></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type  | Description                                                           |
|----------|-------|-----------------------------------------------------------------------|
| `$value` | `int` | This property will be used to store the value provided as an integer. |

**Value object content example**

``` brush:
$integer->value = 8
```

##### Constructor

The `Integer``\Value` constructor will initialize a new Value object with the value provided. It expects a numeric, integer value.

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Integer;
 
// Instantiates a Integer Value object
$integerValue = new Integer\Value( 8 );
```

### Hash format

Hash value of this Field Type is simply integer value as a string.

Example:

> `"8"`

### String representation

String representation of the Field Type's value will return the integer value as a string.

Example:

> `"8"`

### Validation

This Field Type supports `IntegerValueValidator`, defining maximal and minimal float value:

<table>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>minIntegerValue</code></td>
<td><code>int</code></td>
<td><code>0</code></td>
<td>This setting defines the minimum value this FieldType will allow as input.</td>
</tr>
<tr class="even">
<td><code>maxIntegerValue</code></td>
<td><code>int</code></td>
<td><code>false  /</code> <span class="status-macro aui-lozenge aui-lozenge-current">V1.5.2, V1.6.1</span> <code>null</code><br />
</td>
<td>This setting defines the maximum value this FieldType will allow as input.</td>
</tr>
</tbody>
</table>

**Example of validator configuration in PHP**

``` brush:
$validatorConfiguration = array(
    "minIntegerValue" => 1,
    "maxIntegerValue" => 24
);
```

### Settings

This Field Type does not support settings.



# ISBN Field Type

This Field Type represents an ISBN string.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `ISBN` | `ezisbn`      | `string`            |

## Description

This Field Type makes it possible to store and retrieve an ISBN string in either an ISBN-10 or ISBN-13 format.

## PHP API Field Type 

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description                                     |
|----------|----------|-------------------------------------------------|
| `$isbn`  | `string` | This property will be used for the ISBN string. |

##### String representation

An ISBN's string representation is the the $isbn property's value, as a string.

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts a string as argument and will set it to the `isbn` attribute.

### Validation

The input passed into this Field Type is subject of ISBN validation depending on the Field settings in its FieldDefinition stored in the Content Type. An example of this Field setting is shown below and will control if input is validated as ISBN-13 or ISBN-10:

``` brush:
Array
(
    [isISBN13] => true
)
```

 

For more details on the Value object for this Field Type please refer to the [auto-generated documentation](http://apidoc.ez.no/doxygen/trunk/NS/html/classeZ_1_1Publish_1_1Core_1_1FieldType_1_1ISBN_1_1Value.html) *(todo: update link when available, see [here](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/FieldType/ISBN/Value.php)* *for the value object and its doc in the mean time)*.

 

# Keyword Field Type


This Field Type represents keywords.

| Name      | Internal name | Expected input    |
|-----------|---------------|-------------------|
| `Keyword` | `ezkeyword`   | `string[]|string` |

## Description

This Field Type stores one or several comma-separated keywords as a string or array of strings.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>string</code></pre></td>
<td><code>&quot;documentation&quot;</code></td>
</tr>
<tr class="even">
<td><code>string</code></td>
<td><p><code>&quot;php, eZ Publish, html5&quot;</code></p></td>
</tr>
<tr class="odd">
<td><code>string[]</code></td>
<td><code>array( &quot;eZ Systems&quot;, &quot;Enterprise&quot;, &quot;User Experience Management&quot; )</code></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type       | Description                            |
|----------|------------|----------------------------------------|
| `$value` | `string[]` | Holds an array of keywords as strings. |

**Value object content example**

``` brush:
use eZ\Publish\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object
$keywordValue = new Value();
 
// Sets an array of keywords as a value
$keyword->value = array( "php", "css3", "html5", "eZ Publish" );
```

##### Constructor

The **`Keyword`****`\Value`** constructor will initialize a new Value object with the value provided.

It expects a list of keywords, either comma-separated in a string or as an array of strings.

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object with an array of keywords
$keywordValue = new Value( array( "php5", "css3", "html5" ) );
 
// Instantiates a Value object with a list of keywords in a string
// This is equivalent to the example above
$keywordValue = new Value( "php5,css3,html5" );
```


# Landing Page Field Type (Enterprise)

Landing Page Field Type represents a page with a layout consisting of multiple zones; each of which can in turn contain blocks.

Landing Page Field Type is only used in the Landing Page Content Type that is included in eZ Enterprise.

The structure of the Landing Page Content Type should not be modified, as it may cause errors.

| Name           | Internal name   | Expected input  |
|----------------|-----------------|-----------------|
| `Landing page` | `ezlandingpage` | `string (JSON)` |

 

# Layout and zones

Layout is the way in which a Landing Page is divided into zones. Zones are organized structures that are deployed over a layout in a particular position.

The placement of zones is defined in a template which is a part of the layout configuration. You can modify the template in order to define your own system of zones.

For information on how to create and configure new blocks for the Landing Page, see [Creating Landing Page layouts (Enterprise)](31430259.html).

 

# Blocks

For information on how to create and configure new blocks for the Landing Page, see [Creating Landing Page blocks (Enterprise).](https://doc.ez.no/pages/viewpage.action?pageId=31430614)

 

# Rendering Landing Pages

Landing page rendering takes place while editing or viewing.

When rendering a Landing Page, its zones are passed to the layout as a `zones` array with a `blocks` array each. You can simply access them using twig (e.g.** **`{{ zones[0].id }}` ).

Each div that's a zone or zone's container should have data attributes:

-   `data-studio-zones-container` for a div containing zones
-   `data-studio-zone` with zone ID as a value for a zone container

 

To render a block inside the layout, use twig `render_esi()` function to call `           ez_block:renderBlockAction`.

`               ez_block             ` is an alias to `EzSystems\LandingPageFieldTypeBundle\Controller\BlockControlle`**`r`**

 

An action has the following parameters:

-   `             contentId` – ID of content which can be accessed by `             contentInfo.id           `
-   `             blockId` – ID of block which you want to render

 

Example usage:

``` brush:
{{ render_esi(controller('ez_block:renderBlockAction', {
        'contentId': contentInfo.id,
        'blockId': block.id
    })) 
}}
```

 

As a whole a sample layout could look as follows:

**landing\_page\_simple\_layout.html.twig**

``` brush:
{# a layer of the required "data-studio-zones-container" attribute, in which zones will be displayed #}
<div data-studio-zones-container>
     {# a layer of the required attribute for the displayed zone #}
     <div data-studio-zone="{{ zones[0].id }}">                                     
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}                                                    
            {# for each block #}
            {% for block in blocks %}                                               
                {# create a new layer with appropriate id #}
                <div class="landing-page__block block_{{ block.type }}">            
                    {# render the block by using the "ez_block:renderBlockAction" controller #}   
                    {# contentInfo.id is the id of the current content item, block.id is the id of the current block #}
                    {{ render_esi(controller('ez_block:renderBlockAction', {        
                            'contentId': contentInfo.id,                            
                            'blockId': block.id                                     
                        })) 
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```

 

## Viewing template

Your view is populated with data (parameters) retrieved from the `getTemplateParameters()` method which must be implemented in your block's class.

Example:

``` brush:
/**
    * @param \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue $blockValue
    *
    * @return array
    */
   public function getTemplateParameters(BlockValue $blockValue)
   {
       $attributes = $blockValue->getAttributes();
       $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
       $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
       $parameters = [
           'title' => $attributes['title'],
           'limit' => $limit,
           'offset' => $offset,
           'feeds' => $this->RssProvider->getFeeds($attributes['url']),
       ];
       return $parameters;
   }
```

 
# MapLocation Field Type


This Field Type represents a geographical location.

| Name          | Internal name    | Expected input |
|---------------|------------------|----------------|
| `MapLocation` | `ezgmaplocation` | `mixed`        |

## Description

This Field Type makes possible to store and retrieve a geographical location.

As input it expects two float values, latitude, longitude, and a string value in third place, corresponding to the name or address of the location.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>array</code></td>
<td><pre><code>array( &#39;latitude&#39; =&gt; 59.928732, &#39;longitude&#39; =&gt; 10.777888, &#39;address&#39; =&gt; &quot;eZ Systems Norge&quot; )</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>$latitude </code></td>
<td><code>float</code></td>
<td>This property will store the latitude value of the map location reference.</td>
</tr>
<tr class="even">
<td><pre><code>$longitude</code></pre></td>
<td><code>float</code></td>
<td>This property will store the longitude value of the map location reference.</td>
</tr>
<tr class="odd">
<td><code>$address</code></td>
<td><code>string</code></td>
<td>This property will store the address of map location.</td>
</tr>
</tbody>
</table>

##### Constructor

The **`MapLocation`****`\Value`** constructor will initialize a new Value object with the values provided. Two floats and a string are expected.

**Constructor example**

``` brush:
// Instantiates a MapLocation Value object
$MapLocationValue = new MapLocation\Value(
                        array(
                            'latitude' => 59.928732,
                            'longitude' => 10.777888,
                            'address' => "eZ Systems Norge"
                        )
                    );
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Map Location field accepts the following the parameters:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Parameter</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>mapType</code></td>
<td><code>string</code></td>
<td><code>&quot;ROADMAP&quot;</code></td>
<td><a href="https://developers.google.com/maps/documentation/javascript/maptypes#BasicMapTypes" class="external-link">One of the GMap type of map</a></td>
</tr>
<tr class="even">
<td><code>showMap</code></td>
<td><code>boolean</code></td>
<td><code>true</code></td>
<td>Whether to show a Google Map</td>
</tr>
<tr class="odd">
<td><code>showInfo</code></td>
<td><code>booolean</code></td>
<td><code>true</code></td>
<td>Whether to show a latitude, longitude and the address outside of the map</td>
</tr>
<tr class="even">
<td><code>zoom</code></td>
<td><code>integer</code></td>
<td><code>13</code></td>
<td>The initial zoom level on the map</td>
</tr>
<tr class="odd">
<td><code>draggable</code></td>
<td><code>boolean</code></td>
<td><code>true</code></td>
<td><p><span class="c">Whether to enable draggable map<br />
</span></p></td>
</tr>
<tr class="even">
<td><code>width</code></td>
<td><code>string|false</code></td>
<td><code>&quot;500px&quot;</code></td>
<td><p><span class="c">The width of the rendered map with its unit (for example &quot;500px&quot; or &quot;50em&quot;),</span> <span class="c">set to false to not set any width style inline.</span></p></td>
</tr>
<tr class="odd">
<td><code>height</code></td>
<td><code>string|false</code></td>
<td><code>&quot;200px&quot;</code></td>
<td><p><span class="c">The height of the rendered map with its unit (for example &quot;200px&quot; or &quot;20em&quot;),</span> <span class="c">set to false to not set any height style inline.</span></p></td>
</tr>
<tr class="even">
<td>scrollWheel</td>
<td><span>boolean</span></td>
<td>true</td>
<td><span class="status-macro aui-lozenge aui-lozenge-success aui-lozenge-subtle">&gt;= 1.7.4, 1.9.1, 1.10.0</span> Allows you to disable scroll wheel starting to zoom when mouse comes over the map as user scrolls down a page.</td>
</tr>
</tbody>
</table>

Example:

``` brush:
{{ ez_render_field(content, 'location', {'parameters': {'width': '100%', 'height': '330px', 'showMap': true, 'showInfo': false}}) }}
```

### Configuration

&gt;= 1.7.4, 1.9.1, 1.10.0 

| Config                 | Site Access/Group aware | Description                                                                                                                                                                                                                                           |
|------------------------|-------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| api\_keys.google\_maps | yes                     | Google maps requires use of a API key for severing maps to web pages, this setting allows you to specify your personal [Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key) used during template rendering. |

Example use:

**ezplatform.yml**

``` brush:
ezpublish:
    system:
        site_group:
            api_keys: { google_maps: "MY_KEY" }
```


# Media Field Type

This Field Type represents and handles media (audio/video) binary file.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Media` | `ezmedia`     | `mixed`        |

## Description

This Field Type represents and handles a media (audio/video) binary file.

It is capable of handling following types of files:

-   Apple QuickTime
-   Adobe Flash
-   Microsoft Windows Media
-   Real Media
-   Silverlight
-   HTML5 Video
-   HTML5 Audio

## PHP API Field Type 

### Input expectations

| Type                                    | Description                                                                             | Example                           |
|-----------------------------------------|-----------------------------------------------------------------------------------------|-----------------------------------|
| `string`                                | Path to the media file.                                                                 | `/Users/jane/butterflies.mp4`     |
| `eZ\Publish\Core\FieldType\Media\Value` | Media FieldType Value Object with path to the media file as the value of `id` property. | See `Value` object section below. |

### Value object

##### Properties

**`eZ\Publish\Core\FieldType\Media\Value`** offers the following properties.

Note that both **`Media`** and **`BinaryFile`** Value and Type inherit from the **`BinaryBase`** abstract Field Type and share common properties.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>id</code></td>
<td>string</td>
<td><p>Media file identifier. This ID depends on the <a href="https://doc.ez.no/display/DEVELOPER/Clustering#Clustering-Binaryfilesclustering">IO Handler</a> that is being used. With the native, default handlers (FileSystem and Legacy), the ID is the file path, relative to the binary file storage root dir (<code>var/&lt;vardir&gt;/storage/original</code> by default).</p></td>
<td>application/63cd472dd7819da7b75e8e2fee507c68.<span>mp4</span></td>
</tr>
<tr class="even">
<td><code>fileName</code></td>
<td>string</td>
<td>The human-readable file name, as exposed to the outside. Used when sending the file for download in order to name the file.</td>
<td>butterflies.mp4</td>
</tr>
<tr class="odd">
<td><code>fileSize</code></td>
<td>int</td>
<td>File size, in bytes.</td>
<td>1077923</td>
</tr>
<tr class="even">
<td><code>mimeType</code></td>
<td>string</td>
<td>The file's mime type.</td>
<td><p>video/mp4</p></td>
</tr>
<tr class="odd">
<td><code>uri</code></td>
<td>string</td>
<td><p>The binary file's HTTP uri. If the URI doesn't include a host or protocol, it applies to the request domain.</p>
<p><strong><strong>The URI is not publicly readable, and must NOT be used to link to the file for download.</strong></strong> Use <code>ez_render_field</code> to generate a valid link to the download controller.</p></td>
<td>/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.<span>mp4</span></td>
</tr>
<tr class="even">
<td><code>hasController</code></td>
<td>boolean</td>
<td><p><span>Whether the media has a controller when being displayed.</span></p></td>
<td>true</td>
</tr>
<tr class="odd">
<td><code>autoplay</code></td>
<td>boolean</td>
<td><p><span>Whether the media should be automatically played.</span></p></td>
<td>true</td>
</tr>
<tr class="even">
<td><code>loop</code></td>
<td>boolean</td>
<td><p><span>Whether the media should be played in a loop.</span></p></td>
<td>false</td>
</tr>
<tr class="odd">
<td><code>height</code></td>
<td>int</td>
<td><p><span>Height of the media.</span></p></td>
<td>300</td>
</tr>
<tr class="even">
<td><code>width</code></td>
<td>int</td>
<td><p><span>Width of the media.</span></p></td>
<td>400</td>
</tr>
<tr class="odd">
<td><code>path</code></td>
<td>string</td>
<td><p><strong><span style="color: rgb(255,0,0);">deprecated</span><br />
</strong>Renamed to <code>id</code> starting from eZ Publish 5.2. Can still be used, but it is recommended not to use it anymore as it will be removed.</p></td>
<td> </td>
</tr>
</tbody>
</table>

### Hash format

The hash format mostly matches the value object. It has the following keys:

-   `id`
-   `path` (for backwards compatibility)
-   `fileName`
-   `fileSize`
-   `mimeType`
-   `uri`
-   `hasController`
-   `autoplay`
-   `loop`
-   `height`
-   `width`

### Validation

The Field Type supports `FileSizeValidator`, defining maximum size of media file in bytes:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Name
</div></th>
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Default value
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>maxFileSize</code></td>
<td><code>int</code></td>
<td><span>false</span></td>
<td>Maximum size of the file in bytes.</td>
</tr>
</tbody>
</table>

**Example of using Media Field Type validator in PHP**

``` brush:
use eZ\Publish\Core\FieldType\Media\Type;

$contentTypeService = $repository->getContentTypeService();
$mediaFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "media", "ezmedia" );

// Setting maximum file size to 5 megabytes
$mediaFieldCreateStruct->validatorConfiguration = array(
    "FileSizeValidator" => array(
        "maxFileSize" => 5 * 1024 * 1024
    )
);
```

### Settings

The Field Type supports `mediaType` setting, defining how the media file should be handled in output.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Name
</div></th>
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Default value
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>mediaType</code></td>
<td><code>mixed</code></td>
<td><pre><code>Type::TYPE_HTML5_VIDEO</code></pre></td>
<td>Type of the media, accepts one of the predefined constants.</td>
</tr>
</tbody>
</table>

List of all available `mediaType` constants defined in **`eZ\Publish\Core\FieldType\Media\Type`** class:

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Name
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>TYPE_FLASH</code></pre></td>
<td>Adobe Flash</td>
</tr>
<tr class="even">
<td><pre><code>TYPE_QUICKTIME</code></pre></td>
<td>Apple QuickTime</td>
</tr>
<tr class="odd">
<td><pre><code>TYPE_REALPLAYER</code></pre></td>
<td>Real Media</td>
</tr>
<tr class="even">
<td><pre><code>TYPE_SILVERLIGHT</code></pre></td>
<td>Silverlight</td>
</tr>
<tr class="odd">
<td><pre><code>TYPE_WINDOWSMEDIA</code></pre></td>
<td><p>Microsoft Windows Media</p></td>
</tr>
<tr class="even">
<td><pre><code>TYPE_HTML5_VIDEO</code></pre></td>
<td>HTML5 Video</td>
</tr>
<tr class="odd">
<td><pre><code>TYPE_HTML5_AUDIO</code></pre></td>
<td><p>HTML5 Audio</p></td>
</tr>
</tbody>
</table>

**Example of using Media Field Type settings in PHP**

``` brush:
use eZ\Publish\Core\FieldType\Media\Type;
 
$contentTypeService = $repository->getContentTypeService();
$mediaFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "media", "ezmedia" );

// Setting Adobe Flash as the media type
$mediaFieldCreateStruct->fieldSettings = array(
    "mediaType" => Type::TYPE_FLASH,
);
```

# Null Field Type

This Field Type is used as fallback and for testing purposes.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Null` | `variable`    | `mixed`             |

## Description

As integration with Legacy Stack requires that all Field Types are also also handled on 5.x stack side, Null Field Type is provided as a dummy for legacy Field Types that are not really implemented on 5.x side.

Null Field Type will accept anything provided as a value, but will not store anything to the database, nor will it read any data from the database.

This Field Type does not have its own fixed internal name. Its identifier is instead configured as needed by passing it as an argument to the constructor.

Following example shows how Null Field Type is used to configure dummy implementations for `ezcomcomments` and `ezpaex` legacy datatypes:

**Null Fieldtype example configuration**

``` brush:
parameters:
    ezpublish.fieldType.eznull.class: eZ\Publish\Core\FieldType\Null\Type

services:
    ezpublish.fieldType.ezcomcomments:
        class: %ezpublish.fieldType.eznull.class%
        parent: ezpublish.fieldType
        arguments: [ "ezcomcomments" ]
        tags:
            - {name: ezpublish.fieldType, alias: ezcomcomments}
    ezpublish.fieldType.ezpaex:
        class: %ezpublish.fieldType.eznull.class%
        parent: ezpublish.fieldType
        arguments: [ "ezpaex" ]
        tags:
            - {name: ezpublish.fieldType, alias: ezpaex}
```


# Rating Field Type

This Field Type is used to provide rating functionality.

Rating Field Type does not provide the APIs for actual rating, this part is provided by Legacy Stack extension that can be found at <https://github.com/ezsystems/ezstarrating>.

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Internal name</th>
<th>Expected input</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>Rating</code></td>
<td><p><code>ezsrrating</code></p></td>
<td><code>boolean</code></td>
</tr>
</tbody>
</table>

## PHP API Field Type 

### Input expectations

| Type      | Description                                  | Example |
|-----------|----------------------------------------------|---------|
| `boolean` | Denotes if the rating is enabled or disabled | `true`  |

### Value Object

##### Properties

**`eZ\Publish\Core\FieldType\Rating\Value`** offers the following properties.

| Property     | Type      | Description                                  | Example |
|--------------|-----------|----------------------------------------------|---------|
| `isDisabled` | `boolean` | Denotes if the rating is enabled or disabled | `true`  |

### Hash format

Hash matches the Value Object, having only one property:

-   `isDisabled`

### Settings

The Field Type does not support settings.

### Validation

The Field Type does not support validation.

 

# Relation Field Type

This Field Type represents a relation to a Content item.

| Name       | Internal name      | Expected input |
|------------|--------------------|----------------|
| `Relation` | `ezobjectrelation` | `mixed`        |

## Description

This Field Type makes it possible to store and retrieve the value of relation to a Content item.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><pre><code>&quot;150&quot;</code></pre></td>
</tr>
<tr class="even">
<td><code>integer</code></td>
<td> 150</td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property                | Type              | Description                                                                                       |
|-------------------------|-------------------|---------------------------------------------------------------------------------------------------|
| `$destinationContentId` | `string|int|null` | This property will be used to store the value provided, which will represent the related content. |

**Value object content example**

``` brush:
$relation->destinationContentId = $contentInfo->id;
```

##### Constructor

The `Relation``\Value` constructor will initialize a new Value object with the value provided. It expects a mixed value.

**Constructor example**

``` brush:
// Instantiates a Relation Value object
$relationValue = new Relation\Value( $contentInfo->id );
```

### Validation

This Field Type validates whether the provided relation exists, but before it does that it will check that the value is either string or int.

### Settings

The field definition of this Field Type can be configured with two options:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>selectionMethod</code></td>
<td><code>int</code></td>
<td><code>self::SELECTION_BROWSE</code></td>
<td><p>This setting defines the selection method. It expects an integer (0/1). 0 stands for <code>self::SELECTION_BROWSE</code>, 1 stands for <code>self::SELECTION_DROPDOWN</code>.</p>
<p> </p>
<div class="confluence-information-macro confluence-information-macro-information">
<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<div class="confluence-information-macro-body">
<p>NOTE: Dropdown not implemented in Platform UI yet, only browse is used currently.</p>
</div>
</div></td>
</tr>
<tr class="even">
<td><code>selectionRoot</code></td>
<td><code>string</code></td>
<td><code>null</code></td>
<td>This setting defines the selection root.</td>
</tr>
</tbody>
</table>

**Relation FieldType example settings**

``` brush:
use eZ\Publish\Core\FieldType\Relation\Type;

$settings = array(
    "selectionMethod" => 1,
    "selectionRoot" => null
);
```

Note: These settings are meant for future use in user interface when allowing users to select relations.


# RelationList Field Type

This Field Type represents one or multiple relations to content.

| Name           | Internal name          | Expected input |
|----------------|------------------------|----------------|
| `RelationList` | `ezobjectrelationlist` | `mixed`        |

## Description

This Field Type makes possible to store and retrieve values of relation to content.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
<th><div class="tablesorter-header-inner">
Example
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>int|string</code></td>
<td>Id of the related Content item</td>
<td><code>42</code></td>
</tr>
<tr class="even">
<td><code>array</code></td>
<td>An array of related Content IDs</td>
<td><code>array( 24, 42 )</code></td>
</tr>
<tr class="odd">
<td><pre><code>eZ\Publish\API\Repository\Values\Content\ContentInfo</code></pre></td>
<td><p>ContentInfo instance of the related Content</p></td>
<td> </td>
</tr>
<tr class="even">
<td><code>eZ\Publish\Core\FieldType\RelationList\Value</code></td>
<td>RelationList Field Type Value Object</td>
<td>See Value Object documentation section below.</td>
</tr>
</tbody>
</table>

### Value Object

##### Properties

`eZ\Publish\Core\FieldType\RelationList\Value` contains following properties.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>destinationContentIds</code></p></td>
<td><code>array</code></td>
<td>An array of related Content ids</td>
<td><code>array( 24, 42 )</code></td>
</tr>
</tbody>
</table>

**Value object content example**

``` brush:
$relationList->destinationContentId = array(
    $contentInfo1->id,
    $contentInfo2->id,
    170
);
```

##### Constructor

The `RelationList``\Value` constructor will initialize a new Value object with the value provided. It expects a mixed array as value.

**Constructor example**

``` brush:
// Instantiates a RelationList Value object
$relationListValue = new RelationList\Value(
    array(
        $contentInfo1->id,
        $contentInfo2->id,
        170     
    )
);
```

### Validation

This Field Type validates if the `selectionMethod` specified is 0 (`self::SELECTION_BROWSE)` or 1 (`self::SELECTION_DROPDOWN)`. A validation error is thrown if the value does not match.

Also validates if the `selectionDefaultLocation` specified is `null`, `string` or `integer`. If the type validation fails a validation error is thrown.

And validates if the value specified in `selectionContentTypes` is an array. If not, a validation error in given.

### Settings

The field definition of this Field Type can be configured with following options:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>selectionMethod</code></p></td>
<td><code>mixed</code></td>
<td><pre><code>SELECTION_BROWSE</code></pre></td>
<td>Method of selection in the administration interface</td>
</tr>
<tr class="even">
<td><p><code>selectionDefaultLocation</code></p></td>
<td><code>string|integer</code></td>
<td><code>null</code></td>
<td>Id of the default Location for the selection when using administration interface</td>
</tr>
<tr class="odd">
<td><p><code>selectionContentTypes</code></p></td>
<td><code>array</code></td>
<td><code>array()</code></td>
<td>An array of ContentType ids that are allowed for related Content</td>
</tr>
</tbody>
</table>

Following selection methods are available:

| Name                | Description                                                                                                   |
|---------------------|---------------------------------------------------------------------------------------------------------------|
| SELECTION\_BROWSE   | Selection will use browse mode                                                                                |
| SELECTION\_DROPDOWN | Selection control will use dropdown control containing the Content list in the default Location for selection |

NOTE: Dropdown not implemented in Platform UI yet, only browse is used currently.

**Example of using settings in PHP**

``` brush:
use eZ\Publish\Core\FieldType\RelationList\Type;

$settings = array(
    "selectionMethod" => Type::SELECTION_BROWSE,
    "selectionDefaultLocation" => null,
    "selectionContentTypes" => array()
 );
```


# RichText Field Type

This Field Type validates and stores structured rich text, and exposes it in several formats.

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Internal name</th>
<th>Expected input</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>RichText</code></pre></td>
<td><pre><code>ezrichtext</code></pre></td>
<td><pre><code>mixed</code></pre></td>
</tr>
</tbody>
</table>

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>string</code></pre></td>
<td>XML document in one of the Field Type's input formats as a string.</td>
<td>See the example below.</td>
</tr>
<tr class="even">
<td><pre><code>DOMDocument</code></pre></td>
<td><p><span><span>XML document in one of the Field Type's input formats as a</span></span></p>
<p><strong><code>DOMDocument</code></strong> object.</p></td>
<td>See the example below.</td>
</tr>
<tr class="odd">
<td><pre><code>eZ\Publish\Core\FieldType\RichText\Value</code></pre></td>
<td>An instance of the Field Type's <strong><code>Value</code></strong> object.</td>
<td>See the example below.</td>
</tr>
</tbody>
</table>

##### Input formats

Field Type works with XML and also expects an XML value as input, whether as a string, **`DOMDocument`** object or Field Type's **`Value`** object. When the value is given as a string or a **`DOMDocument`** object, it will be checked for conformance with one of the supported input formats, then dispatched to the appropriate converter, to be converted to the Field Type's internal format. No conversion will be performed if providing the value in Field Type's internal format or as Field Type's **`Value`** object. In the latter case it will be expected that **`Value`** object holds the value in Field Type's internal format.

Currently supported input formats are described in the table below:

<table>
<thead>
<tr class="header">
<th>Name</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td>eZ Publish Docbook variant</td>
<td>FieldType's internal format</td>
</tr>
<tr class="even">
<td>XHTML5 editing format</td>
<td>Typically used with in-browser HTML editor</td>
</tr>
<tr class="odd">
<td>Legacy eZXML format</td>
<td>Compatibility with legacy eZXML format, used by <span class="confluence-link"> </span><a href="XmlText-Field-Type_31430551.html">XmlText Field Type</a><span style="color: rgb(0,0,0);"><br />
</span></td>
</tr>
</tbody>
</table>

##### Example of the Field Type's internal format

``` brush:
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

##### Example of the Field Type's XHTML5 edit format

This format is used by eZ Platform Online Editor and will change with its needs as we continue to evolve this part of the UI.

``` brush:
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://ez.no/namespaces/ezpublish5/xhtml5/edit">
    <h2>This is a title.</h2>
    <p class="paraClass">This is a paragraph.</p>
</section>
```

For more information about internal format and input formats, see [Field Type's conversion test fixtures on GitHub](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/FieldType/Tests/RichText/Converter/Xslt/_fixtures).

For example, ezxml does not use explicit level attributes for &lt;header&gt; elements, instead &lt;header&gt; element levels are indicated through the level of nesting inside &lt;section&gt; elements.

##### Example of using XML document in internal format as a string

``` brush:
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

### Value object

**`eZ\Publish\Core\FieldType\RichText\Value`** offers following properties:

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>xml</code></pre></td>
<td><pre><code>DOMDocument</code></pre></td>
<td>Internal format value as an instance of <span><code>DOMDocument</code>.</span></td>
</tr>
</tbody>
</table>

## REST API specifics

### Creating or updating Content

When creating RichText content with the REST API, it is possible to provide data as a string, using the "`xml`" fieldValue key:

``` brush:
<fieldValue>
    <value key="xml">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0"&gt;
&lt;title ezxhtml:level="2"&gt;This is a title.&lt;/title&gt;
&lt;/section&gt;
</value>
</fieldValue>
```

When the value given over REST API is transformed into a Field Type's **`Value`** object, it will be treated as a string. This means you can use any supported input format for input over REST API.

For further informations [about the internal implementation of RichText Field Type, see in the doc/ directory](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rich_text/ezdocbook.md)


# Selection Field Type

This Field Type represents a single selection or multiple choices from a list of options.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `Selection` | `ezselection` | `mixed`             |

## Description

The Selection Field Type stores single selections or multiple choices from a list of options, by populating a hash with the list of selected values.

## PHP API Field Type

### Input expectations

| Type    | Example         |
|---------|-----------------|
| `array` | `array( 1, 2 )` |

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property     | Type    | Description                                                                                                                 |
|--------------|---------|-----------------------------------------------------------------------------------------------------------------------------|
| `$selection` | `int[]` | This property will be used for the list of selections, which will be a list of integer values, or one single integer value. |

**Value object content examples**

``` brush:
// Single selection
$value->selection = 1;

// Multiple selection
$value->selection = array( 1, 4, 5 );
```

##### Constructor

The `Selection\Value` constructor accepts an array of selected element identifiers.

**Constructor example**

``` brush:
// Instanciates a selection value with items #1 and #2 selected
$selectionValue = new Selection\Value( array( 1, 2 ) );
```

##### String representation

String representation of this Field Type is its list of selections as a string, concatenated with a comma.

Example:

> `"1,2,24,42"`

### Hash format

Hash format of this Field Type is the same as Value object's **`selection`** property.

**Example of value in hash format**

``` brush:
$hash = array( 1, 2 );
```

### Validation

This Field Type validates the input, verifying if all selected options exist in the field definition and checks if multiple selections are allowed in the Field definition.
If any of these validations fail, a `ValidationError`  is thrown, specifying the error message, and for the case of the option validation a list with the invalid options is also presented.

### Settings

------------------------------------------------------------------------

| Name         | Type      | Default value | Description                                                    |
|--------------|-----------|---------------|----------------------------------------------------------------|
| `isMultiple` | `boolean` | `false`       | Used to allow or deny multiple selection from the option list. |
| `options`    | `hash`    | `array()`     | Stores the list of options defined in the field definition.    |

**Selection Field Type example settings**

``` brush:
use eZ\Publish\Core\FieldType\Selection\Type;

$settings = array(
    "isMultiple" => true,
    "options" => array(1 => 'One', 2 => 'Two', 3 => 'Three')
);
```

 
# TextBlock Field Type

This Field Type represents a block of unformatted text.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `TextBlock` | `eztext`      | `string`            |

## Description

The Field Type handles a block of multiple lines of unformatted text. It is capable of handling up to 16,777,216 characters.

## PHP API Field Type

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Example
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><pre><code>&quot;This is a block of unformatted text&quot;</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th><div class="tablesorter-header-inner">
Property
</div></th>
<th><div class="tablesorter-header-inner">
Type
</div></th>
<th><div class="tablesorter-header-inner">
Description
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>$text</code></td>
<td><code>string</code></td>
<td>This property will be used for the text content.</td>
</tr>
</tbody>
</table>

##### String representation

A TextBlock's string representation is the the $text property's value, as a string.

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `$text` attribute.

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

Settings contain only one option:

| Name       | Type      | Default value | Description                                                             |
|------------|-----------|---------------|-------------------------------------------------------------------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing control in the administration interface. |

 

# TextLine Field Type

This Field Type represents a simple string.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `TextLine` | `ezstring`    | `string`            |

## Description

This Field Type makes possible to store and retrieve a single line of unformatted text. It is capable of handling up to 255 number of characters.

## PHP API Field Type

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description                                      |
|----------|----------|--------------------------------------------------|
| `$text`  | `string` | This property will be used for the text content. |

##### String representation

A TextLine's string representation is the the $text property's value, as a string.

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `text` attribute.

### Validation

The input passed into this filed type is subject of validation by the `StringLengthValidator` validator. The length of the string provided must be between the minimum length defined in `minStringLength` and the maximum defined in `maxStringLength`. The default value for both properties is 0, which means that the validation is disabled by default.
To set the validation properties the `validateValidatorConfiguration()` method needs to be inspected, which will receive an array with `minStringLength` and `maxStringLength` like in the following representation:

Array
(
    [minStringLength] => 1
    [maxStringLength] => 60
)

# Time Field Type


This Field Type represents time information.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Time` | `eztime`      | `mixed`             |

## Description

This Field Type makes possible to store and retrieve time information.

Date information is **not stored**.

What is stored is the number of seconds, calculated from the beginning of the day in the given or the environment timezone.

## PHP API Field Type

### Input expectations

If input value is of type **`string`** or **`integer`**, it will be passed directly to the [PHP's built-in **`\DateTime`** class](http://www.php.net/manual/en/datetime.construct.php) constructor, therefore the same input format expectations apply.

It is also possible to directly pass an instance of **`\DateTime`**.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><code>&quot;2012-08-28 12:20 Europe/Berlin&quot;</code></td>
</tr>
<tr class="even">
<td><pre><code>integer</code></pre></td>
<td><pre><code>1346149200</code></pre></td>
</tr>
<tr class="odd">
<td><pre><code>\DateTime</code></pre></td>
<td><pre><code>new \DateTime()</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type           | Description                                                                       |
|----------|----------------|-----------------------------------------------------------------------------------|
| `$time`  | `integer|null` | Holds the time information as a number of seconds since the beginning of the day. |

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an integer representing the number of seconds since the beginning of the day.

##### String representation

String representation of the date value will generate the date string in the format "H:i:s" as accepted by [PHP's built-in **`date()`** function](http://www.php.net/manual/en/function.date.php).

Example:

> `"12:14:56"`

### Hash format

Value in hash format is an integer representing a number of seconds since the beginning of the day.

Example:

> `36000`

### Validation

This Field Type does not perform validation of the input value.

### Settings

The field definition of this Field Type can be configured with several options:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>useSeconds</code></pre></td>
<td><code>boolean</code></td>
<td><code>false</code></td>
<td>Used to control displaying of seconds in the output.</td>
</tr>
<tr class="even">
<td><pre><code>defaultType</code></pre></td>
<td><pre><code>Type::DEFAULT_EMPTY
Type::DEFAULT_CURRENT_TIME</code></pre></td>
<td><pre><code>Type::DEFAULT_EMPTY</code></pre></td>
<td>The constant used here defines default input value when using administration interface.</td>
</tr>
</tbody>
</table>

**Time Field Type example settings**

``` brush:
use eZ\Publish\Core\FieldType\Time\Type;

$settings = array(
    "defaultType" => DateAndTime::DEFAULT_EMPTY
);
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](Content-Rendering_31429679.html) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description                                                                                                                       |
|-----------|----------|---------|-----------------------------------------------------------------------------------------------------------------------------------|
| `locale`  | `string` |         | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` brush:
{{ ez_render_field(content, 'time') }}
```
 
# Url Field Type

This Field Type represents a hyperlink. It is formed by the combination of a link and the respective text.

| Name  | Internal name | Expected input |
|-------|---------------|----------------|
| `Url` | `ezurl`       | `string`       |

## Description

This Field Type makes possible to store and retrieve a url. It is formed by the combination of a link and the respective text.

## PHP API Field Type

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td><pre><code>&quot;http://www.ez.no&quot;, &quot;eZ Systems&quot;</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description                                                                                                         |
|----------|----------|---------------------------------------------------------------------------------------------------------------------|
| `$link`  | `string` | This property will be used to store the link provided to the value of this Field Type.                              |
| `$text`  | `string` | This property will be used to store the text to represent the stored link provided to the value of this Field Type. |

**Value object content example**

``` brush:
$url->link = "http://www.ez.no";
$url->text = "eZ Systems";
```

##### Constructor

The `Url``\Value` constructor will initialize a new Value object with the value provided. It expects two comma-separated strings, corresponding to the link and text.

**Constructor example**

``` brush:
// Instantiates an Url Value object
$UrlValue = new Url\Value( "http://www.ez.no", "eZ Systems" );
```

### Validation

This Field Type does not perform validation.

### Settings

This Field Type does not have settings.


# User Field Type

This Field Type validates and stores information about a user.

| Name   | Internal name | Expected input |
|--------|---------------|----------------|
| `User` | `ezuser`      | ignored        |

## PHP API Field Type

### Value Object

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>hasStoredLogin</code></p></td>
<td><code>boolean</code></td>
<td>Denotes if user has stored login.</td>
<td><code>true</code></td>
</tr>
<tr class="even">
<td><p><code>contentId</code></p></td>
<td><code>int|string</code></td>
<td>Id of the Content corresponding to the user.</td>
<td><code>42</code></td>
</tr>
<tr class="odd">
<td><p><code>login</code></p></td>
<td><code>string</code></td>
<td>Username.</td>
<td><code>john</code></td>
</tr>
<tr class="even">
<td><p><code>email</code></p></td>
<td><code>string</code></td>
<td>Users' email address.</td>
<td><code>john@smith.com</code></td>
</tr>
<tr class="odd">
<td><p><code>passwordHash</code></p></td>
<td><code>string</code></td>
<td>Hash of the user's password.</td>
<td><code>1234567890abcdef</code></td>
</tr>
<tr class="even">
<td><p><code>passwordHashType</code></p></td>
<td><code>mixed</code></td>
<td>Algorithm user for generating password hash as a <code>PASSWORD_HASH_* </code>constant defined in <span><code>eZ\Publish\Core\Repository\Values\User\User</code> class</span>.</td>
<td><pre><code>User::PASSWORD_HASH_MD5_USER</code></pre></td>
</tr>
<tr class="odd">
<td><p><code>maxLogin</code></p></td>
<td><code>int</code></td>
<td>Maximal number of concurrent logins.</td>
<td><code>1000</code></td>
</tr>
</tbody>
</table>

##### Available password hash types

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Constant</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_MD5_PASSWORD</code></p></td>
<td>MD5 hash of the password, not recommended.</td>
</tr>
<tr class="even">
<td><p><code>eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_MD5_USER</code></p></td>
<td><span>MD5 hash of the password and username.</span></td>
</tr>
<tr class="odd">
<td><p><code>eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_MD5_SITE</code></p></td>
<td><span>MD5 hash of the password, username and site name.</span></td>
</tr>
<tr class="even">
<td><p><code>eZ\Publish\Core\Repository\Values\User\User::PASSWORD_HASH_PLAINTEXT</code></p></td>
<td><p>Passwords are stored in plaintext, should not be used for real sites.</p></td>
</tr>
</tbody>
</table>

# XmlText Field Type

The XmlText Field Type isn't officially supported by eZ Platform. It can be installed by requiring ezsystems/ezplatform-xmltext-fieldtype. PlatformUI does not support wysiwyg editing of this type of Field.

This Field Type validates and stores formatted text using the eZ Publish legacy format, ezxml. 

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `XmlText` | `ezxmltext`   | `mixed`        |

## Input expectations

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Type</th>
<th>Description</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>string</code></td>
<td>XML document in the Field Type internal format as a string.</td>
<td><p>See the example below.</p></td>
</tr>
<tr class="even">
<td><pre><code>eZ\Publish\Core\FieldType\XmlText\Input</code></pre></td>
<td>An instance of the class implementing Field Type abstract <strong><code>Input</code></strong> class.</td>
<td><span>See the example below.</span></td>
</tr>
<tr class="odd">
<td><pre><code>eZ\Publish\Core\FieldType\XmlText\Value</code></pre></td>
<td><span>An instance of the Field Type <strong><code>Value</code></strong> object.</span></td>
<td><span>See the example below.</span></td>
</tr>
</tbody>
</table>

### Example of the Field Type's internal format

``` brush:
<?xml version="1.0" encoding="utf-8"?>
<section
    xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"
    xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
    xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/">
    <paragraph>This is a paragraph.</paragraph>
</section>
```

### For XHTML Input

The eZ XML output uses &lt;strong&gt; and &lt;em&gt; by default, respecting the semantic XHTML notation.

Learn more about &lt;strong&gt;, &lt;b&gt;, &lt;em&gt;, &lt;i&gt;

-   [Read the share.ez.no forum about our choice of semantic tags with eZ XML](http://share.ez.no/forums/ez-publish-5-platform/strong-vs-b-and-em-vs-i)
-   Learn more [about the semantic tags vs the presentational tags.](http://html5doctor.com/i-b-em-strong-element/)

## Input object API

`Input` object is intended as a vector for different input formats. It should accept input value in a foreign format and convert it to the Field Type's internal format.

It should implement abstract **`eZ\Publish\Core\FieldType\XmlText\Input`** class, which defines only one method:

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Method</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>getInternalRepresentation</code></pre></td>
<td>The method should return the input value in the internal format.</td>
</tr>
</tbody>
</table>

At the moment there is only one implementation of the **`Input`** class, **`eZ\Publish\Core\FieldType\XmlText\Input\EzXml`**, which accepts input value in the internal format, and therefore only performs validation of the input value.

**Example of using the Input object**

``` brush:
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

## Value object API

**`eZ\Publish\Core\FieldType\XmlText\Value`** offers following properties:

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th>Property</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>xml</code></td>
<td><pre><code>DOMDocument</code></pre></td>
<td>Internal format value as an instance of <span style="line-height: 1.4285715;"><code>DOMDocument</code>.</span></td>
</tr>
</tbody>
</table>

## Validation

Validation of the internal format is performed in the **`eZ\Publish\Core\FieldType\XmlText\Input\EzXml`** class.

## Settings

Following settings are available:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Type</th>
<th>Default value</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><code>numRows</code></p></td>
<td><code>int</code></td>
<td><code>10</code></td>
<td>Defines the number of rows for the online editor in the administration interface.</td>
</tr>
<tr class="even">
<td><p><code>tagPreset</code></p></td>
<td><code>mixed</code></td>
<td><code>Type::TAG_PRESET_DEFAULT</code></td>
<td><p><span>Preset of tags for the online editor in the administration interface.</span></p></td>
</tr>
</tbody>
</table>

### Tag presets

Following tag presets are available as constants in the **`eZ\Publish\Core\FieldType\XmlText`** class:

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Constant</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><pre><code>TAG_PRESET_DEFAULT</code></pre></td>
<td>Default tag preset.</td>
</tr>
<tr class="even">
<td><pre><code>TAG_PRESET_SIMPLE_FORMATTING</code></pre></td>
<td><p><span>Preset of tags for online editor intended for simple formatting options.</span></p></td>
</tr>
</tbody>
</table>

**Example of using settings in PHP**

``` brush:
...
 
use eZ\Publish\Core\FieldType\XmlText\Type;

...

$contentTypeService = $repository->getContentTypeService();
$xmltextFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "description", "ezxmltext" );

$xmltextFieldCreateStruct->fieldSettings = array(
    "numRows" => 25,
    "tagPreset" => Type::TAG_PRESET_SIMPLE_FORMATTING
);
 
...
```

 
