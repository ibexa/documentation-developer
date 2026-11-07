# Action Criterion

The `ActionCriterion` Activity Log Criterion matches activity log group that has a log entry with one of the given actions.

## Argument

- `actions` - list of action name strings. A set of built-in names is available as `ActivityLogServiceInterface`'s `ACTION_` prefixed constants.

## Example

```php
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog as ActivityLog;

$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ActionCriterion([
        ActivityLogServiceInterface::ACTION_DELETE,
        ActivityLogServiceInterface::ACTION_TRASH,
    ]),
]);
```
