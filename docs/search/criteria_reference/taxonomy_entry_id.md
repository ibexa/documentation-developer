---
description: TaxonomyEntryId Search Criterion
---

# TaxonomyEntryId Criterion

The [`TaxonomyEntryId` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Criterion-TaxonomyEntryId.html) searches for content based on the ID of the Taxonomy Entry it's assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Tag(s)
- `taxonomyIdentifier` - string representing the identifier of the taxonomy the entries belong to, for example, `tags` or `product_categories`

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion;

$query = new Query();
$query->query = new Criterion\TaxonomyEntryId(1, 'tags');
```

Add an array of ID's to find Content tagged with at least one of the tags (OR).

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion;

$query = new Query();
$query->query = new Criterion\TaxonomyEntryId([1, 2, 3], 'tags');
```
