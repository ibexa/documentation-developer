# TaxonomyEntry Field Type

| Name           | Internal name         | Expected input |
|----------------|-----------------------|----------------|
| `TaxonomyEntry`| `ibexa_taxonomy_entry`| `TaxonomyEntry`|

## PHP API Field Type 

### Input expectations

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