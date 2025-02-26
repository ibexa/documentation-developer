---
description: Image Twig functions enable rendering images in a specific variation.
page_type: reference
---

# Image Twig functions

- [`ibexa_image_alias`](#ibexa_image_alias) returns the selected variation of an image field.
- [`ibexa_content_field_identifier_first_filled_image`](#ibexa_content_field_identifier_first_filled_image) returns the identifier of the first image field in a content item that isn't empty.

## Image rendering

To render images, use the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function with the variation name passed as an argument, for example:

``` html+twig
[[= include_file('docs/templating/twig_function_reference/field_twig_functions.md', 38, 45) =]]
```

## Image information

### `ibexa_image_alias()`

`ibexa_image_alias()` returns the selected variation of an image field.

| Argument | Type | Description |
|-----|-----|-----|
| `field` | `Ibexa\Contracts\Core\Repository\Values\Content\Field` | The image field. |
| `versionInfo` | `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` | The VersionInfo that the field belongs to. |
| `variantName` | `string` | Name of the image variation to be used. To display the original image variation, use `original` as the variation name. |

``` html+twig
{% set thumbnail = ibexa_image_alias(imageField, content.versionInfo, 'small') %}
```

!!! tip

    You can access the name of a variation from the variation object with `variation.name`.
    You can, for example, use it as parameter in the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.

### `ibexa_content_field_identifier_first_filled_image()`

`ibexa_content_field_identifier_first_filled_image()` returns the identifier of the first image field that isn't empty.

!!! caution

    This function works only for [Image](imagefield.md) fields.
    It doesn't work for [ImageAsset](imageassetfield.md) fields.

| Argument | Type | Description |
| ------ |----- | ----- |
| `content` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html)</br>or</br>[`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) | Content item to display the image for. |

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
```

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(product) %}
```

#### Examples

You can use `ibexa_content_field_identifier_first_filled_image()` to find and render the first existing image in an article:

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
{{ ibexa_render_field(content, firstImage) }}
```
