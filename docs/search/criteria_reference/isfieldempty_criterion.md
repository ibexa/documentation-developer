---
description: IsFieldEmpty Search Criterion
---

# IsFieldEmpty Criterion

The `IsFieldEmpty` Search Criterion searches for content based on whether a specified field is empty or not.

## Arguments

- `fieldDefinitionIdentifier` - string representing the identifier of the field
- (optional) `value` - bool representing whether to search for empty (default `true`),
or non-empty fields (`false`)

## Limitations

The Richtext field type (`ibexa_richtext`) isn't searchable in the Legacy search engine.

The `IsFieldEmpty` criterion doesn't work for [Taxonomy entry assignment](taxonomyentryassignmentfield.md) fields.
For this use case, use [`TaxonomyNoEntries`](taxonomy_no_entries.md) instead.

## Use case

You can use the `IsFieldEmpty` Criterion to search for articles that don't have an image, by combining it with a content type Criterion and targeting the `image` field.
