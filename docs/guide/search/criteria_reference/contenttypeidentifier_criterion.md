# ContentTypeIdentifier Criterion

The [`ContentTypeIdentifier` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.php)
searches for content based on the identifier of its Content Type.

## Arguments

- `value` - string(s) representing the Content Type identifier(s).

## Example

``` php
$query->query = new Criterion\ContentTypeIdentifier(['article', 'blog_post']);
```
