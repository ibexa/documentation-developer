# TaxonomyEntryAssignment Field Type

| Name                     | Internal name                    | Expected input |
|--------------------------|----------------------------------|----------------|
| `TaxonomyEntryAssignment`| `ibexa_taxonomy_entry_assignment`| mixed          |

## PHP API Field Type 

### Input expectations

Example array:

``` php
new FieldType\TaxonomyEntryAssignment\Value(
	[
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
	],
	'tags'
);
```