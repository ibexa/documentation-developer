# FieldRelation Criterion

The [`FieldRelation` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-FieldRelation.html)
searches for content based on the content items it has Relations to.

## Arguments

- `target` - string representing the identifier of the Field containing Relations
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - array of ints representing the Relation content IDs to search for

Use of IN means the Relation needs to have one of the provided IDs, while CONTAINS implies it needs to have all provided IDs.

## Limitations

The `FieldRelation` Criterion is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

### PHP

``` php
$query->query = new Criterion\FieldRelation('relations', Criterion\Operator::CONTAINS, [55, 63]);
```
