# Pattern Criterion

The [`Pattern` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/SectionId.php)
URLs that contain the pattern.

## Arguments

- `pattern` - string representing pattern that needs to be a part of URL

## Example

``` php
$query->query = new Criterion\Pattern('ez.no');
```