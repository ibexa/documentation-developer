# ContentTypeIdentifier Criterion

The [`ContentTypeIdentifier` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/6.13.7/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.php)
searches for content based on the identifier of its Content Type.

## Arguments

- `value` - string(s) representing the Content Type identifier(s).

## Example

``` php
$query->query = new Criterion\ContentTypeIdentifier(['article', 'blog_post']);
```
