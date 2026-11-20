# Image Twig functions

Image Twig functions enable rendering images in a specific variation.

- [`ibexa_image_alias`](#ibexa_image_alias) returns the selected variation of an image field.
- [`ibexa_content_field_identifier_first_filled_image`](#ibexa_content_field_identifier_first_filled_image) returns the identifier of the first image field in a content item that isn't empty.

## Image rendering

To render images, use the [`ibexa_render_field()`](../field_twig_functions/index.md#ibexa_render_field) Twig function with the variation name passed as an argument, for example:

```html+twig
{{ ibexa_render_field(content, 'image', {
    'template': '@ibexadesign/fields/image.html.twig',
    'attr': {class: 'thumbnail-image'},
    'parameters': {
        'alias': 'small'
    }
}) }}
```

## Image information

### `ibexa_image_alias()`

`ibexa_image_alias()` returns the selected variation of an image field.

| Argument      | Type                                                         | Description                                                                                                            |
| ------------- | ------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------- |
| `field`       | `Ibexa\Contracts\Core\Repository\Values\Content\Field`       | The image field.                                                                                                       |
| `versionInfo` | `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` | The VersionInfo that the field belongs to.                                                                             |
| `variantName` | `string`                                                     | Name of the image variation to be used. To display the original image variation, use `original` as the variation name. |

```html+twig
{% set thumbnail = ibexa_image_alias(imageField, content.versionInfo, 'small') %}
```

> **Tip: Tip**
>
> You can access the name of a variation from the variation object with `variation.name`. You can, for example, use it as parameter in the [`ibexa_render_field()`](../field_twig_functions/index.md#ibexa_render_field) Twig function.

### `ibexa_content_field_identifier_first_filled_image()`

`ibexa_content_field_identifier_first_filled_image()` returns the identifier of the first image field that isn't empty.

> **Caution: Caution**
>
> This function works only for [Image](../../../content_management/field_types/field_type_reference/imagefield/index.md) fields. It doesn't work for [ImageAsset](../../../content_management/field_types/field_type_reference/imageassetfield/index.md) fields.

| Argument  | Type                                                                                                                                                                                                                                                                                                                 | Description                            |
| --------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------- |
| `content` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) | Content item to display the image for. |

```html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
```

```html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(product) %}
```

#### Examples

You can use `ibexa_content_field_identifier_first_filled_image()` to find and render the first existing image in an article:

```html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}
{{ ibexa_render_field(content, firstImage) }}
```
