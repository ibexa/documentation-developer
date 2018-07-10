# Twig Functions Reference

!!! note "Symfony and Twig template functions/filters/tags"

    For the template functionality provided by Symfony Framework, see [Symfony Twig Extensions Reference page](http://symfony.com/doc/current/reference/twig_reference.html). For those provided by the underlying Twig template engine, see [Twig Reference page](http://twig.sensiolabs.org/documentation#reference)

In addition to the [native functions provided by Twig](http://twig.sensiolabs.org/doc/functions/index.html), eZ Platform offers the following:

- [`ez_content_name`](#ez_content_name) - displays a Content item's name in the current language
- [`ez_field_description`](#ez_field_description) - returns the description from the FieldDefinition of a Content item's Field in the current language
- [`ez_field_name`](#ez_field_name) - returns the name from the FieldDefinition of a Content item's Field in the current language
- [`ez_field_value`](#ez_field_value) - returns a Content item's Field value in the current language
- [`ez_field`](#ez_field) - returns a Field from a Content item in the current language
- [`ez_file_size`](#ez_file_size) - returns the size of a file as string
- [`ez_first_filled_image_field_identifier`](#ez_first_filled_image_field_identifier) - returns the identifier of the first image field that is not empty
- [`ez_image_alias`](#ez_image_alias) - displays a selected variation of an image
- [`ez_is_field_empty`](#ez_is_field_empty) - checks if a Content item's Field value is considered empty in the current language
- [`ez_render_field`](#ez_render_field) - displays a Content item's Field value, taking advantage of the template block exposed by the Field Type used
- [`ez_trans_prop`](#ez_trans_prop) - gets the translated value of a multi valued(translations) property
- [`ez_urlalias`](#ez_urlalias) - is a special route name for generating URLs for a Location from the given parameters

### `ez_content_name`

#### Description

`ez_content_name()` is a Twig helper which displays a Content item's name in the current language.

If the Content item does not have a translation in the current language, the name in the main language is always returned. This behavior is identical when forcing a language.

If languages were specified during retrieval of Content object, you can render name directly using `$content->getName()` (Twig: `content.name`) and it will take the prioritised languages into account. If not, it falls back to the main language, just like **ez\_content\_name()** does. For usage with ContentInfo, see examples below.

#### Prototype and Arguments

`ez_content_name( eZ\Publish\API\Repository\Values\Content\Content content[, string forcedLanguage] )ez_content_name(contentInfo[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content or ContentInfo object the displayable field belongs to.|
| `forcedLanguage` | `string` | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html
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

`ez_field_description()` is a Twig helper which returns the description from the FieldDefinition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_field_description( Content|ContentInfo content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content/ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the FieldDefinition description from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "eng-US"), otherwise takes prioritized languages from SiteAccess settings. |

#### Usage

``` html
<p id="ez-content-article-title-description">{{ ez_field_description( content, "title" ) }}</p>
```

### `ez_field_name`

#### Description

`ez_field_name()` is a Twig helper which returns the name from the FieldDefinition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_field_name( Content|ContentInfo content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content / ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the FieldDefinition name from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "`jpn-JP`"), otherwise takes prioritized languages from SiteAccess settings. |

#### Usage

``` html
<label for="ez-content-article-title">{{ ez_field_name( content, "title" ) }}</label>
```

### `ez_field_value`

#### Description

`ez_field_value()` is a Twig helper which returns a Content item's Field value in the current language.

This can be useful when you don't want to use [`ez_render_field`](#ez_render_field) and manage the rendering by yourself.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

!!! tip

    If languages were specified during retrieval of Content object, you can get field value directly using `content->getFieldValue('title')` and it will take the prioritised languages into account. If not, it falls back to the main language, just like **ez\_field\_value()** does.

#### Prototype and Arguments

`ez_field_value( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier[, string forcedLanguage] ): eZ\Publish\Core\FieldType\Value`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content object the field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html
<h2>My title value: {{ ez_field_value( content, "title" ) }}</h2>
```

### `ez_field`

#### Description

`ez_field()` is a Twig helper which returns a Field  in the current language. The field gives you access to the field value, as well as the Field's Definition and Type identifiers.

!!! tip

    Other Twig helpers are available to display specific information of the Field; they all start with `ez_field_`.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

!!! tip

    If languages were specified during retrieval of Content object, you can get field directly using `content->getField('title')` and it will take the prioritised languages into account. If not, it falls back to the main language, just like **ez\_field()** does.

#### Prototype and Arguments

`ez_field( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier[, string forcedLanguage] ): eZ\Publish\API\Repository\Values\Content\Field`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content object the field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

``` html
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

``` html
{{ 42698273|ez_file_size( 3 ) }} //Output with French SiteAccess : 42,698 MB

{{ 42698273|ez_file_size( 4 ) }} //Output with English SiteAccess : 42.6983 MB
```

### `ez_first_filled_image_field_identifier`

#### Description

`ez_first_filled_image_field_identifier` is a Twig helper which returns the identifier of the first image field that is not empty.

It can be used for example to identify the first image in an article to render it in an embed or line view.

#### Prototype and Arguments

`ez_first_filled_image_field_identifier ( eZ\Publish\API\Repository\Values\Content\Content content )`

| Argument name | Type                                               | Description                       |
|---------------|----------------------------------------------------|-----------------------------------|
| `content`     | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Fields belong to |

### `ez_image_alias`

#### Description

`ez_image_alias()` is a Twig helper that displays a selected variation (alias) of an image.

#### Prototype and Arguments

`ez_image_alias( eZ\Publish\API\Repository\Values\Content\Field field, eZ\Publish\API\Repository\Values\Content\VersionInfo versionInfo, string variantName )`

| Argument name | Type                                                   | Description                               |
|---------------|--------------------------------------------------------|-------------------------------------------|
| `field`       | `eZ\Publish\API\Repository\Values\Content\Field`       | The image Field                           |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo that the Field belongs to |
| `variantName` | `string`                                               | Name of the image variation to be used        |

See [images](images.md) for more information about image variations.

### `ez_is_field_empty`

#### Description

`ez_is_field_empty()` is a Twig helper which checks if a Content item's Field value is considered empty in the current language.

It returns a boolean value (`true` or `false`).

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

#### Prototype and Arguments

`ez_is_field_empty( eZ\Publish\API\Repository\Values\Content\Content content, eZ\Publish\API\Repository\Values\Content\Field|string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the displayed Field belongs to. |
| `fieldDefIdentifier` | `eZ\Publish\API\Repository\Values\Content\Field or string` | The Field you want to check or its identifier. |
| `forcedLanguage` | `string` | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

#### Usage

##### Using the Field identifier as parameter

``` html
{# Display "description" field if not empty #}
{% if not ez_is_field_empty( content, "description" ) %}
    <div class="description">
        {{ ez_render_field( content, "description" ) }}
    </div>
{% endif %}
```

##### Using the Field as parameter

``` html
{# Display "description" field if not empty #}
{% if not ez_is_field_empty( content, field ) %}
    <div class="description">
        {{ ez_render_field( content, field.fieldDefIdentifier ) }}
    </div>
{% endif %}
```

##### Checking if Field exists before use

``` html
{# Display "description" field if it exists and is not empty #}
{% if content.fields.description is defined and not ez_is_field_empty( content, "description" ) %}
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

`ez_render_field( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefinitionIdentifier[, hash params] )`

|Argument name|Type|Description|
|------|------|------|
|`content`|`eZ\Publish\API\Repository\Values\Content\Content`|Content item the displayable field belongs to.|
|`fieldDefinitionIdentifier`|`string`|The identifier the Field is referenced by.|
|`params`|`hash`|Hash of parameters that will be passed to the template block.</br>By default you can pass 2 entries:</br>`lang` (to override the current language, must be a valid locale with xxx-YY format)</br>`template` (to override the template to use, see below)</br>`attr` (hash of HTML attributes you want to add to the inner markup)</br>parameters (arbitrary parameters to pass to the template block)</br></br>Some Field Types might expect specific entries under the `parameters` key, like the [MapLocation Field Type](../api/field_type_reference.md#maplocation-field-type).

#### Override a Field template block

In some cases, you may not want to use the built-in field template block as it might not fit your markup needs. In this case, you can choose to override the template block by specifying your own template. You can do this inline when calling `ez_render_field()`, or globally by prepending a Field template to use by the helper.

Your template block must comply to a regular Field Type template block, [as explained in the Field Type documentation](../api/field_type_template.md).

##### Inline override

You can use the template you need by filling the `template` entry in the `params` argument.

``` html
{{ ez_render_field( 
       content, 
       'my_field_identifier',
       { 'template': 'AcmeTestBundle:fields:my_field_template.html.twig' }
   ) }}
```

The code above will load `my_field_template.html.twig` located in `AcmeTestBundle/Resources/views/fields/`.

``` html
{# AcmeTestBundle/Resources/views/fields/my_field_template.html.twig #}
{# Assuming "my_field_identifier" from the template above example is an ezkeyword field. #}
{% block ezkeyword_field %}
    {% spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endspaceless %}
{% endblock %}
```

!!! tip "Overriding a block and calling the parent"

    When overriding a field template block, it is possible to call its parent. For this, you need to import original template horizontally (without inheritance), using the [`use` Twig tag](http://twig.sensiolabs.org/doc/tags/use.html).

    ``` html
    {# AcmeTestBundle/Resources/views/fields/my_field_template.html.twig #}
    {# Assuming "my_field_identifier" from above template example is an ezkeyword field. #}
     
    {% use "EzPublishCoreBundle::content_fields.html.twig" with ezkeyword_field as base_ezkeyword_field %}
     
    {# Surround base block with a simple div #}
    {% block ezkeyword_field %}
        <div class="ezkeyword">
            {{ block("base_ezkeyword_field") }}
        </div>
    {% endblock %}
    ```

##### Inline override using current template

If you want to override a specific Field template only once (i.e. because your override would be only valid in your current template), you can specify the current template to be the source of the Field block.

``` html
<!--Inline override using current template-->
{% extends "MyBundle::pagelayout.html.twig" %}

{% block content %}
    {# Note that "tags" is a field using ezkeyword fieldType #}
    <div class="tags">{{ ez_render_field( content, "tags" , { "template": _self } ) }}</div>
{% endblock %}

{# Here begins the inline block for my ezkeyword field #}
{% block ezkeyword_field %}
    {% spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endspaceless %}
{% endblock %}
```

!!! caution "Limitation"

    **Using `_self` will only work if your current template is extending another one.**

    This is basically the same limitation as for [Symfony form themes](http://symfony.com/doc/current/book/forms.html#global-form-theming).

##### Global override

In the case where you want to systematically reuse your own Field template instead of the default one, you can append it to the Field templates list to use by `ez_render_field()`.

To make your template available, you must register it to the system.

``` yaml
# app/config/ezplatform.yml
ezpublish:
    system:
        my_siteaccess:
            field_templates:
                - 
                    template: "AcmeTestBundle:fields:my_field_template.html.twig"
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

!!! tip

    You can define these rules in a dedicated file instead of `app/config/ezplatform.yml`. Read the [cookbook recipe to learn more about it](../cookbook/importing_settings_from_a_bundle.md).

### `ez_trans_prop`

#### Description

`ez_trans_prop()` is a generic, low level Twig helper which gets the translated value of a multi valued(translations) property.

If the Content item does not have a translation in the current language, the main language (see [further down for details](#main-language-use)) will be used if this is supported by the provided **object**. This behavior is identical when forcing a language using **forcedLanguage**.

If languages were specified during retrieval of a given value object, you can get translated values directly in several cases now, including examples below. For further info see [Internationalization](internationalization.md).

#### Prototype and Arguments

`ez_trans_prop( ValueObject object, string property[, string forcedLanguage] )`

|Argument name|Type|Description|
|------|------|------|
|`object`|`eZ\Publish\API\Repository\Values\ValueObject`|ValueObject object **property** belongs to.|
|`property`|`string`|Property to get translated value from, logic is using one of the following (in this order):</br>object method `get{property}`</br>object property `{property}s`|
|`forcedLanguage`|`string`|Optional language we want to force (e.g. `"eng-US"``), otherwise takes prioritized languages from SiteAccess settings.|

##### Main language use

Main language is be applied in the following way for Value objects that support this:

- *When attribute is retrieved via object property*: Use **mainLanguageCode** property if it exists as fallback language, but only if either **alwaysAvailable** property does not exist, or is true.
- *When attribute is retrieved via object method*: Provide `$language = null` as the only argument to the method, the logic of the ValueObject decides if this gives a fallback value or not.

#### Usage

Example below shows how this function can be used to get the Content name with exact same result as using `ez_content_name(content)`:

``` html
{{ ez_trans_prop( versionInfo, "name" ) }}
```

Example for `ContentType->names`:

``` html
{{ ez_trans_prop( contentType, "name" ) }}
```

### `ez_urlalias`

#### Description

`ez_urlalias` is a not a real Twig helper, but a special route name for generating URLs for a Location from the given parameters.

#### Prototype and Arguments

`path(  eZ\\Publish\\API\\Repository\\Values\\Content\\Location|string name\[, array parameters\]\[, bool absolute\] )`

|Argument name|Type|Description|
|------|------|------|
|`name`|`string | \eZ\Publish\API\Repository\Values\Content\Location`|The name of the route or a Location instance|
|`parameters`|`array`|A hash of parameters:</br>`locationId`</br>`contentId`|
|`absolute`|`boolean`|Whether to generate an absolute URL|

#### Working with Location

Linking to other Locations is fairly easy and is done with the [native `path()` Twig helper](http://symfony.com/doc/2.3/book/templating.html#linking-to-pages) (or `url()` if you want to generate absolute URLs). You just have to pass it the Location object and `path()` will generate the URLAlias for you.

``` html
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ path( location ) }}">Some link to a location</a>
```

#### I don't have the Location object

##### Generating a link from a Location ID

``` html
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>
```

##### Generating a link from a Content ID

``` html
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

    In the back end, `path()` uses the Router to generate links.

    This makes it also easy to generate links from PHP, via the `router` service.
