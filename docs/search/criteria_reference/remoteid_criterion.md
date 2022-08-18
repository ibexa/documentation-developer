# RemoteId Criterion

The [`RemoteId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/RemoteId.php)
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

``` php
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```
