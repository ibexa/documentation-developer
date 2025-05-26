# ContentID Criterion

The `ContentID` Search Criterion searches for content sessions based on content item ID.

## Arguments

- `value` - integer(s) representing the content item id(s)

## Example

```php
$criteria = new Ibexa\Share\Session\Query\Criterion\ContentId(1);

OR

$criteria = new Ibexa\Share\Session\Query\Criterion\ContentId([1, 2]);

$query = new SessionQuery($criteria);
```