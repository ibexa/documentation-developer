# User Criterion

The [`UserCriterion` Activity Log Criterion](https://github.com/ibexa/activity-log/blob/main/src/contracts/Values/ActivityLog/Criterion/UserCriterion.php)
matches log groups having an activity by one of the users given by their IDs.

## Argument

- `ids` - List of user IDs

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\UserCriterion([10, 14]),
]);
```
