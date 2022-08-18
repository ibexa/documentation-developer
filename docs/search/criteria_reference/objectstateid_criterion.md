# ObjectStateId Criterion

The [`ObjectStateId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ObjectStateId.php)
searches for content based on its Object State ID.

## Arguments

- `value` - int(s) representing the Object State ID(s)

## Example

``` php
$query->query = new Criterion\ObjectStateId([4, 5]);
```
