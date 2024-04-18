# Object Name Criterion

The `ObjectNameCriterion` Activity Log Criterion
matches log groups that have a log entry with an object having a given string as name, or part of their name.

## Arguments

- `query` - string representing the object name
- `operator` - constant representing how to compare log names with the query
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
