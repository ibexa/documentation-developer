# IsFieldEmpty Criterion

The [`IsFieldEmpty` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-IsFieldEmpty.html)
searches for content based on whether a specified Field is empty or not.

## Arguments

- `fieldDefinitionIdentifier` - string representing the identifier of the Field
- (optional) `value` - bool representing whether to search for empty (default `true`),
or non-empty Fields (`false`)

## Limitations

The `IsFieldEmpty` Criterion is not available in [Repository filtering](search_api.md#repository-filtering).

The Richtext Field Type (`ezrichtext`) is not searchable in the Legacy search engine.

## Example

### PHP

``` php
$query->query = new Criterion\IsFieldEmpty('title');
```

## Use case

You can use the `IsFieldEmpty` Criterion to search for articles that do not have an image:

``` php hl_lines="4"
$query = new LocationQuery;
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\IsFieldEmpty('image'),
    ]
);
```
