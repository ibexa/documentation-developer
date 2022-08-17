---
description: Configure image editor to crop, flip, and modify images.
---

# Configure Image Editor

When a Content item contains Fields of the [ezimage](imageassetfield.md) type, users can perform basic image editing functions with the Image Editor.
For more information, see the [user documentation]([[= user_doc =]]/editing_images/).

!!! note

    The Image Editor does not support images that come from a Digital Asset Management (DAM) system.

!!! note

    If you intend to modify images in formats other than JPEG in image editor,
    consider [adding a library to optimize them](images.md#image-optimization).

## Configuration

You can modify the default settings to change the appearance or behavior of the Image Editor.
You can also expand the default set of parameters to create buttons that may be required by custom features
that you add by extending the Image Editor, for example, to enable changes to the color palette of an image.

To do this, modify the `config/packages/ibexa.yaml` file, or create a separate 
YAML file in the `config/packages` folder, and add a settings tree similar to 
the following example.
The settings tree can contain one or more action groups.
You can control the order of actions within a group by setting the `priority` parameter.
You can also toggle the visibility of actions within the user interface.
Image Editor settings are [SiteAccess-aware](dynamic_configuration.md).

The following example sets the aspect ratio values and label names for buttons used by the Crop feature. 

``` yaml
[[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml', 0, 36) =]]
```

### Image quality

You can configure the quality of the images modified in the Image Editor with the following configuration.

The setting accepts values between 0 and 1, which corresponds to the compression level, with 0 being the strongest compression.
The default quality is 0.92:

``` yaml
[[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml', 0, 4) =]] [[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml', 39, 40) =]]
```

### Additional information

Each image can be accompanied by additional information that is not visible to the user.
By default, additional information stores the coordinates of the [focal point]([[= user_doc =]]/editing_images/#focal-point),
but you can use this extension point to pass various parameters of custom features
that you add by extending the Image Editor.

To modify the value of additional information programmatically, you can set a value of the `Image` field by using the PHP API, for example:

``` php
new FieldValue([
     'data' => [
         'width' => '100',
         'height' => '200',
         'alternativeText' => 'test',
         'mime' => 'image/png',
         'id' => 1,
         'fileName' => 'image.png',
         'additionalData' => [
             'focalPointX' => 50,
             'focalPointY' => 100,
             'author' => 'John Smith',
         ],
     ],
 ]),
```
