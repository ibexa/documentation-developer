# TaxonomyEntry Field Type

TaxonomyEntry is a general purpose Field Type that can store only one taxonomy entry (tag or product type). 
It is used as a parent while creating a tag or category.

| Name           | Internal name         | Expected input |
|----------------|-----------------------|----------------|
| `TaxonomyEntry`| `ibexa_taxonomy_entry`| `TaxonomyEntry`|

## PHP API Field Type 

### Input expectations

Field type `TaxonomyEntry` accepts Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry object.

| Type            | Example         |
|-----------------|-----------------|
| `TaxonomyEntry` | See below. |

Example array:

``` php
new FieldType\TaxonomyEntry\Value(
	new TaxonomyEntry(
            1,
            'foobar',
            'Foobar',
            'eng-GB',
            [
                'eng-GB' => 'Foobar',
            ],
            null,
            new Content(),
            'tags',
        )
);
```

### Value object

#### Properties

|Property|Type|Description|
|--------|----|-----------|
|`$taxonomyEntry`|`null`|Stores selected taxonomy entry.|

#### Constructor

Constructor accepts `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object.

``` php
// Constructor example
use Ibexa\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```
#### String representation

An ISBN's string representation is the `$taxonomyEntry` property's value, as a string.

#### Hash format

An array with `taxonomy_entry` key containing Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry object or null.

#### Validation

No validation.

#### Settings

The Field definition of this Field Type can be configured with the following options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`taxonomy`|`string`|`null`|Taxonomy from which you choose an entry.|

#### Template rendering

The Measurement field is rendered with the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.