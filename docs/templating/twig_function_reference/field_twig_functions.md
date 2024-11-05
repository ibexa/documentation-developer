---
description: Field Twig function enable rendering content Fields, their values and their information.
page_type: reference
---

# Field Twig functions

Field Twig functions render specific Fields of a content item
and provide information about them.

- [`ibexa_render_field()`](#ibexa_render_field) renders the selected Field of a content item.
- [`ibexa_field_value()`](#ibexa_field_value) returns the Field value object.
- [`ibexa_field()`](#ibexa_field) returns the Field object.

`ibexa_field()` returns the *Field object*, and `ibexa_field_value()` returns the *Field's raw value*.
`ibexa_render_field()` is the Twig function intended for rendering the Field on the front page.

You can get additional information about a Field by using the following Twig functions:

- [`ibexa_field_name()`](#ibexa_field_name) returns the name of a content item's Field.
- [`ibexa_field_description()`](#ibexa_field_description) returns the description of a content item's Field.
- [`ibexa_field_is_empty()`](#ibexa_field_is_empty) returns Boolean information whether a Field of a content item is empty.
- [`ibexa_field_group_name()`](#ibexa_field_group_name) returns a human-readable name of the Field group.
- [`ibexa_has_field()`](#ibexa_has_field) checks whether a Field is present in the content item.


## Field rendering

### `ibexa_render_field()`

`ibexa_render_field()` renders the selected Field of a content item.
The Field is rendered with the default template, but you can optionally pass a different template as parameter as well.

| Argument | Type | Description |
| ------ | ----- | ----- |
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item the Field belongs to. |
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

#### Parameters

You can pass the following parameters to `ibexa_render_field()`:

- `lang` - language to render the Field in (overrides the current language), must be a valid locale in xxx-YY format
- `template` - Field template to use
- `attr` - hash of HTML attributes to add to the tag
- parameters - arbitrary parameters to pass to the template block.
Some Field Types, like the [MapLocation Field Type](maplocationfield.md), expect specific parameters.

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

`ibexa_field_value()` returns the Field value object.

The function returns the value of the Field only.
To render the Field with default or custom templates, use [`ibexa_render_field()`](#ibexa_render_field) instead.
If the content item does not have a translation in the prioritized or passed language,
the function returns the value in the main language.

| Argument | Type | Description |
|-----|------|-----|
| `content`| `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item the Field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage`  | `string` | (optional) Language to use (for example, "fre-FR"). |

``` html+twig
{{ ibexa_field_value(content, 'image') }}
```

### `ibexa_field()`

`ibexa_field()` returns the Field object.
The Field gives you access to the Field value, as well as the Field's definition identifier and Field Type identifier.
If the content item does not have a translation in the prioritized or passed language,
the function returns the Field object in the main language.

| Argument | Type | Description |
|-------|------|------|
| `content`| `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item the Field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | {optional) Language to use (for example, "fre-FR"). |

You can access the Field's value by using `(ibexa_field(content, 'my_field').value)`,
but it is recommended to use the dedicated [`ibexa_field_value()`](#ibexa_field_value) function for this.

You can use `ibexa_field()` to access the Field Type identifier:

``` html+twig
{{ ibexa_field(content, 'my_field').fieldTypeIdentifier }}
```

## Field information

### `ibexa_field_name()`

`ibexa_field_name()` returns the name of a content item's Field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the content item does not have a translation in the prioritized or passed language,
the function returns the name in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` or `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |


``` html+twig
{{ ibexa_field_name(content, 'title') }}

{{ ibexa_field_name(content, 'title', 'ger-DE') }}
```

### `ibexa_field_description()`

`ibexa_field_description()` returns the description of a content item's Field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the content item does not have a translation in the prioritized or passed language,
the function returns the description in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` or `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ibexa_field_description(content, 'title') }}

{{ ibexa_field_description(content, 'title', 'ger-DE') }}
```

### `ibexa_field_is_empty()`

`ibexa_field_is_empty()` returns Boolean information whether a given Field of a content item is empty.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` or `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ibexa_field_is_empty(content, 'title') }}
```

#### Examples

For example, use `ibexa_field_is_empty()` to check whether a Field is empty or filled before rendering it:

``` html+twig
{% if not ibexa_field_is_empty(content, 'image') %}
    {{ ibexa_render_field(content, 'image') }}
{% endif %}
```

### `ibexa_field_group_name()`

`ibexa_field_group_name()` returns a human-readable name of a Field group.

| Argument | Type | Description |
|---------------|------|-------------|
| `fieldGroupIdentifier` | `string` | Field group [identifier](repository_configuration.md#field-groups-configuration). |


``` html+twig
{{ ibexa_field_group_name('content') }}
```

### `ibexa_has_field()`

`ibexa_has_field()` returns Boolean information whether a Field is present in the content item.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item the Field may belong to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |

``` html+twig
{% if ibexa_has_field(content, 'existing') %}
    {{ ibexa_render_field(content, 'existing') }}
{% endif %}
```