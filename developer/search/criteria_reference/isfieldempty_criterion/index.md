# IsFieldEmpty Criterion

IsFieldEmpty Search Criterion

The [`IsFieldEmpty` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/IsFieldEmpty.php) searches for content based on whether a specified field is empty or not.

## Arguments

- `fieldDefinitionIdentifier` - string representing the identifier of the field
- (optional) `value` - bool representing whether to search for empty (default `true`), or non-empty fields (`false`)

## Limitations

The `IsFieldEmpty` Criterion isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

The Richtext field type (`ibexa_richtext`) isn't searchable in the Legacy search engine.

The `IsFieldEmpty` criterion doesn't work for [Taxonomy entry assignment](../../../content_management/field_types/field_type_reference/taxonomyentryassignmentfield/index.md) fields. For this use case, use [`TaxonomyNoEntries`](../taxonomy_no_entries/index.md) instead.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\IsFieldEmpty('title');
```

## Use case

You can use the `IsFieldEmpty` Criterion to search for articles that don't have an image:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd(
    [
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\IsFieldEmpty('image'),
    ]
);
```
