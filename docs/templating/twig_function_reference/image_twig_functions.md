---
description: Image Twig functions enable rendering images in a specific variation.
---

# Image Twig functions

- [`ibexa_image_alias`](#ibexa_image_alias) returns the selected variation of an image Field.
- [`ibexa_content_field_identifier_first_filled_image`](#ibexa_content_field_identifier_first_filled_image) returns the identifier of the first image Field in a Content item that is not empty.

## Image rendering

To render images, use the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function
with the variation name passed as an argument, for example:

``` html+twig
[[= include_file('docs/templating/twig_function_reference/field_twig_functions.md', 38, 45) =]]
```

## Image information

### `ibexa_image_alias()`

`ibexa_image_alias()` returns the selected variation of an image Field.

| Argument | Type | Description |
|-----|-----|-----|
| `field` | `Ibexa\Contracts\Core\Repository\Values\Content\Field` | The image Field. |
| `versionInfo` | `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` | The VersionInfo that the Field belongs to. |
| `variantName` | `string` | Name of the image variation to be used. To display the original image variation, use `original` as the variation name. |

``` html+twig
{% set thumbnail = ibexa_image_alias(imageField, content.versionInfo, 'small') %}
```

!!! tip

    You can access the name of a variation from the variation object with `variation.name`.
    You can, for example, use it as parameter in the
    [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.

### `ibexa_content_field_identifier_first_filled_image()`

`ibexa_content_field_identifier_first_filled_image()` returns the identifier of the first image field that is not empty.

!!! caution

    This function works only for [Image](imagefield.md) Fields.
    It does not work for [ImageAsset](imageassetfield.md) Fields.

| Argument | Type | Description |
| ------ |----- | ----- |
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item to display the image for. |

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
```

#### Examples

You can use `ibexa_content_field_identifier_first_filled_image()`
to find and render the first existing image in an article:

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
{{ ibexa_render_field(content, firstImage) }}
```
