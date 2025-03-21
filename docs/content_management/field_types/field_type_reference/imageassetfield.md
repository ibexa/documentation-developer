# ImageAsset field type

ImageAsset field type enables storing images in independent content items of a generic Image content type, in the media library.
It makes them reusable across system.

### Input expectations

Example array:

|Type|Description|Example|
|------|------|------|
|`Ibexa\Core\FieldType\ImageAsset\Value`|ImageAsset field type value object.|See below.|
|`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`|ContentInfo instance of the Asset content item. |n/a|
|`string`| ID of the Asset content item. |`"150"`|
|`integer`| ID of the Asset content item. | `150`|

### Value object

##### Properties

Value object of `ezimageasset` contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `destinationContentId`  |  `int` | Related content ID. |
| `alternativeText`  |  `string` |  The alternative image text (for example "Picture of an apple."). |

``` php
// Value object content example

$imageAssetValue->destinationContentId = $contentInfo->id;
$imageAssetValue->alternativeText = "Picture of an apple.";
```

##### Constructor

The `ImageAsset\Value` constructor initializes a new value object with the value provided.
It expects an ID of a content item representing asset and the alternative text.

``` php
// Constructor example

// Instantiates a ImageAsset Value object
$imageAssetValue  = new ImageAsset\Value($contentInfo->id, "Picture of an apple.");
```

### Validation

This field type validates if:

- `destinationContentId` points to a content item which has correct content type

### Configuration

ImageAsset field type allows configuring the following options:

|Name|Description|Default value|
|----|-----------|-------------|
|`content_type_identifier`|Content type used to store assets.|`image`|
|`content_field_identifier`|Field identifier used for asset data.|`image`|
|`name_field_identifier`|Field identifier used for asset name.|`name`|
|`parent_location_id`|Location where the assets are created.|`51`|

Example configuration:

``` yaml
ibexa:
    system:
       default:
            fieldtypes:
                ezimageasset:
                    content_type_identifier: photo
                    content_field_identifier: image
                    name_field_identifier: title
                    parent_location_id: 106
```

## Customizing ImageAsset field type rendering

Internally the Image Asset Type is rendered via subrequest (similar to other relation types).
Rendering customization is possible by configuring view type `asset_image`:

```php
ibexa:
    system:
       default:
            content_view:
                asset_image:
                    default:
                        template: ::custom_image_asset_template.html.twig
                        match: []
```

## Generating image variation from the Image Asset

Thanks to the `Ibexa\Bundle\Core\Imagine\ImageAsset` decorator you can work with `Ibexa\Contracts\Core\Variation` in the same way as with [Image field type](imagefield.md).
