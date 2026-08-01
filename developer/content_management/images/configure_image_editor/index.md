# Configure Image Editor

Configure image editor to crop, flip, and modify images.

When a content item contains fields of the [`ibexa_image`](../../field_types/field_type_reference/imageassetfield/index.md) type, users can perform basic image editing functions with the Image Editor.

For more information, see [User Documentation](../../../../user/image_management/edit_images/index.md).

> **Note: Note**
>
> The Image Editor doesn't support images that come from a Digital Asset Management (DAM) system.

> **Note: Note**
>
> If you intend to modify images in formats other than JPEG in image editor, consider [adding a library to optimize them](../images/index.md#image-optimization).

## Configuration

You can modify the default settings to change the appearance or behavior of the Image Editor. You can also expand the default set of parameters to create buttons that may be required by custom features that you add by extending the Image Editor, for example, to enable changes to the color palette of an image.

To do this, under the `ibexa.system.<scope>.image_editor` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files) add a settings tree similar to the following example. The settings tree can contain one or more action groups. You can control the order of actions within a group by setting the `priority` parameter. You can also toggle the visibility of actions within the user interface. Image Editor settings are [SiteAccess-aware](../../../administration/configuration/dynamic_configuration/index.md).

The following example sets the aspect ratio values and label names for buttons used by the Crop feature.

```yaml
ibexa:
    system:
        default:
            image_editor:
                action_groups:
                    default:
                        id: default
                        label: Default
                        actions:
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

### Image file size optimization

#### Image quality

You can configure the quality of the images modified in the Image Editor with the following configuration.

The setting accepts values between 0 and 1, which corresponds to the compression level, with 0 being the strongest compression. The default quality is 0.92:

```yaml
ibexa:
    system:
        default:
            image_editor:
                 image_quality: 0.8
```

#### Gaussian blur strength

You can configure the gaussian blur strength applied during image optimization with the following configuration.

```yaml
ibexa:
    system:
        default:
            image_editor:
                 gaussian_blur_strength: 0.05
```

The setting accepts float values between 0 and 10.0, where higher values increase blur and reduce file size, while lower values maintain sharpness. The default value is 0.05.

Processing large images with high blur values (above 5) can be time-consuming and may result in request timeouts. Keep this in mind when configuring blur strength for environments that handle high-resolution images, and adjust [PHP's `max_execution_time`](https://www.php.net/manual/en/info.configuration.php#ini.max-execution-time) if needed.

### Additional information

Each image can be accompanied by additional information that isn't visible to the user. By default, additional information stores the coordinates of the [focal point](../../../../user/image_management/edit_images/index.md#focal-point), but you can use this extension point to pass various parameters of custom features that you add by extending the Image Editor.

To modify the value of additional information programmatically, you can set a value of the `Image` field by using the PHP API, for example:

```php
use Ibexa\Core\FieldType\Image\Value as FieldValue;

$value = new FieldValue([
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
 ]);
```
