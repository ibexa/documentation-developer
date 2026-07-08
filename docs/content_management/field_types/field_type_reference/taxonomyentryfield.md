# TaxonomyEntry field type

TaxonomyEntry is a field type that stores information about the parent entry in the taxonomy tree, placing the taxonomy entry (tag or product category) in the taxonomy structure.

| Name           | Internal name         | Expected input |
|----------------|-----------------------|----------------|
| `TaxonomyEntry`| `ibexa_taxonomy_entry`| `array`|

## PHP API field type 

### Input expectations

A `TaxonomyEntry` field accepts an array with an `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object.

| Type     | Description | Example         |
|--------|-----------------|-----------------|
| `array` | array with an `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object under the `taxonomy_entry` key | see below |

Example using an `Ibexa\Taxonomy\FieldType\TaxonomyEntry\Value` object:
``` php
$taxonomyEntry = $this->taxonomyService->loadEntryByIdentifier('example_entry', 'tags');
new \Ibexa\Taxonomy\FieldType\TaxonomyEntry\Value(
    new \Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry(
            $taxonomyEntry
        )
);
```
Example using array:
``` php
[
    'taxonomy_entry' => $taxonomyEntry, // load Entry using TaxonomyService
]
```

### Value object

#### Properties

|Property|Type|Description|
|--------|----|-----------|
|`taxonomyEntry`|`Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry|null`|Stores selected taxonomy entry.|

#### Constructor

The constructor accepts an `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object.

``` php
// Constructor example
use Ibexa\Taxonomy\FieldType\TaxonomyEntry;

// Fetches TaxonomyEntry from TaxonomyService
$taxonomyEntry = $this->taxonomyService->loadEntryByIdentifier('example_entry', 'tags');
 
// Instantiates a checkbox value with a checked state
$taxonomyEntryFieldTypeValue = new TaxonomyEntry\Value($taxonomyEntry);
```
#### String representation

`taxonomyEntry` string identifier or empty string if no Taxonomy Entry is selected.

#### Hash format

An array with `taxonomy_entry` key containing `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object or `null`.

#### Validation

No validation.

#### Settings

The field definition of this field type can be configured with the following options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`taxonomy`|`string`|`null`|Taxonomy from which you choose an entry.|

#### Template rendering

The `TaxonomyEntry field` is rendered with the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.
