# TaxonomyEntryAssignment Field Type

 Taxonomy Entry Assignment Field controlls and configures taxonomy, so you can use multiple Fields of this type with different taxonomies, for example, tags and product categories in the same Content Type. To be able to assign tags to a Content, first, you need to add a Taxonomy Entry Assignment Field to the Content Type definition.

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