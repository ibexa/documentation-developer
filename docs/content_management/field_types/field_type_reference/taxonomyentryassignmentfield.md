# TaxonomyEntryAssignment Field Type

This Field Type represents one or multiple countries.

| Name           | Internal name  | Expected input |
|----------------|----------------|----------------|
| `TaxonomyEntry`| `taxonomyentry`| `mixed`        |

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