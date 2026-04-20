---
description: TaxonomyNoEntries Search Criterion
---

# TaxonomyNoEntries Criterion

The [`TaxonomyNoEntries`](https://example.com/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Criterion-TaxonomyNoEntries.html) Search Criterion searches for content that has no entries assigned from the specified [taxonomy](taxonomy.md).

Use it when you need to find content items to which no taxonomy entries have been assigned (for example, articles without tags).
It's available for all supported search engines and in [repository filtering](search_api.md#repository-filtering).

## Arguments

- `taxonomy` - `string` representing the identifier of the taxonomy (for example, `tags` or `categories`)

## Example

### PHP

The following example searches for articles that have no entries assigned in the `tags` taxonomy:

```php hl_lines="11-16"
[[= include_file('code_samples/search/content/taxonomy_no_entries_criterion.php') =]]
```

The criteria limit the results to content that matches all of the conditions listed below:

- content has no entries assigned in the `tags` taxonomy
- content type is `article`
