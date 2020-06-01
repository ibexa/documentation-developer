# Pattern Criterion

The [`Pattern` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/SectionId.php)
matches URLs that contain the provided pattern.

## Arguments

- `pattern` - string representing the pattern that needs to be a part of the URL

## Example

``` php
$query->filter = new Criterion\Pattern('ibexa.co');
```
