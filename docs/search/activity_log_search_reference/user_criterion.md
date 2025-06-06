# User Criterion

The `UserCriterion` Activity Log Criterion matches log groups that have an activity by one of the users given by their IDs.

## Argument

- `ids` - list of user IDs

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\UserCriterion([10, 14]),
]);
```
