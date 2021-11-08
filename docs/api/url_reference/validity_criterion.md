# Validity Criterion

The [Validity URL Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/Criterion/Validity.php) matches URLs based on a validity flag.

## Arguments

- `isValid` - bool representing whether the matcher selects only valid URLs

## Example

```php
$query->filter = new Criterion\Validity(true);
```
