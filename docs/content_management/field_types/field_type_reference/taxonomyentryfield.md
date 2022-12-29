# TaxonomyEntry Field Type

TaxonomyEntry is a general purpose Field Type that can select only one taxonomy entry (tag or product type). 
It is used as a parent while creating a tag or category.

| Name           | Internal name         | Expected input |
|----------------|-----------------------|----------------|
| `TaxonomyEntry`| `ibexa_taxonomy_entry`| `TaxonomyEntry`|

## PHP API Field Type 

### Input expectations

| Type    | Example         |
|---------|-----------------|
| `object` | `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry`|

### Value object

#### Properties

|Property|Type|Description|
|--------|----|-----------|
|`$taxonomyEntry`|`null`|Stores selected taxonomy entry.|

#### Example input

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
#### String representation

An ISBN's string representation is the `$taxonomyEntry` property's value, as a string.

#### Constructor

Constructor accepts `Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` object.

``` php
// Constructor example
use Ibexa\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```

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