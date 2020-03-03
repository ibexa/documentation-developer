# SectionIdentifier Criterion

The [`SectionIdentifier` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/SectionIdentifier.php)
searches for content based on the identifier of the Section it is assigned to.

## Arguments

- `value` - int(s) representing the identifiers of the Section(s)

## Example

``` php
$query->query = new Criterion\SectionIdentifier(['sports', 'news']);
```
