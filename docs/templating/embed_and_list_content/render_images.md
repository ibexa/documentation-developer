---
description: Render content images and configure their variations.
---

# Render images

To render images contained in Image Asset or Image Fields, use the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.

``` html+twig
{{ ibexa_render_field(content, 'image') }}
```

You can pass the name of an [image variation](#configure-image-variation) as an argument, for example:

``` html+twig
{{ ibexa_render_field(content, 'image', {
    'parameters': {
        'alias': 'large'
    }
}) }}
```

## Render first image

If a Content item contains more than one image, you may want to select the first filled image to render.

This enables you to avoid a situation where, for example, the featured image in an article is missing,
because the first image Field was left empty.

The [`ibexa_content_field_identifier_first_filled_image()`](image_twig_functions.md#ibexa_content_field_identifier_first_filled_image) Twig function
returns the identifier of the first image Field that is not empty.

``` html+twig
{% set firstImage = ibexa_content_field_identifier_first_filled_image(content) %}

{{ ibexa_render_field(content, firstImage }}
```

!!! caution

    This function works only for [Image](imagefield.md) Fields.
    It does not work for [ImageAsset](imageassetfield.md) Fields.

## Configure image variation

The same image can have multiple variations differing in things such as scale, cropping, or applied filters.

You can use the built-in image variations or [configure your own](image_variations.md#custom-image-variations).

The following example creates a custom variation that scales the image down to a 200 x 200 thumbnail
and renders it in grayscale:

``` yaml
ibexa:
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
{{ ibexa_render_field(content, 'image', {
    'parameters': {
        'alias': 'gray_thumb'
    }
}) }}
```

## Use focal point

In the [image editor](configure_image_editor.md) you can define a focal point for an image.
The focal point does not have an instant effect when you use the default templates.
However, you can use it to select the part of the image the view focuses on when the image is cropped.

The following example shows how to use an image contained in an Image Field as a focussed background.

!!! note

    This implementation is only an example and depends on the JavaScript framework you are using.

First, in the main template, render the Image Field with a custom template:

``` html+twig
{{ ibexa_render_field(content, 'image', {
    'template': 'fields/image.html.twig'
}) }}
```

Then, create the custom Field template in `templates/fields/image.html.twig`,
[overriding the default `ezimage_field` template block](render_content.md#field-templates):

``` html+twig
{% block ezimage_field %}
    {% if field.value.additionalData.focalPointX is defined and field.value.additionalData.focalPointY is defined %}
        {% set position_x = (field.value.additionalData.focalPointX / field.value.width) * 100 %}
        {% set position_y = (field.value.additionalData.focalPointY / field.value.height) * 100 %}
    {% else %}
        {% set position_x = 50 %}
        {% set position_y = 50 %}
    {% endif %}

    {% set imageAlias = ibexa_image_alias( field, versionInfo, parameters.alias|default( 'original' ) ) %}
    {% set src = imageAlias ? asset( imageAlias.uri ) : "//:0" %}

    <div style="background: url({{ src }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: {{ position_x }}% {{ position_y }}%;
            width: 100vh; height: 20vh"></div>
{% endblock %}
```

This template uses the focal point information contained in the image's additional data
to position the background so that the focussed part of the image is displayed.
