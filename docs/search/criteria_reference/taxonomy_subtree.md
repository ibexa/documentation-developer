---
description: TaxonomySubtree Search Criterion
---

# TaxonomySubtree Criterion

The [`TaxonomySubtree`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Criterion-TaxonomySubtree.html) Search Criterion searches for content assigned to the specified [taxonomy](taxonomy.md) entry or any of its descendants.

## Arguments

- `taxonomyEntryId` - `int` representing the ID of the taxonomy entry that is the root of the subtree

## Example

### PHP

The following example searches for articles assigned to taxonomy entry with ID `42` or any of its child entries:

```php hl_lines="11-16"
[[= include_file('code_samples/search/content/taxonomy_subtree_criterion.php') =]]
```

The criteria limit the results to content that match all of the conditions listed below:

- content is assigned to taxonomy entry `42` or any of its descendants
- content type is `article`
