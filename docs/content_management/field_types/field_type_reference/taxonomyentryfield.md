# TaxonomyEntry field type

TaxonomyEntry is a field type that stores information about the parent entry in the taxonomy tree, placing the taxonomy entry (tag or product category) in the taxonomy structure.

| Name           | Internal name         | Expected input |
|----------------|-----------------------|----------------|
| `TaxonomyEntry`| `ibexa_taxonomy_entry`| `array`|

## Input expectations

A `TaxonomyEntry` field accepts an array with an `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object.

| Type     | Description | Example         |
|--------|-----------------|-----------------|
| `array` | array with an `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object under the `taxonomy_entry` key | see below |

Example using an `Ibexa\Taxonomy\FieldType\TaxonomyEntry\Value` object:

Example using array:

### Properties

|Property|Type|Description|
|--------|----|-----------|
|`taxonomyEntry`|`?Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry`|Stores selected taxonomy entry.|

### Hash format

An array with `taxonomy_entry` key containing `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object or `null`.

### Validation

No validation.

### Settings

The field definition of this field type can be configured with the following options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`taxonomy`|`string`|`null`|Taxonomy from which you choose an entry.|
