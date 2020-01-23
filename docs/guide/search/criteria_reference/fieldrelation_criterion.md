# FieldRelation Criterion

The [`FieldRelation` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FieldRelation.php)
searches for content based on the Content items it has Relations to.

## Arguments

- `target` - string representing the identifier of the Field containing Relations
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - int or array of Relation content IDs to search for

Use of IN means the Relation needs to have one of the provided IDs, while CONTAINS implies it needs to have all provided IDs.

## Example

``` php
$query->query = new Criterion\FieldRelation('relations', Criterion\Operator::CONTAINS, [55, 63]);
```
