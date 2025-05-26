# LogicalOr Criterion

The `LogicalOr` Search Criterion matches combined by the logical operator.

## Example

```php
$criteria = Ibexa\Contracts\Collaboration\Session\Query\Criterion\LogicalOr( , 
    new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Id(1),
    new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Token('12345-12345-12345-12345')
);

$query = new SessionQuery($criteria);
```