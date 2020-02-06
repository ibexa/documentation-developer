# RemoteId Criterion

The [`RemoteId` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/6.13.7/eZ/Publish/API/Repository/Values/Content/Query/Criterion/RemoteId.php)
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

``` php
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```
