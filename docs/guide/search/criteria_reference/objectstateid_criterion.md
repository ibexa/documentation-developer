# ObjectStateId Criterion

The [`ObjectStateId` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ObjectStateId.php)
searches for content based on its Object State ID.

## Arguments

- `value` - int(s) representing the Object State ID(s)

## Example

``` php
$query->query = new Criterion\ObjectStateId([4, 5]);
```
