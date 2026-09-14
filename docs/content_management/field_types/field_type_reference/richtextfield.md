# RichText field type

This field type validates and stores structured rich text in [DocBook](https://docbook.org/) XML format, and exposes it in several formats.

| Name       | Internal name    |
|------------|------------------|
| `RichText` | `ibexa_richtext` |

## Field value

The field value is an object with the following keys:

| Key          | Type     | Description                                                                                       |
|--------------|----------|-----------------------------------------------------------------------------------------------------|
| `xml`        | `string` | The rich text in the field type's [internal format](#internal-format), a custom flavor of DocBook. |
| `xhtml5edit` | `string` | The same content in the [XHTML5 edit format](#xhtml5-edit-format). Read-only, added by the API on output only. |

``` json
{
    "fieldDefinitionIdentifier": "description",
    "languageCode": "eng-GB",
    "fieldValue": {
        "xml": "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<section xmlns=\"http://docbook.org/ns/docbook\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:ezxhtml=\"http://ibexa.co/xmlns/dxp/docbook/xhtml\" xmlns:ezcustom=\"http://ibexa.co/xmlns/dxp/docbook/custom\" version=\"5.0-variant ezpublish-1.0\">\n  <title ezxhtml:level=\"2\">This is a title.</title>\n  <para>This is a paragraph.</para>\n</section>\n",
        "xhtml5edit": "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<section xmlns=\"http://ibexa.co/namespaces/ezpublish5/xhtml5/edit\"/>\n"
    }
}
```

When you create or update a field, provide the `xml` key only.
If the input doesn't conform to the internal format, it's converted into it.

### Internal format

As its internal format, the RichText field type uses a [custom flavor of the DocBook format](#custom-docbook-format).

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section
    xmlns="http://docbook.org/ns/docbook"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml"
    xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" version="5.0-variant ezpublish-1.0">
    <title ezxhtml:level="2">This is a title.</title>
    <para>This is a paragraph.</para>
</section>
```

### XHTML5 edit format

The XHTML5 format is used by the Online Editor and is returned under the `xhtml5edit` key.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://ibexa.co/namespaces/ezpublish5/xhtml5">
    <h2>This is a title.</h2>
    <p class="paraClass">This is a paragraph.</p>
</section>
```

## Custom DocBook format

!!! caution

    The custom DocBook format described below is subject to change and isn't covered by backwards compatibility promise.

You provide the DocBook content as a string under the `xml` key of the field value.
The examples below show the DocBook markup that goes into that string.

### DocBook elements

The RichText format enriches [DocBook](https://docbook.org/) with the following custom elements:

- `section` - main element of a RichText field
- `ezembed` - holds embedded images
- `ezembedinline` - holds embedded content items
- `eztemplate` - holds custom tags, including built-in custom tags for embedded Facebook, Twitter, and YouTube content
- `eztemplateinline` - holds inline custom tags
- `ezconfig` - contains configuration for custom tags and other elements
- `ezvalue` - contains values for other elements, such as `ezconfig` or `ezembed`
- `ezattribute` - contains attributes for other elements, such as `ezconfig` or `ezembed`

!!! note "Unsupported DocBook elements"

    Some DocBook elements aren't supported by RichText.
    Refer to [`ezpublish.rng`](https://github.com/ibexa/fieldtype-richtext/blob/6.0/src/bundle/Resources/richtext/schemas/docbook/ezpublish.rng#L137) for a full list.

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
<ezembed xlink:href="ezcontent://67" view="embed" ezxhtml:class="ibexa-embed-type-image">
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
