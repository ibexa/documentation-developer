# ContentTypeId Criterion

The [`ContentTypeId` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeId.php)
searches for content based on the ID of its Content Type.

## Arguments

- `value` - int(s) representing the Content Type ID(s).

## Example

``` php
$query->query = new Criterion\ContentTypeId([44]);
```
