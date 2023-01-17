# TaxonomyEntryId Criterion

The [`TaxonomyEntryId` Search Criterion](https://github.com/ibexa/taxonomy/blob/main/src/contracts/Search/Query/Criterion/TaxonomyEntryId.php)
searches for content based on the ID of the Taxonomy Entry it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Tag(s)

## Example

``` php
$query->query = new Criterion\TaxonomyEntryId(1);
```

Add an array of ID's to find Content tagged with at least one of the tags (OR).

```php
$query->query = new Criterion\TaxonomyEntryId([1, 2, 3]);
```

