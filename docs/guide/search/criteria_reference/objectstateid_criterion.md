# ObjectStateId Criterion

The [`ObjectStateId` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ObjectStateId.php)
searches for content based on its Object State ID.

## Arguments

- `value` - int(s) representing the Object State ID

## Example

``` php
$query->query = new Criterion\ObjectStateId([4, 5]);
```
