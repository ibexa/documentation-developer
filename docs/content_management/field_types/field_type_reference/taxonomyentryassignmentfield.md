# Taxonomy Entry Assignment field type

The Taxonomy Entry Assignment field type is used to integrate content with the Taxonomy module.
It allows you to select tags or categories and assign them to content.

!!! caution "Duplicate taxonomy fields"

    Because tags are assigned per content item, not per field, you cannot use two **Taxonomy Entry Assignment** fields with the same taxonomy type in one content type.

To be able to assign tags to the content, first, you need to add a Taxonomy Entry Assignment field to the content type definition.

| Name                      | Field type identifier             |
|---------------------------|-----------------------------------|
| Taxonomy Entry Assignment | `ibexa_taxonomy_entry_assignment` |

## Field value

The field value is an object with the following keys:

| Key                | Type     | Description                                                          | Example              |
|--------------------|----------|----------------------------------------------------------------------|----------------------|
| `taxonomy_entries` | `array`  | IDs of the assigned taxonomy entries.                                | `[3]`                |
| `taxonomy`         | `string` | Identifier of the taxonomy that all the entries must be assigned to. | `product_categories` |

Set the `taxonomy` value to the same identifier as the `taxonomy` setting of the field definition.

``` json
{
    "fieldDefinitionIdentifier": "category",
    "languageCode": "eng-GB",
    "fieldValue": {
        "taxonomy_entries": [3],
        "taxonomy": "product_categories"
    }
}
```

## Validation

Entry IDs that don't exist are removed from the value instead of causing an error, so a request can succeed with fewer entries than you sent.
Check the entries in the response to confirm which of them were stored.

## Settings

| Name       | Type     | Default value | Description                                                |
|------------|----------|---------------|--------------------------------------------------------------|
| `taxonomy` | `string` | `null`        | Identifier of the taxonomy from which the entries are chosen. |

``` json
{
    "fieldSettings": {
        "taxonomy": "product_categories"
    }
}
```
