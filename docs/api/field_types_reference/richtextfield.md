# RichText Field Type

The RichText Field Type is available via the RichText Field Type Bundle provided by the [ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext) package.

This Field Type validates and stores structured rich text, and exposes it in several formats.

|Name|Internal name|Expected input|
|------|------|------|
|`RichText`|`ezrichtext`|mixed|

## PHP API Field Type 

### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|XML document in one of the Field Type's input formats as a string.|See the example below.|
|`DOMDocument`|XML document in one of the Field Type's input formats as a `DOMDocument` object.|See the example below.|
|`EzSystems\EzPlatformRichText\eZ\FieldType\RichText\Value`|An instance of the Field Type's `Value` object.|See the example below.|

##### Input formats

The Field Type works with XML and also expects an XML value as input, whether as a string, `DOMDocument` object or Field Type's `Value` object. When the value is given as a string or a `DOMDocument` object, it will be checked for conformance with one of the supported input formats, then dispatched to the appropriate converter, to be converted to the Field Type's internal format. No conversion will be performed if providing the value in Field Type's internal format or as Field Type's `Value` object. In the latter case it will be expected that the `Value` object holds the value in the Field Type's internal format.

Currently supported input formats are described in the table below:

|Name|Description|
|------|------|
|[[= product_name_oss =]]'s DocBook variant|Field Type's internal format.|
|XHTML5 editing format|Typically used with in-browser HTML editor.|
|Legacy eZXML format|Compatibility with legacy XML format, used by [XmlText Field Type](xmltextfield.md).|

##### Example of the Field Type's internal format

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

##### Example of the Field Type's XHTML5 edit format

This format is used by [[= product_name_oss =]]'s Online Editor.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://ez.no/namespaces/ezpublish5/xhtml5/edit">
    <h2>This is a title.</h2>
    <p class="paraClass">This is a paragraph.</p>
</section>
```

For more information about internal format and input formats, see [Field Type's conversion test fixtures on GitHub](https://github.com/ezsystems/ezplatform-richtext/tree/master/tests/lib/eZ/RichText/Converter/Xslt/_fixtures).

For example, eZXML does not use explicit level attributes for `<header>` elements, instead `<header>` element levels are indicated through the level of nesting inside `<section>` elements.

##### Example of using XML document in internal format as a string

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

### Value object

`EzSystems\EzPlatformRichText\eZ\FieldType\RichText\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`xml`|`DOMDocument`|Internal format value as an instance of `DOMDocument`.|

## REST API specifics

### Creating or updating Content

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
