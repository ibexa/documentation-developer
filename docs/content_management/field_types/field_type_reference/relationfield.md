# Relation field type

This field type makes it possible to store and retrieve the value of a relation to another content item.

| Name       | Internal name           |
|------------|-------------------------|
| `Relation` | `ibexa_object_relation` |

## Field value

The field value is an object with the following keys:

| Key                      | Type              | Description                                                                       | Example                          |
|--------------------------|-------------------|-----------------------------------------------------------------------------------|----------------------------------|
| `destinationContentId`   | `integer`, `null` | ID of the related content item.                                                   | `14`                             |
| `destinationContentHref` | `string`          | REST URI of the related content item. Read-only, added by the API on output only. | `/api/ibexa/v2/content/objects/14` |

``` json
{
    "fieldDefinitionIdentifier": "sales_rep",
    "languageCode": "eng-GB",
    "fieldValue": {
        "destinationContentId": 14,
        "destinationContentHref": "/api/ibexa/v2/content/objects/14"
    }
}
```

When you create or update a field, provide `destinationContentId` only.

## Validation

This field type validates whether the provided relation exists.

## Settings

The field definition of this field type can be configured with the following options:

| Name                    | Type      | Default value       | Description                                                                              |
|-------------------------|-----------|---------------------|--------------------------------------------------------------------------------------------|
| `selectionMethod`       | `string`  | `"SELECTION_BROWSE"` | Method of selection in the editing interface. Only `"SELECTION_BROWSE"` is implemented. |
| `selectionRoot`         | `string`  | `""`                | ID of the Location that the selection is rooted at.                                       |
| `rootDefaultLocation`   | `boolean` | `false`             | When `true`, the selection starts from the default Location.                              |
| `selectionContentTypes` | `array`   | `[]`                | An array of content type identifiers that are allowed for the related content item.      |

On output, when `selectionRoot` is set, the API adds a read-only `selectionRootHref` key with the REST URI of that Location.

``` json
{
    "fieldSettings": {
        "selectionMethod": "SELECTION_BROWSE",
        "selectionRoot": "",
        "selectionContentTypes": []
    }
}
```
