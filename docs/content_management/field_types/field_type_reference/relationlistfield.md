# Content relations (multiple) field type

This field type makes it possible to store and retrieve values of a relation to other content items.

| Name                         | Field type identifier        |
|------------------------------|------------------------------|
| Content relations (multiple) | `ibexa_object_relation_list` |

## Field value

The field value is an object with the following keys:

| Key                       | Type    | Description                                                                          | Example                                                            |
|---------------------------|---------|--------------------------------------------------------------------------------------|--------------------------------------------------------------------|
| `destinationContentIds`   | `array` | IDs of the related content items.                                                    | `[24, 42]`                                                         |
| `destinationContentHrefs` | `array` | REST URIs of the related content items. Read-only, added by the API on output only.  | `["/api/ibexa/v2/content/objects/24", "/api/ibexa/v2/content/objects/42"]` |

``` json
{
    "fieldDefinitionIdentifier": "related_articles",
    "languageCode": "eng-GB",
    "fieldValue": {
        "destinationContentIds": [24, 42],
        "destinationContentHrefs": [
            "/api/ibexa/v2/content/objects/24",
            "/api/ibexa/v2/content/objects/42"
        ]
    }
}
```

When you create or update a field, provide `destinationContentIds` only.

## Validation

This field type validates if:

- the `selectionMethod` specified is `"SELECTION_BROWSE"`. A validation error is returned if the value doesn't match.
- the `selectionDefaultLocation` specified is `null`, a string, or an integer. If the type validation fails, a validation error is returned.
- the value specified in `selectionContentTypes` is an array. If not, a validation error is returned.
- the number of content items selected in the field isn't greater than the `selectionLimit`.

## Settings

The field definition of this field type can be configured with the following options:

| Name                       | Type                  | Default value        | Description                                                                         |
|----------------------------|-----------------------|----------------------|---------------------------------------------------------------------------------------|
| `selectionMethod`          | `string`              | `"SELECTION_BROWSE"` | Method of selection in the editing interface. Only `"SELECTION_BROWSE"` is implemented. |
| `selectionDefaultLocation` | `string` or `integer` | `null`               | ID of the default Location for the selection in the editing interface.               |
| `rootDefaultLocation`      | `boolean`             | `false`              | When `true`, the selection starts from the default Location.                          |
| `selectionContentTypes`    | `array`               | `[]`                 | An array of content type identifiers that are allowed for the related content items. |

On output, when `selectionDefaultLocation` is set, the API adds a read-only `selectionDefaultLocationHref` key with the REST URI of that Location.

## Validators

| Name                                         | Type      | Default value | Description                                                                                              |
|----------------------------------------------|-----------|---------------|------------------------------------------------------------------------------------------------------------|
| `RelationListValueValidator[selectionLimit]` | `integer` | `0`           | The number of content items that can be selected in the field. When set to `0`, any number can be selected. |

``` json
{
    "validatorConfiguration": {
        "RelationListValueValidator": {
            "selectionLimit": 5
        }
    }
}
```
