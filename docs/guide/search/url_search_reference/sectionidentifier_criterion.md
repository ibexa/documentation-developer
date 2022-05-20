# SectionIdentifier Criterion

The [SectionIdentifier URL Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/Criterion/SectionIdentifier.php)
matches URLs related to the content placed in a specified section identifier.

## Arguments

- `sectionIdentifiers` - string(s) representing the identifiers of the Section(s)

## Example

```php
$query->filter = new Criterion\SectionIdentifier(['standard', 'media']);
```
