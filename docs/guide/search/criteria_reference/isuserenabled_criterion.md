# IsUserEnabled Criterion

The [`IsUserEnabled` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/IsUserEnabled.php)
searches for User accounts that are enabled or disabled.

## Arguments

- (optional) `value` - bool representing whether to search for enabled (default `true`)
or disabled User accounts.

## Limitations

The `IsUserEnabled` Criterion is not available in Solr or Elastic search engines.

## Example

``` php
$query->query = new Criterion\IsUserEnabled();
```
