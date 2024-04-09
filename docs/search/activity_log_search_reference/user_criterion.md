# User Criterion

The `UserCriterion` Activity Log Criterion
matches log groups having an activity by one of the users given by their IDs.

## Argument

- `ids` - List of user IDs

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\UserCriterion([10, 14]),
]);
```
