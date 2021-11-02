# XmlText Field Type

The XmlText Field Type isn't officially supported by [[= product_name =]]. It can be installed by requiring `ezsystems/ezplatform-xmltext-fieldtype`. The Back Office does not support WYSIWYG editing of Fields of this type.

This Field Type validates and stores formatted text using the eZ Publish legacy format, eZXML. 

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `XmlText` | `ezxmltext`   | `mixed`        |

## Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|XML document in the Field Type internal format as a string.|See the example below.|
|`Ibexa\Core\FieldType\XmlText\Input`|An instance of the class implementing the Field Type's abstract `Input` class.|See the example below.|
|`Ibexa\Core\FieldType\XmlText\Value`|An instance of the Field Type's `Value` object.|See the example below.|

### Example of the Field Type's internal format

``` xml
<?xml version="1.0" encoding="utf-8"?>
<section
    xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"
    xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
    xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/">
    <paragraph>This is a paragraph.</paragraph>
</section>
```

### For XHTML Input

The XML output uses `<strong>` and `<em>` by default, respecting the semantic XHTML notation.

Learn more about `<strong>`, `<b>`, `<em>`, `<i>`:

- Learn more [about the semantic tags vs the presentational tags.](http://html5doctor.com/i-b-em-strong-element/)

## Input object API

`Input` object is intended as a vector for different input formats. It should accept input value in a foreign format and convert it to the Field Type's internal format.

It should implement the abstract `Ibexa\Core\FieldType\XmlText\Input` class, which defines only one method:

|Method|Description|
|------|------|
|`getInternalRepresentation`|The method returns the input value in the internal format.|

At the moment there is only one implementation of the `Input` class, `Ibexa\Core\FieldType\XmlText\Input\EzXml`, which accepts input value in the internal format, and therefore only performs validation of the input value.

``` php
// Example of using the Input object

...
 
use Ibexa\Core\FieldType\XmlText\Input\EzXml as EzXmlInput;

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

`Ibexa\Core\FieldType\XmlText\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`xml`|`DOMDocument`|Internal format value as an instance of `DOMDocument`.|

## Validation

Validation of the internal format is performed in the `Ibexa\Core\FieldType\XmlText\Input\EzXml` class.

## Settings

Following settings are available:

|Name|Type|Default value|Description|
|------|------|------|------|
|`numRows`|`int`|`10`|Defines the number of rows for the online editor in the back-end interface.|
|`tagPreset`|`mixed`|`Type::TAG_PRESET_DEFAULT`|Preset of tags for the online editor in the back-end interface.|

### Tag presets

Following tag presets are available as constants in the `Ibexa\Core\FieldType\XmlText` class:

|Constant|Description|
|------|------|
|`TAG_PRESET_DEFAULT`|Default tag preset.|
|`TAG_PRESET_SIMPLE_FORMATTING`|Preset of tags for online editor intended for simple formatting options.|

``` php
// Example of using settings in PHP

...
 
use Ibexa\Core\FieldType\XmlText\Type;

...

$contentTypeService = $repository->getContentTypeService();
$xmltextFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "description", "ezxmltext" );

$xmltextFieldCreateStruct->fieldSettings = [
    "numRows" => 25,
    "tagPreset" => Type::TAG_PRESET_SIMPLE_FORMATTING
];
 
...
```
