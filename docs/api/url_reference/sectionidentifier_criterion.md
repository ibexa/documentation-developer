# SectionIdentifier Criterion

The [SectionIdentifier URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/SectionIdentifier.php)
matches URLs related to the content placed in a specified section identifier.

## Arguments

- `sectionIdentifiers` - string(s) representing the identifiers of the Section(s)

## Example

```php
$query->filter = new Criterion\SectionIdentifier(['standard', 'media']);
```
