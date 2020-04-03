# LocationRemoteId Criterion

The [`LocationRemoteId` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LocationRemoteId.php)
searches for content based in the Location remote ID.

## Arguments

- `value` - string(s) representing the Location remote ID(s).

## Example

``` php
$query->query = new Criterion\LocationRemoteId(['4d1e5f216c0a7aaab7f005ffd4b6a8a8', 'b81ef3e62b514188bfddd2a80d447d34']);
```
