# SectionIdentifier Criterion

The [`SectionIdentifier` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/SectionIdentifier.php)
searches for content based on the identifier of the Section it is assigned to.

## Arguments

- `value` - string(s) representing the identifiers of the Section(s)

## Example

``` php
$query->query = new Criterion\SectionIdentifier(['sports', 'news']);
```
