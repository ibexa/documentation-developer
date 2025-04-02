---
description: Field Twig function enable rendering content fields, their values and their information.
page_type: reference
---

# Field Twig functions

Field Twig functions render specific fields of a content item and provide information about them.

- [`ibexa_render_field()`](#ibexa_render_field) renders the selected field of a content item.
- [`ibexa_field_value()`](#ibexa_field_value) returns the field value object.
- [`ibexa_field()`](#ibexa_field) returns the field object.

`ibexa_field()` returns the *Field object*, and `ibexa_field_value()` returns the *Field's raw value*.
`ibexa_render_field()` is the Twig function intended for rendering the field on the front page.

You can get additional information about a field by using the following Twig functions:

- [`ibexa_field_name()`](#ibexa_field_name) returns the name of a content item's field.
- [`ibexa_field_description()`](#ibexa_field_description) returns the description of a content item's field.
- [`ibexa_field_is_empty()`](#ibexa_field_is_empty) returns Boolean information whether a field of a content item is empty.
- [`ibexa_field_group_name()`](#ibexa_field_group_name) returns a human-readable name of the field group.
- [`ibexa_has_field()`](#ibexa_has_field) checks whether a field is present in the content item.


## Field rendering

### `ibexa_render_field()`

`ibexa_render_field()` renders the selected field of a content item.
The field is rendered with the default template, but you can optionally pass a different template as parameter as well.

| Argument | Type | Description |
| ------ | ----- | ----- |
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to. |
| `fieldDefinitionIdentifier` | `string` | Field identifier. |
| `params` | `hash` | (optional) Hash of parameters passed to the template block. |

``` html+twig
{{ ibexa_render_field(content, 'title') }}

{{ ibexa_render_field(content, 'image', {
    'template': '@ibexadesign/fields/image.html.twig',
    'attr': {class: 'thumbnail-image'},
    'parameters': {
        'alias': 'small'
    }
}) }}
```

``` html+twig
{{ ibexa_render_field(product, 'name') }}

{{ ibexa_render_field(product, 'image', {
    'template': '@ibexadesign/fields/image.html.twig',
    'attr': {class: 'thumbnail-image'},
    'parameters': {
        'alias': 'small'
    }
}) }}
```

#### Parameters

You can pass the following parameters to `ibexa_render_field()`:

- `lang` - language to render the field in (overrides the current language), must be a valid locale in xxx-YY format
- `template` - field template to use
- `attr` - hash of HTML attributes to add to the tag
- parameters - arbitrary parameters to pass to the template block.
Some field types, like the [MapLocation field type](maplocationfield.md), expect specific parameters.

#### Examples

``` html+twig
{{ ibexa_render_field(content, 'title', {
    'attr': {
        class: 'article-title'
    }
}) }}
```

## Field values

### `ibexa_field_value()`

`ibexa_field_value()` returns the field value object.

The function returns the value of the field only.
To render the field with default or custom templates, use [`ibexa_render_field()`](#ibexa_render_field) instead.
If the content item doesn't have a translation in the prioritized or passed language, the function returns the value in the main language.

| Argument | Type | Description |
|-----|------|-----|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the field. |
| `forcedLanguage`  | `string` | (optional) Language to use (for example, "fre-FR"). |

``` html+twig
{{ ibexa_field_value(content, 'image') }}
```

``` html+twig
{{ ibexa_field_value(product, 'image') }}
```

### `ibexa_field()`

`ibexa_field()` returns the field object.
The field gives you access to the field value, the field's definition identifier, and field type identifier.
If the content item doesn't have a translation in the prioritized or passed language, the function returns the field object in the main language.

| Argument | Type | Description |
|-------|------|------|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the field. |
| `forcedLanguage` | `string` | {optional) Language to use (for example, "fre-FR"). |

You can access the field's value by using `(ibexa_field(content, 'my_field').value)`,
but it's recommended to use the dedicated [`ibexa_field_value()`](#ibexa_field_value) function for this.

You can use `ibexa_field()` to access the field type identifier:

``` html+twig
{{ ibexa_field(content, 'my_field').fieldTypeIdentifier }}
```

``` html+twig
{{ ibexa_field(product, 'my_field').fieldTypeIdentifier }}
```

## Field information

### `ibexa_field_name()`

`ibexa_field_name()` returns the name of a content item's field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the content item doesn't have a translation in the prioritized or passed language, the function returns the name in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html), [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html), or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |


``` html+twig
{{ ibexa_field_name(content, 'title') }}

{{ ibexa_field_name(content, 'title', 'ger-DE') }}
```

``` html+twig
{{ ibexa_field_name(product, 'name') }}

{{ ibexa_field_name(product, 'name', 'pl-PL') }}
```

### `ibexa_field_description()`

`ibexa_field_description()` returns the description of a content item's field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the content item doesn't have a translation in the prioritized or passed language, the function returns the description in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html), [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html), or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ibexa_field_description(content, 'title') }}

{{ ibexa_field_description(content, 'title', 'ger-DE') }}
```

``` html+twig
{{ ibexa_field_description(product, 'name') }}

{{ ibexa_field_description(product, 'name', 'fr-FR') }}
```

### `ibexa_field_is_empty()`

`ibexa_field_is_empty()` returns Boolean information whether a given field of a content item is empty.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ibexa_field_is_empty(content, 'title') }}
```

``` html+twig
{{ ibexa_field_is_empty(product, 'name') }}
```

#### Examples

For example, use `ibexa_field_is_empty()` to check whether a field is empty or filled before rendering it:

``` html+twig
{% if not ibexa_field_is_empty(content, 'image') %}
    {{ ibexa_render_field(content, 'image') }}
{% endif %}
```

``` html+twig
{% if not ibexa_field_is_empty(product, 'image') %}
    {{ ibexa_render_field(product, 'image') }}
{% endif %}
```

### `ibexa_field_group_name()`

`ibexa_field_group_name()` returns a human-readable name of a field group.

| Argument | Type | Description |
|---------------|------|-------------|
| `fieldGroupIdentifier` | `string` | Field group [identifier](repository_configuration.md#field-groups-configuration). |


``` html+twig
{{ ibexa_field_group_name('content') }}
```

### `ibexa_has_field()`

`ibexa_has_field()` returns Boolean information whether a field is present in the content item.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`ContentAwareInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item the field may belong to. |
| `fieldDefIdentifier` | `string` | Identifier of the field. |

``` html+twig
{% if ibexa_has_field(content, 'existing') %}
    {{ ibexa_render_field(content, 'existing') }}
{% endif %}
```

``` html+twig
{% if ibexa_has_field(product, 'existing') %}
    {{ ibexa_render_field(product, 'existing') }}
{% endif %}
```
