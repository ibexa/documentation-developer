# IsUserBased Criterion

The [`IsUserBased` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/IsUserBased.php)
searches for content that plays the role of a User account.

!!! note

    In the default setup only the User Content Type is treated as User accounts.
    However, you can also [set other Content Types to be treated as such](../../configuration/config_repository.md#user-identifiers).

## Arguments

- (optional) `value` - bool representing whether to search for User-based (default `true`)
or non-User-based content

## Limitations

The `IsUserBased` Criterion is not available in Solr or Elastic search engines.

## Example

``` php
$query->query = new Criterion\IsUserBased();
```
