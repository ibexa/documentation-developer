# TaxonomyEntryId Criterion

TaxonomyEntryId Search Criterion

The [`TaxonomyEntryId` Search Criterion](../../../../../../ibexa/taxonomy/src/contracts/Search/Query/Criterion/TaxonomyEntryId.php) searches for content based on the ID of the Taxonomy Entry it's assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Tag(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion;

$query = new Query();
$query->query = new Criterion\TaxonomyEntryId(1);
```

Add an array of ID's to find Content tagged with at least one of the tags (OR).

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion;

$query = new Query();
$query->query = new Criterion\TaxonomyEntryId([1, 2, 3]);
```
