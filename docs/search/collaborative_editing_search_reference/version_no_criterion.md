# VersionNo Criterion

The `VersionNo` Search Criterion searches for content sessions based on version number of content item.

## Arguments

- `value` - integer(s) representing version number(s)

## Example

```php
$criteria = new Ibexa\Share\Session\Query\Criterion\VersionNo(1);

OR

$criteria = new Ibexa\Share\Session\Query\Criterion\VersionNo([1, 2]);

$query = new SessionQuery($criteria);
```