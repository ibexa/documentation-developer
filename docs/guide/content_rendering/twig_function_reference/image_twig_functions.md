---
description: Image Twig functions enable rendering images in a specific variation.
---

# Image Twig functions

- [`ez_image_alias`](#ez_image_alias) returns the selected variation of an image Field.
- [`ez_content_field_identifier_first_filled_image`](#ez_content_field_identifier_first_filled_image) returns the identifier of the first image Field in a Content item that is not empty.

## Image rendering

To render images, use the [`ez_render_field()`](field_twig_functions.md#ez_render_field) Twig function
with the variation name passed as an argument, for example:

``` html+twig
[[= include_file('docs/guide/content_rendering/twig_function_reference/field_twig_functions.md', 38, 45) =]]
```

## Image information

### `ez_image_alias()`

`ez_image_alias()` returns the selected variation of an image Field.

| Argument | Type | Description |
|-----|-----|-----|
| `field` | `eZ\Publish\API\Repository\Values\Content\Field` | The image Field. |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo that the Field belongs to. |
| `variantName` | `string` | Name of the image variation to be used. To display the original image variation, use `original` as the variation name. |

``` html+twig
{% set thumbnail = ez_image_alias(imageField, content.versionInfo, 'small') %}
```

!!! tip

    You can access the name of a variation from the variation object with `variation.name`.
    You can, for example, use it as parameter in the
    [`ez_render_field()`](field_twig_functions.md#ez_render_field) Twig function.

### `ez_content_field_identifier_first_filled_image()`

`ez_content_field_identifier_first_filled_image()` returns the identifier of the first image field that is not empty.

!!! caution

    This function works only for [Image](../../../api/field_types_reference/imagefield.md) Fields.
    It does not work for [ImageAsset](../../../api/field_types_reference/imageassetfield.md) Fields.

| Argument | Type | Description |
| ------ |----- | ----- |
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` | Content item to display the image for. |

``` html+twig
{% set firstImage = ez_content_field_identifier_first_filled_image(content) %}
```

#### Examples

You can use `ez_content_field_identifier_first_filled_image()`
to find and render the first existing image in an article:

``` html+twig
{% set firstImage = ez_content_field_identifier_first_filled_image(content) %}
{{ ez_render_field(content, firstImage) }}
```
