# Render images

To render images contained in Image Asset or Image Fields, use the [`ez_render_field()`](../twig_function_reference/field_twig_functions.md#ez_render_field) Twig function.

``` html+twig
{{ ez_render_field(content, 'image') }}
```

You can pass the name of an [image variation](#configure-image-variation) as an argument, for example:

``` html+twig
{{ ez_render_field(content, 'image', {
    'parameters': {
        'alias': 'large'
    }
}) }}
```

## Render first image

If a Content item contains more than one image, you may want to select the first filled image to render.

This enables you to avoid a situation where, for example, the featured image in an article is missing,
because the first image Field was left empty.

The [`ez_content_field_identifier_first_filled_image()`](../twig_function_reference/image_twig_functions.md#ez_content_field_identifier_first_filled_image) Twig function
returns the identifier of the first image Field that is not empty.

``` html+twig
{% set firstImage = ez_content_field_identifier_first_filled_image(content) %}

{{ ez_render_field(content, firstImage }}
```

!!! caution

    This function works only for [Image](../../../api/field_types_reference/imagefield.md) Fields.
    It does not work for [ImageAsset](../../../api/field_types_reference/imageassetfield.md) Fields.

## Configure image variation

The same image can have multiple variations differing in things such as scale, cropping, or applied filters.

You can use the built-in image variations or [configure your own](../image_variations.md#custom-image-variations).

The following example creates a custom variation that scales the image down to a 200 x 200 thumbnail
and renders it in grayscale:

``` yaml
ezplatform:
    system:
        site_group:
            image_variations:
                gray_thumb:
                    reference: null
                    filters:
                        geometry/scaledownonly: [200, 200]
                        colorspace/gray: []
```

To use it, select the variation when rendering the image:

``` html+twig
{{ ez_render_field(content, 'image', {
    'parameters': {
        'alias': 'gray_thumb'
    }
}) }}
```
