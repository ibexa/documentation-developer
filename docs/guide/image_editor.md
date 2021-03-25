# Configuring the Image Editor

When a Content item contains Fields of the [ezimage](../api/field_types_reference/imagefield.md) or [ezimageasset](../api/field_types_reference/imageassetfield.md) type, users can perform basic image editing functions with the Image Editor.
For more information, see the [user documentation](https://doc.ibexa.co/projects/userguide/en/master/editing_images/).

!!! note

    The Image Editor does not support images that come from a Digital Asset Management (DAM) system.

## Configuration

You can modify the default settings to change the appearance or behavior of the Image Editor.
You can also expand the default set of parameters to create buttons that may be required by custom features
that you add by extending the Image Editor, for example, to enable changes to the color palette of an image.

To do this, modify the `config/packages/ezplatform.yaml` file, or create a separate YAML file
in the `config/packages` folder, and add a settings tree similar to the following example.
The settings tree can contain one or more action groups.
You can control the order of actions within a group by setting the `priority` parameter.
You can also toggle the visibility of actions within the user interface.
Image Editor settings are [SiteAccess-aware](config_dynamic.md).

The following example sets the aspect ratio values and label names for buttons used by the Crop feature.

``` yaml
system:
    <siteaccess>:
        image_editor:
            action_groups:
                default:
                    id: default
                    label: Default
                    actions:
                        (...)
                        crop:
                            id: crop
                            priority: 1
                            visible: true
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
By default, additional information stores the coordinates of the [focal point](https://doc.ibexa.co/projects/userguide/en/master/editing_images/#focal-point),
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
