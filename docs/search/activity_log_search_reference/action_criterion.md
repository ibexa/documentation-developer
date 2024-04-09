# Action Criterion

The `ActionCriterion` Activity Log Criterion
matches activity log group having a log entry with one of the given actions.

## Argument

- `actions` - list of action name strings.

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ActionCriterion([
        ActivityLog\ActivityLogServiceInterface::ACTION_DELETE,
        ActivityLog\ActivityLogServiceInterface::ACTION_TRASH,
    ]),
]);
```
