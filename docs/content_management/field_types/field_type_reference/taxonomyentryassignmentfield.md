# TaxonomyEntryAssignment field type

`TaxonomyEntryAssignment` field is used to integrate content with the Taxonomy module.
It allows you to select tags or categories and assign them to content.

!!! caution "Duplicate taxonomy fields"

    Because tags are assigned per content item, not per field, you cannot use two **Taxonomy Entry Assignment** fields with the same taxonomy type in one content type.

To be able to assign tags to the content, first, you need to add a `TaxonomyEntryAssignment` field to the content type definition.

| Name                      | Internal name                     |
|---------------------------|-----------------------------------|
| `TaxonomyEntryAssignment` | `ibexa_taxonomy_entry_assignment` |

## Field value

The field value is an object with the following keys:

| Key                | Type     | Description                                                          | Example              |
|--------------------|----------|----------------------------------------------------------------------|----------------------|
| `taxonomy_entries` | `array`  | IDs of the assigned taxonomy entries.                                | `[3]`                |
| `taxonomy`         | `string` | Identifier of the taxonomy that all the entries must be assigned to. | `product_categories` |

The `taxonomy` value must match the `taxonomy` setting of the field definition.

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

The field type validates if all taxonomy entries from the value are assigned to the configured taxonomy.

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
