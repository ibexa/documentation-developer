# TaxonomyEntryId Criterion

The [`TaxonomyEntryId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Criterion-TaxonomyEntryId.html)
searches for content based on the ID of the Taxonomy Entry it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Tag(s)

## Example

### PHP

``` php
$query->query = new Criterion\TaxonomyEntryId(1);
```

Add an array of ID's to find Content tagged with at least one of the tags (OR).

```php
$query->query = new Criterion\TaxonomyEntryId([1, 2, 3]);
```

