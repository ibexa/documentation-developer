# TaxonomyEntryAssignment field type

`TaxonomyEntryAssignment` field is used to integrate content with the Taxonomy module.
It allows you to select tags or categories and assign them to content.
This field type assigns tags to the content in the data action, so then you can use `TaxonomyService` on this content item.

!!! caution "Duplicate taxonomy fields"

    Because tags are assigned per content item, not per field, you cannot use two **Taxonomy Entry Assignment** fields with the same taxonomy type in one content type.

To be able to assign tags to the content, first, you need to add a `TaxonomyEntryAssignment` field to the content type definition.

| Name                      | Internal name                     | Expected input                                   |
|---------------------------|-----------------------------------|--------------------------------------------------|
| `TaxonomyEntryAssignment` | `ibexa_taxonomy_entry_assignment` | array with `taxonomyEntries` and `taxonomy` keys |

## Input expectations

| Type    | Description                                                                                                                                 | Example   |
|---------|---------------------------------------------------------------------------------------------------------------------------------------------|-----------|
| `array` | array with `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` objects under `taxonomy_entries` key and Taxonomy identifier under `taxonomy` key | see below |

Example using an `Ibexa\Taxonomy\FieldType\TaxonomyEntryAssignment\Value` object:

Example using array:

### Properties

|Property|Type|Description|
|--------|----|-----------|
|`taxonomyEntry`|array of `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry`|Stores selected taxonomy entry.|
|`taxonomy`|`string`|Stores the taxonomy identifier, all `taxonomyEntries` have to be assigned to this taxonomy and the identifier has to match the settings of the field type in content type configuration.|

### Hash format

An array of:

- `taxonomy_entries` with numerical IDs of entries.
- `taxonomy` string identifier of a taxonomy.

### Validation

The field type validates if all Taxonomy Entries from the value are assigned to the configured taxonomy.

### Settings

| Name       | Type     | Default value | Description                          |
|------------|----------|---------------|--------------------------------------|
| `taxonomy` | `string` | `null`        | Taxonomy from which entry is chosen. |
