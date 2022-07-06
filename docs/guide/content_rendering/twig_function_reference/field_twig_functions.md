---
description: Field Twig function enable rendering content Fields, their values and their information.
---

# Field Twig functions

Field Twig functions render specific Fields of a Content item
and provide information about them.

- [`ez_render_field()`](#ez_render_field) renders the selected Field of a Content item.
- [`ez_field_value()`](#ez_field_value) returns the Field value object.
- [`ez_field()`](#ez_field) returns the Field object.

`ez_field()` returns the *Field object*, and `ez_field_value()` returns the *Field's raw value*.
`ez_render_field()` is the Twig function intended for rendering the Field on the front page.

You can get additional information about a Field by using the following Twig functions:

- [`ez_field_name()`](#ez_field_name) returns the name of a Content item's Field.
- [`ez_field_description()`](#ez_field_description) returns the description of a Content item's Field.
- [`ez_field_is_empty()`](#ez_field_is_empty) returns Boolean information whether a Field of a Content item is empty.

## Field rendering

### `ez_render_field()`

`ez_render_field()` renders the selected Field of a Content item.
The Field is rendered with the default template, but you can optionally pass a different template as parameter as well.

| Argument | Type | Description |
| ------ | ----- | ----- |
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Field belongs to. |
| `fieldDefinitionIdentifier` | `string` | Field identifier. |
| `params` | `hash` | (optional) Hash of parameters passed to the template block. |

``` html+twig
{{ ez_render_field(content, 'title') }}

{{ ez_render_field(content, 'image', {
    'template': '@ezdesign/fields/image.html.twig',
    'attr': {class: 'thumbnail-image'},
    'parameters': {
        'alias': 'small'
    }
}) }}
```

#### Parameters

You can pass the following parameters to `ez_render_field()`:

- `lang` - language to render the Field in (overrides the current language), must be a valid locale in xxx-YY format
- `template` - Field template to use
- `attr` - hash of HTML attributes to add to the tag
- parameters - arbitrary parameters to pass to the template block.
Some Field Types, like the [MapLocation Field Type](../../../api/field_types_reference/maplocationfield.md), expect specific parameters.

#### Examples

``` html+twig
{{ ez_render_field(content, 'title', {
    'attr': {
        class: 'article-title'
    }
}) }}
```

## Field values

### `ez_field_value()`

`ez_field_value()` returns the Field value object.

The function returns the value of the Field only.
To render the Field with default or custom templates, use [`ez_render_field()`](#ez_render_field) instead.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the value in the main language.

| Argument | Type | Description |
|-----|------|-----|
| `content`| `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage`  | `string` | (optional) Language to use (for example, "fre-FR"). |

``` html+twig
{{ ez_field_value(content, 'image') }}
```

### `ez_field()`

`ez_field()` returns the Field object.
The Field gives you access to the Field value, as well as the Field's definition identifier and Field Type identifier.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the Field object in the main language.

| Argument | Type | Description |
|-------|------|------|
| `content`| `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Field belongs to.|
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | {optional) Language to use (for example, "fre-FR"). |

You can access the Field's value by using `(ez_field(content, 'my_field').value)`,
but it is recommended to use the dedicated [`ez_field_value()`](#ez_field_value) function for this.

You can use `ez_field()` to access the Field Type identifier:

``` html+twig
{{ ez_field(content, 'my_field').fieldTypeIdentifier }}
```

## Field information

### `ez_field_name()`

`ez_field_name()` returns the name of a Content item's Field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the name in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |


``` html+twig
{{ ez_field_name(content, 'title') }}

{{ ez_field_name(content, 'title', 'ger-DE') }}
```

### `ez_field_description()`

`ez_field_description()` returns the description of a Content item's Field.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the description in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ez_field_description(content, 'title') }}

{{ ez_field_description(content, 'title', 'ger-DE') }}
```

### `ez_field_is_empty()`

`ez_field_is_empty()` returns Boolean information whether a given Field of a Content item is empty.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content item the Field belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field. |
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ez_field_is_empty(content, 'title') }}
```

#### Examples

For example, use `ez_field_is_empty()` to check whether a Field is empty or filled before rendering it:

``` html+twig
{% if not ez_field_is_empty(content, 'image') %}
    {{ ez_render_field(content, 'image') }}
{% endif %}
```
