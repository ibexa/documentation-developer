# ImageAsset field type

Image Asset field type enables storing images in independent content items of a generic Image content type, in the media library.
It makes them reusable across system.

| Name         | Internal name       |
|--------------|---------------------|
| `ImageAsset` | `ibexa_image_asset` |

## Field value

The field value is an object with the following keys:

| Key                    | Type              | Description                                                                                     | Example                  |
|------------------------|-------------------|-------------------------------------------------------------------------------------------------|--------------------------|
| `destinationContentId` | `integer`, `null` | ID of the content item that holds the image asset.                                               | `150`                    |
| `alternativeText`      | `string`, `null`  | The alternative image text (for example "Picture of an apple.").                                 | `Picture of an apple.`   |
| `source`               | `string`, `null`  | Identifier of the external DAM system that the asset comes from. `null` for assets stored in [[= product_name =]]. | `null`                   |
| `variations`           | `object`          | Available image variations, keyed by variation identifier. Read-only, added by the API on output only. | See below.               |

``` json
{
    "fieldDefinitionIdentifier": "image",
    "languageCode": "eng-GB",
    "fieldValue": {
        "destinationContentId": 150,
        "alternativeText": "Picture of an apple.",
        "source": null,
        "variations": {
            "medium": {
                "href": "/api/ibexa/v2/content/binary/images/150-345-1/variations/medium"
            }
        }
    }
}
```

When you create or update a field, provide `destinationContentId` and `alternativeText` only.
Each variation URI returns a `ContentImageVariation`, the same as for the [Image field type](imagefield.md#image-variations).

## Validation

This field type validates if `destinationContentId` points to a content item which has the correct content type.
