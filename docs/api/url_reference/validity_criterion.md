# Validity Criterion

The [Validity URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/Validity.php) matches URLs based on a validity flag.

## Arguments

- `isValid` - bool representing whether the matcher selects only valid URLs

## Example

```php
$query->filter = new Criterion\Validity(true);
```
