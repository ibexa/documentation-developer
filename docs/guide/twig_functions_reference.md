# Twig Functions Reference

!!! note "Symfony and Twig template functions/filters/tags"

    For the template functionality provided by Symfony Framework, see [Symfony Twig Extensions Reference page](http://symfony.com/doc/5.0/reference/twig_reference.html). For those provided by the underlying Twig template engine, see [Twig Reference page](http://twig.sensiolabs.org/documentation#reference).

In addition to the [native functions provided by Twig](http://twig.sensiolabs.org/doc/functions/index.html), eZ Platform offers the following:

|Twig function|Description|
|-------------|-----------|
|[`ez_content_name`](#ez_content_name)|Displays a Content item's name in the current language.|
|[`ez_field_description`](#ez_field_description)|Returns the description from the Field definition of a Content item's Field in the current language.|
|[`ez_field_name`](#ez_field_name)|Returns the name from the Field definition of a Content item's Field in the current language.|
|[`ez_field_value`](#ez_field_value)|Returns a Content item's Field value in the current language.|
|[`ez_field`](#ez_field)|Returns a Field from a Content item in the current language.|
|[`ez_file_size`](#ez_file_size)|Returns the size of a file as string.|
|[`ez_content_field_identifier_first_filled_image`](#ez_content_field_identifier_first_filled_image)|Returns the identifier of the first image field that is not empty.|
|[`ez_full_datetime`](#ez_full_datetime-ez_full_date-ez_full_time)|Outputs date and time in full format.|
|[`ez_full_date`](#ez_full_datetime-ez_full_date-ez_full_time)|Outputs date in full format.|
|[`ez_full_time`](#ez_full_datetime-ez_full_date-ez_full_time)|Outputs time in full format.|
|[`ez_image_alias`](#ez_image_alias)|Displays a selected variation of an image.|
|[`ez_field_is_empty`](#ez_field_is_empty)|Checks if a Content item's Field value is considered empty in the current language.|
|[`ez_short_datetime`](#ez_short_datetime-ez_short_date-ez_short_time)|Outputs date and time in short format.|
|[`ez_short_date`](#ez_short_datetime-ez_short_date-ez_short_time)|Outputs date in short format.|
|[`ez_short_time`](#ez_short_datetime-ez_short_date-ez_short_time)|Outputs time in short format.|
|[`ez_render_field`](#ez_render_field)|Displays a Content item's Field value, taking advantage of the template block exposed by the Field Type used.|
|[`ez_urlalias`](#ez_urlalias)|It is a special route name for generating URLs for a Location from the given parameters.|

### `ez_content_name`

#### Description

`ez_content_name()` is a Twig helper which displays a Content item's name in the current language.

If the Content item does not have a translation in the current language, the name in the main language is always returned. This behavior is identical when forcing a language.

If languages were specified during retrieval of the Content item, you can render name directly using `$content->getName()` (Twig: `content.name`) and it will take the prioritised languages into account. If not, it falls back to the main language, just like `ez_content_name()` does. For usage with ContentInfo, see examples below.

#### Prototype and Arguments

`ez_content_name ( eZ\Publish\API\Repository\Values\Content\Content content [, string forcedLanguage ] ) : string`

`ez_content_name ( contentInfo [, string forcedLanguage ] ) : string`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content or ContentInfo object the displayable field belongs to.|
| `forcedLanguage` | `string` | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html+twig
<h2>Content name in current language: {{ ez_content_name( content ) }}</h2>
<h2>Content name in current language, from ContentInfo: {{ ez_content_name( content.contentInfo ) }}</h2>
<h2>Content name in French (forced): {{ ez_content_name( content, "fre-FR" ) }}</h2>
```

#### Equivalent PHP code

##### Getting the translated name for a Content item

``` php
// Assuming you're in a controller action
$translationHelper = $this->get( 'ezpublish.translation_helper' );
 
// From Content
$translatedContentName = $translationHelper->getTranslatedContentName( $content );
// From ContentInfo
$translatedContentName = $translationHelper->getTranslatedContentNameByContentInfo( $contentInfo );
```

##### Forcing a specific language

``` php
// Assuming you're in a controller action
$translatedContentName = $this->get( 'ezpublish.translation_helper' )->getTranslatedName( $content, 'fre-FR' );
```

### `ez_field_description`

#### Description

`ez_field_description()` is a Twig helper which returns the description from the Field definition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_field_description ( Content|ContentInfo content, string fieldDefIdentifier [, string forcedLanguage ] ) : string|null`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content/ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the Field definition description from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "eng-US"), otherwise takes prioritized languages from SiteAccess settings. |

#### Usage

``` html+twig
<p id="ez-content-article-title-description">{{ ez_field_description( content, "title" ) }}</p>
```

### `ez_field_name`

#### Description

`ez_field_name()` is a Twig helper which returns the name from the Field definition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_field_name ( Content|ContentInfo content, string fieldDefIdentifier [, string forcedLanguage ] ) : string|null`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content / ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the Field definition name from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "`jpn-JP`"), otherwise takes prioritized languages from SiteAccess settings. |

#### Usage

``` html+twig
<label for="ez-content-article-title">{{ ez_field_name( content, "title" ) }}</label>
```

### `ez_field_value`

#### Description

`ez_field_value()` is a Twig helper which returns a Content item's Field value in the current language.

This can be useful when you don't want to use [`ez_render_field`](#ez_render_field) and manage the rendering by yourself.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

!!! tip

    If languages were specified during retrieval of the Content item, you can get field value directly using `content->getFieldValue('title')` and it will take the prioritised languages into account. If not, it falls back to the main language, just like **ez\_field\_value()** does.

#### Prototype and Arguments

`ez_field_value ( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier [, string forcedLanguage ] ): eZ\Publish\Core\FieldType\Value`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the Field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html+twig
<h2>My title value: {{ ez_field_value( content, "title" ) }}</h2>
```

### `ez_field`

#### Description

`ez_field()` is a Twig helper which returns a Field  in the current language. The Field gives you access to the Field value, as well as the Field's definition identifier and Field Type identifier.

!!! tip

    Other Twig helpers are available to display specific information of the Field; they all start with `ez_field_`.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

!!! tip

    If languages were specified during retrieval of the Content item, you can get the Field directly using `content->getField('title')` and it will take the prioritised languages into account. If not, it falls back to the main language, just like **ez\_field()** does.

#### Prototype and Arguments

`ez_field ( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier [, string forcedLanguage ] ) : eZ\Publish\API\Repository\Values\Content\Field`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the Field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html+twig
<h2>My title's id: {{ ez_field( content, "title" ).id }}</h2>
```

### `ez_file_size`

#### Description

`ez_file_size()` is a Twig helper (Twig filter) which is mostly a byte calculator. It will convert a number from byte to the correct suffix (from B to EB). The output pattern will also vary with the current language of the SiteAccess (e.g. choosing between coma or point pattern).

It returns a string.

!!! note

    The byte factor is 1000 instead of 1024 to be more familiar for users.

#### Prototype and Arguments

`integer number_of_bytes|ez_file_size( integer number_of_decimal )`

| Argument name       | Type      | Description                                      |
|---------------------|-----------|--------------------------------------------------|
| `number_of_bytes`   | `integer` | The number in byte you want to convert            |
| `number_of_decimal` | `integer` | The number of decimal you want the output to have |

#### Usage

``` html+twig
{{ 42698273|ez_file_size( 3 ) }} //Output with French SiteAccess : 42,698 MB

{{ 42698273|ez_file_size( 4 ) }} //Output with English SiteAccess : 42.6983 MB
```

### `ez_content_field_identifier_first_filled_image`

#### Description

`ez_content_field_identifier_first_filled_image` is a Twig helper which returns the identifier of the first image field that is not empty.

It can be used for example to identify the first image in an article to render it in an embed or line view.

#### Prototype and Arguments

`ez_content_field_identifier_first_filled_image` ( eZ\Publish\API\Repository\Values\Content\Content content ) : string`

| Argument name | Type                                               | Description                       |
|---------------|----------------------------------------------------|-----------------------------------|
| `content`     | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Fields belong to |

### `ez_full_datetime`, `ez_full_date`, `ez_full_time`

These Twig filters are used to [format date and time](../extending/extending_date_and_time.md).
The formats are defined in [user preferences](config_back_office.md#date-and-time-formats).

| Twig filter | Description |
|-------------|-------------|
| `ez_full_datetime` | outputs date and time in full format |
| `ez_full_date` | outputs date in full format |
| `ez_full_time` | outputs time in full format |

The filters accept `\DateTimeInterface` as argument.
If the argument is null, the filter returns the current date and time in the selected format.

For example `{{ contentInfo.publishedDate|ez_full_datetime }}` will return `03 May 2019 23:03`.

The filters also accept an optional `timezone` parameter for displaying date and time in a chosen time zone.

### `ez_image_alias`

#### Description

`ez_image_alias()` is a Twig helper that displays a selected variation (alias) of an image.

#### Prototype and Arguments

`ez_image_alias ( eZ\Publish\API\Repository\Values\Content\Field field, eZ\Publish\API\Repository\Values\Content\VersionInfo versionInfo, string variantName ) : \eZ\Publish\SPI\Variation\Values\Variation|null`

| Argument name | Type                                                   | Description                               |
|---------------|--------------------------------------------------------|-------------------------------------------|
| `field`       | `eZ\Publish\API\Repository\Values\Content\Field`       | The image Field                           |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo that the Field belongs to |
| `variantName` | `string`                                               | Name of the image variation to be used. To display original image alias, use `original` as an image variation. |

See [images](images.md) for more information about image variations.

### `ez_field_is_empty`

#### Description

`ez_field_is_empty()` is a Twig helper which checks if a Content item's Field value is considered empty in the current language.

It returns a Boolean value (`true` or `false`).

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_field_is_empty ( eZ\Publish\API\Repository\Values\Content\Content content, eZ\Publish\API\Repository\Values\Content\Field|string fieldDefIdentifier [, string forcedLanguage ] ) : bool`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the displayed Field belongs to. |
| `fieldDefIdentifier` | `eZ\Publish\API\Repository\Values\Content\Field or string` | The Field you want to check or its identifier. |
| `forcedLanguage` | `string` | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

##### Using the Field identifier as parameter

``` html+twig
{# Display "description" Field if not empty #}
{% if not ez_field_is_empty( content, "description" ) %}
    <div class="description">
        {{ ez_render_field( content, "description" ) }}
    </div>
{% endif %}
```

##### Using the Field as parameter

``` html+twig
{# Display "description" field if not empty #}
{% if not ez_field_is_empty( content, field ) %}
    <div class="description">
        {{ ez_render_field( content, field.fieldDefIdentifier ) }}
    </div>
{% endif %}
```

##### Checking if Field exists before use

``` html+twig
{# Display "description" field if it exists and is not empty #}
{% if content.fields.description is defined and not ez_field_is_empty( content, "description" ) %}
    <div class="description">
        {{ ez_render_field( content, "description" ) }}
    </div>
{% endif %}
```

### `ez_render_field`

#### Description

`ez_render_field()` is a Twig helper that displays a Content item's Field value, taking advantage of the template block exposed by the Field Type used.

Template blocks for built-in Field Types [reside in EzPublishCoreBundle](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig).

See section of [Using the Field Type's template block](templates.md#using-the-field-types-template-block) for more information.

#### Prototype and Arguments

`ez_render_field ( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefinitionIdentifier [, hash params] ) : string`

|Argument name|Type|Description|
|------|------|------|
|`content`|`eZ\Publish\API\Repository\Values\Content\Content`|Content item the displayable field belongs to.|
|`fieldDefinitionIdentifier`|`string`|The identifier the Field is referenced by.|
|`params`|`hash`|Hash of parameters that will be passed to the template block.</br>By default you can pass 2 entries:</br>`lang` (to override the current language, must be a valid locale with xxx-YY format)</br>`template` (to override the template to use, see below)</br>`attr` (hash of HTML attributes you want to add to the inner markup)</br>parameters (arbitrary parameters to pass to the template block)</br></br>Some Field Types might expect specific entries under the `parameters` key, like the [MapLocation Field Type](../api/field_type_reference.md#maplocation-field-type).

#### Override a Field template block

If you do not want to use the built-in Field template block,
you can override it by specifying your own template.
You can do this [inline](#inline-override) when calling `ez_render_field()`,
or [globally](#global-override) by prepending a Field template to use by the helper.

Your template block must comply to a regular Field Type template block, [as explained in the Field Type documentation](../api/field_type_form_and_template.md).

##### Inline override

You can use the template you need by filling the `template` entry in the `params` argument.

``` html+twig
{{ ez_render_field( 
       content, 
       'my_field_identifier',
       { 'template': 'fields/my_field_template.html.twig' }
   ) }}
```

This code will load `my_field_template.html.twig` located in `templates/fields/`.

``` html+twig
{# Assuming "my_field_identifier" from the template above example is an ezkeyword field. #}
{% block ezkeyword_field %}
    {% apply spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endapply %}
{% endblock %}
```

!!! tip "Overriding a block and calling the parent"

    When overriding a Field template block, it is possible to call its parent.
    For this, you need to import the original template horizontally (without inheritance),
    using the [`use` Twig tag](http://twig.sensiolabs.org/doc/tags/use.html).

    ``` html+twig
    {# templates/fields/my_field_template.html.twig #}
    {# Assuming "my_field_identifier" from above template example is an ezkeyword field. #}
     
    {% use "@EzPublishCore/content_fields.html.twig" with ezkeyword_field as base_ezkeyword_field %}
     
    {# Surround base block with a simple div #}
    {% block ezkeyword_field %}
        <div class="ezkeyword">
            {{ block("base_ezkeyword_field") }}
        </div>
    {% endblock %}
    ```

##### Inline override using current template

If you want to override a specific Field template only once
(e.g. because your override would be only valid in your current template),
you can specify the current template to be the source of the Field block.

``` html+twig
{% extends "pagelayout.html.twig" %}

{% block content %}
    {# Note that "tags" is a field using ezkeyword fieldType #}
    <div class="tags">{{ ez_render_field( content, "tags" , { "template": _self } ) }}</div>
{% endblock %}

{# Here begins the inline block for my ezkeyword Field #}
{% block ezkeyword_field %}
    {% apply spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endapply %}
{% endblock %}
```

!!! caution "Limitation"

    **Using `_self` will only work if your current template is extending another one.**

    This is basically the same limitation as for [Symfony form themes](https://symfony.com/doc/5.0/form/form_themes.html).

##### Global override

If you want to override a Field template every time it occurs,
you can append it to the Field templates list.

``` yaml
ezplatform:
    system:
        my_siteaccess:
            field_templates:
                - 
                    template: fields/my_field_template.html.twig
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

It will then be used every time the Field is rendered with `ez_render_field()`.

!!! tip

    Because built-in Field templates have `priority` of `0`, you need to set yours to a higher value to override them.

The content of the template must be placed in a Twig block corresponding to the Field Type's internal name
(e.g. `{% block ezstring_field %}`) for `ezstring`.

The template must also extend `EzPublishCore/content_fields.html.twig`.

``` html+twig
{% extends "@EzPublishCore/content_fields.html.twig" %}

{% block ezstring_field %}
    {# template content here #}
{% endblock %}
```

### `ez_short_datetime`, `ez_short_date`, `ez_short_time`

These Twig filters are used to [format date and time](../extending/extending_date_and_time.md).
The formats are defined in [user preferences](config_back_office.md#date-and-time-formats).

| Twig filter | Description |
|-------------|-------------|
| `ez_short_datetime` | outputs date and time in short format |
| `ez_short_date` | outputs date in short format |
| `ez_short_time` | outputs time in short format |

The filters accept `\DateTimeInterface` as argument.
If the argument is null, the filter returns the current date and time in the selected format.

For example `{{ contentInfo.publishedDate|ez_full_datetime }}` will return `03 May 2019 23:03`.

The filters also accept an optional `timezone` parameter for displaying date and time in a chosen time zone.

### `ez_urlalias`

#### Description

`ez_urlalias` is a not a real Twig helper, but a special route name for generating URLs for a Location from the given parameters.

#### Prototype and Arguments

`ez_path( eZ\Publish\API\Repository\Values\Content\Location|
    \eZ\Publish\API\Repository\Values\Content\Content|
    \eZ\Publish\API\Repository\Values\Content\ContentInfo|
    \eZ\Publish\API\Repository\Values\Content\Location|
    \eZ\Publish\Core\MVC\Symfony\Routing\RouteReference name [, array parameters ] [, bool absolute ] ) : string`

|Argument name|Type|Description|
|------|------|------|
|`name`|`string | `\eZ\Publish\API\Repository\Values\Content\Location`</br>`\eZ\Publish\API\Repository\Values\Content\Content`</br>`\eZ\Publish\API\Repository\Values\Content\ContentInfo`</br>`\eZ\Publish\API\Repository\Values\Content\Location`</br>`\eZ\Publish\Core\MVC\Symfony\Routing\RouteReference`|The name of the route, Location or Content instance|
|`parameters`|`array`|A hash of parameters:</br>`locationId`</br>`contentId`|
|`absolute`|`boolean`|Whether to generate an absolute URL|

#### Working with Location

Linking to other Locations is fairly easy and is done with the `ez_path()` Twig helper (or `ez_url()` if you want to generate absolute URLs). You just have to pass it the Location object and `ez_path()` will generate the URLAlias for you.

``` html+twig
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ ez_path( location ) }}">Some link to a location</a>
```

#### I don't have the Location object

##### Generating a link from a Location ID

``` html+twig
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>
```

##### Generating a link from a Content ID

``` html+twig
<a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>
```

!!! note

    Links generated from a Content ID will point to its main location.

#### Error management

For a Location alias set up a 301 redirect to the Location's current URL when:

1. the alias is historical
1. the alias is a custom one with forward flag true
1. the requested URL does not match the one loaded (case-sensitively)

!!! note "Under the hood"

    In the back end, `ez_path()` uses the Router to generate links.

    This makes it also easy to generate links from PHP, via the `router` service.
