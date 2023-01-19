# TaxonomyEntryAssignment Field Type

`TaxonomyEntryAssignment` Field is used to integrate content with Taxonomy module. It allows you to select tags or categories and assign them to the content. This Field Type actually assigns tags to the content in the data action, so then you can use TaxonomyService on this content. To be able to assign tags to the content, first, you need to add a `TaxonomyEntryAssignment` Field to the Content Type definition.

| Name                     | Internal name                    | Expected input |
|--------------------------|----------------------------------|----------------|
| `TaxonomyEntryAssignment`| `ibexa_taxonomy_entry_assignment`| array with `taxonomyEntries` and `taxonomy` keys|

## PHP API Field Type 

### Input expectations

| Type     | Description | Example         |
|--------|-----------------|-----------------|
| `array` | array with `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` objects under `taxonomy_entries` key and Taxonomy identifier under `taxonomy` key | see below |

Example using `Ibexa\Taxonomy\FieldType\TaxonomyEntryAssignment\Value` object:
``` php
$taxonomyEntry1 = $this->taxonomyService->loadEntryByIdentifier('example_entry', 'tags');
$taxonomyEntry2 = $this->taxonomyService->loadEntryByIdentifier('example_entry_2', 'tags');
new \Ibexa\Taxonomy\FieldType\TaxonomyEntryAssignment\Value(
    [
        $taxonomyEntry1,
        $taxonomyEntry2,
        // ...
    ],
    'tags', 
);
```

Example using array:
``` php
[
    'taxonomy_entries' => [$taxonomyEntry, $taxonomyEntry2], // load entries using TaxonomyService
    'taxonomy' => 'tags',
]
```

### Value object

#### Properties

|Property|Type|Description|
|--------|----|-----------|
|`$taxonomyEntry`|array of `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry`|Stores selected taxonomy entry.|
|`$taxonomy`|`string`|Stores taxonomy identifier, all `&taxonomyEntries` have to be assigned to this taxonomy and the identifier has to match to the settings of the Field Type in Content Type configuration.|

#### Constructor

Constructor accepts `$taxonomyEntries` and `$taxonomy` as described above.

#### String representation

If has no entries: empty string
With entries: "Cars and 5 more" - a string displaying first taxonomy entry and number of rest of the entries

#### Hash format

An array of:

- `taxonomy_entries` with numerical IDs of entries.
- `taxonomy` string identifier of a taxonomy.

#### Validation

FieldType validates if all Taxonomy Entries from the Value are assigned to configured taxonomy.

#### Settings

Name|Type|Default value|Description|
|------|------|------|------|
|`taxonomy`|`string`|`null`|Taxonomy from which entry is chosen.|

#### Template rendering

The `TaxonomyEntryAssignment` field is rendered with the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.