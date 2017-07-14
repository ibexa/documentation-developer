1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)
4.  [Under the Hood: How eZ Platform Works](31429659.html)
5.  [Content Model: Content is King!](31429709.html)
6.  [Content items, Content Types and Fields](31430275.html)
7.  [Field Types reference](Field-Types-reference_31430495.html)

# Date Field Type 

Created by Dominika Kurek, last modified on Feb 23, 2017

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

 






