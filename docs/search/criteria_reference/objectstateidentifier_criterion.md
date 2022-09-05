# ObjectStateIdentifier Criterion

The [`ObjectStateIdentifier` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ObjectStateId.php)
searches for content based on its Object State identifier.

## Arguments

- `value` - string(s) representing the Object State identifier(s)
- (optional) `target` - string representing the Object State group

## Example

``` php
$query->query = new Criterion\ObjectStateIdentifier(['ready']);
```

``` php
$query->query = new Criterion\ObjectStateIdentifier(['not_locked'], 'ez_lock');
```
