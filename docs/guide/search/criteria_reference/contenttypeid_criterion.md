# ContentTypeId Criterion

The [`ContentTypeIdentifier` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/6.13.7/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeId.php)
searches for content based on the ID of its Content Type.

## Arguments

- `value` - int(s) representing the Content Type ID(s).

## Example

``` php
$query->query = new Criterion\ContentTypeId([44]);
```
