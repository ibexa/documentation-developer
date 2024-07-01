# SectionIdentifier Criterion

The [SectionIdentifier URL Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-SectionIdentifier.html)
matches URLs related to the content placed in a specified section identifier.

## Arguments

- `sectionIdentifiers` - string(s) representing the identifiers of the Section(s)

## Example

```php
$query->filter = new Criterion\SectionIdentifier(['standard', 'media']);
```
