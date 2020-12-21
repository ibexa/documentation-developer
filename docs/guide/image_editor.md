# Configuring the Image Editor

## Introduction

When a Content Item contains Fields of the [ezimage](../api/field_type_reference.md#image-field-type) or [ezimageasset](../api/field_type_reference.md#imageasset-field-type) type, users can perform basic image editing functions with the Image Editor.
For more information, see the [user documentation](https://doc.ibexa.co/projects/userguide/en/master/editing_images/).

## Configuration

You can modify the default settings to change the appearance or behaviour of the Image Editor.
You can also expand the default set of parameters to create buttons that may be required by custom features that you add by [extending the Image Editor](#extending-the-image-editor).
To do this, modify the `config/packages/ezplatform.yaml` file, or create a separate YAML file in the `config/packages` folder, and add a settings tree similar to the following example.
Image Editor settings are [dynamic](config_dynamic.md), therefore you can configure a different set of buttons or preset values for each of the SiteAccesses in your installation.
The example sets the aspect ratio values and label names for buttons used by the Crop feature.


``` yaml
system:
    <siteaccess_name>:
        image_editor:
            action_groups:
                default:
                    id: default
                    label: Default
                    actions:
                        (...)
                        crop:
                            id: crop
                            buttons:
                                1-1:
                                    label: 1:1
                                    ratio:
                                        x: 1
                                        y: 1
                                3-4:
                                    label: 3:4
                                    ratio:
                                        x: 3
                                        y: 4
                                4-3:
                                    label: 4:3
                                    ratio:
                                        x: 4
                                        y: 3
                                16-9:
                                    label: 16:9
                                    ratio:
                                        x: 16
                                        y: 9
                                custom:
                                    label: Custom
```

### Additional information

Each image can be accompanied by additional information that is not visible to the user.
By default, additional information serves to store the coordinates of the [focal point](https://doc.ibexa.co/projects/userguide/en/master/editing_images/#focal-point), but you can use this extension point to pass various parameters of custom features that you add by [extending the Image Editor](#extending-the-image-editor).

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
 
## Extending the Image Editor

You can extend the Image Editor if your users require additional features.
For example, you can create a feature that modifies the colour palette of an image.
