# UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for sessions based on the date when they were updated.

## Arguments

- `value` - date to be matched, provided as a DateTimeInterface object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

```php
$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\UpdatedAt(
    new DateTime('2025-05-01 14:07:02'),
    'GTE'
);

$query = new SessionQuery($criteria);
```