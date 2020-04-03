# RemoteId Criterion

The [`RemoteId` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/RemoteId.php)
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

``` php
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```
