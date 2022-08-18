# RichText Field Type

The RichText Field Type is available via the RichText Field Type Bundle provided by the [ibexa/richtext](https://github.com/ibexa/richtext) package.

This Field Type validates and stores structured rich text, and exposes it in several formats.

|Name|Internal name|Expected input|
|------|------|------|
|`RichText`|`ezrichtext`|mixed|

## PHP API Field Type 

### Value object

`Ibexa\FieldTypeRichText\FieldType\RichText\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`xml`|`DOMDocument`|Internal format value as an instance of `DOMDocument`.|

### Input expectations

|Type|Description|
|------|------|
|`string`|XML document in one of the Field Type's input formats as a string.|
|`DOMDocument`|XML document in one of the Field Type's input formats as a `DOMDocument` object.|
|`Ibexa\FieldTypeRichText\FieldType\RichText\Value`|An instance of the Field Type's `Value` object.|

##### Input formats

The Field Type expects an XML value as input, in the form of a string, `DOMDocument` object, or Field Type's `Value` object.
The Field Type's `Value` object must hold the value in the Field Type's [internal format](#internal-format).
For a string of a `DOMDocument` object, if the input does not conform to this format, it is converted into it.

##### Internal format

As its internal format, the RichText Field Type uses a [custom flavor of the DocBook format](#custom-docbook-format).

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

##### XHTML5 edit format

The XHTML5 format is used by the Online Editor.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://ez.no/namespaces/ezpublish5/xhtml5/edit">
    <h2>This is a title.</h2>
    <p class="paraClass">This is a paragraph.</p>
</section>
```

## Custom DocBook format

!!! caution

    The custom DocBook format described below is subject to change
    and is not covered by backwards compatibility promise.

You can use the Ibexa flavor of the DocBook format in PHP API and in REST API requests
by providing the DocBook content as a string.

The following example shows how to pass DocBook content to a [create struct](creating_content.md#creating-content-item-draft):

``` php
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
```

When creating RichText content with the REST API, use the `xml` key of the `fieldValue` tag:

``` xml
<fieldValue>
    <value key="xml">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0"&gt;
&lt;title ezxhtml:level="2"&gt;This is a title.&lt;/title&gt;
&lt;/section&gt;
    </value>
</fieldValue>
```

### DocBook elements

The RichText format enriches [DocBook](https://docbook.org/) with the following custom elements:

- `section` - main element of a RichText Field
- `ezembed` - holds embedded images
- `ezembedinline` - holds embedded Content items
- `eztemplate` - holds custom tags, including built-in custom tags for embedded Facebook, Twitter and YouTube content
- `eztemplateinline` - holds inline custom tags
- `ezconfig` - contains configuration for custom tags and other elements
- `ezvalue` - contains values for other elements, such as `ezconfig` or `ezembed`
- `ezattribute` - contains attributes for other elements, such as `ezconfig` or `ezembed`

!!! note "Unsupported DocBook elements"

    Some DocBook elements are not supported by RichText.
    Refer to [`ezpublish.rng`](https://github.com/ibexa/richtext/blob/main/src/bundle/Resources/richtext/schemas/docbook/ezpublish.rng#L120) for a full list.

### Online Editor elements

Elements of the Online Editor correspond to the following sample DocBook code blocks.

#### Text formatting

``` xml
<para xml:id="anchor" ezxhtml:class="ez-has-anchor">Anchor text</para>
<para ezxhtml:class="" ezxhtml:textalign="center">Center aligned</para>
<para ezxhtml:class="" ezxhtml:textalign="left">Left aligned <emphasis role="strong">bold</emphasis>
    <emphasis>italic </emphasis>
    <emphasis role="underlined">underlined </emphasis>
    <subscript>subscript </subscript>
    <superscript>superscript </superscript>
    <emphasis role="strikedthrough">crossed out</emphasis>
</para>
<blockquote>
    <para ezxhtml:class="" ezxhtml:textalign="left">This is a block quote.</para>
</blockquote>
```

#### Heading

``` xml
<title ezxhtml:level="1">My heading</title>
```

#### Code block

``` xml
<programlisting><![CDATA[Code sample here]]></programlisting>
```

#### Unordered list

``` xml
<itemizedlist>
    <listitem>
        <para>1st level bullet point</para>
    </listitem>
    <listitem>
        <para>1st level bullet point
            <itemizedlist>
                <listitem>
                    <para>2nd level bullet point</para>
                </listitem>
                <listitem>
                    <para>2nd level bullet point</para>
                </listitem>
            </itemizedlist>
        </para>
    </listitem>
</itemizedlist>
```

#### Ordered list

``` xml
<orderedlist>
    <listitem>
        <para>1st level numbered point</para>
    </listitem>
    <listitem>
        <para>1st level numbered point
            <orderedlist>
                <listitem>
                    <para>2nd level numbered point</para>
                </listitem>
            </orderedlist>
        </para>
    </listitem>
</orderedlist>
```

#### Embedded content

``` xml
<ezembedinline xlink:href="ezcontent://58" view="embed-inline"/>
```

#### Inline embedded content

``` xml
<link xlink:href="ezlocation://60" xlink:show="none">embed inline</link>
```

#### Image

``` xml
<ezembed xlink:href="ezcontent://67" view="embed" ezxhtml:class="ez-embed-type-image">
    <ezconfig>
        <ezvalue key="size">medium</ezvalue>
    </ezconfig>
</ezembed>
```

#### Table

``` xml
<informaltable width="100%" border="1">
    <thead>
        <tr>
            <th scope="col"></th>
            <th colspan="2" scope="col">This is a merged table cell</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"></th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th scope="row"></th>
            <td colspan="2"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th scope="row"></th>
            <td colspan="2"></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</informaltable>
```

#### YouTube

``` xml
<eztemplate name="ezyoutube" ezxhtml:class="ez-custom-tag ez-custom-tag--attributes-visible">
    <ezconfig>
        <ezvalue key="video_url">https://youtu.be/Y-1d5zdeg9A</ezvalue>
        <ezvalue key="autoplay">false</ezvalue>
    </ezconfig>
</eztemplate>
```

#### Twitter

``` xml
<eztemplate name="eztwitter" ezxhtml:class="ez-custom-tag ez-custom-tag--attributes-visible">
    <ezconfig>
        <ezvalue key="tweet_url">https://twitter.com/BBCSpringwatch/status/1401622026973032452</ezvalue>
        <ezvalue key="theme">light</ezvalue>
        <ezvalue key="width">500</ezvalue>
        <ezvalue key="lang">en</ezvalue>
        <ezvalue key="dnt">true</ezvalue>
    </ezconfig>
</eztemplate>
```

#### Facebook

``` xml
<eztemplate name="ezfacebook" ezxhtml:class="ez-custom-tag ez-custom-tag--attributes-visible">
    <ezconfig>
        <ezvalue key="post_url">https://www.facebook.com/bbcnews/posts/10158930827817217?__tn__=-R</ezvalue>
        <ezvalue key="width">120</ezvalue>
    </ezconfig>
</eztemplate>
```

