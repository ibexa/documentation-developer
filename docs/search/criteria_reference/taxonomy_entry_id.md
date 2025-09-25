---
description: TaxonomyEntryId Search Criterion
---

# TaxonomyEntryId Criterion

The [`TaxonomyEntryId` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Criterion-TaxonomyEntryId.html) searches for content based on the ID of the Taxonomy Entry it's assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Tag(s)

## Limitations

`TaxonomyEntryId` can be used on all search engines.

## Example

### PHP

```php
$query->query = new Criterion\TaxonomyEntryId(1);
// Or with multiple IDs
$query->query = new Criterion\TaxonomyEntryId([1, 2, 3]);
```
