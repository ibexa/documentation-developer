# Object Name Criterion

The [`ObjectNameCriterion` Activity Log Criterion](https://github.com/ibexa/activity-log/blob/main/src/contracts/Values/ActivityLog/Criterion/ObjectNameCriterion.php)
matches log groups having a log entry with an object having a given string as name, or part of their name.

## Arguments

- `query` - The string searched for.
- `operator` - How to compare the string to the log entry object names.
  - `ObjectNameCriterion::OPERATOR_CONTAINS`
  - `ObjectNameCriterion::OPERATOR_STARTS_WITH`
  - `ObjectNameCriterion::OPERATOR_ENDS_WITH`
  - `ObjectNameCriterion::OPERATOR_EQUALS`

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ObjectNameCriterion('Ibexa', ActivityLog\Criterion\ObjectNameCriterion::OPERATOR_CONTAINS),
]);
```
