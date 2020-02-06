# RemoteId Criterion

The [`RemoteId` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/RemoteId.php)
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

``` php
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```
