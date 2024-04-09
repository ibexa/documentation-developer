# LoggedAt Criterion

The `LoggedAtCriterion` Activity Log Criterion
matches activity log group having a log entry created before or after a given date time.

## Arguments

- `dateTime` - a [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) object, like [`DateTime`](https://www.php.net/manual/en/class.datetime.php).
- `comparison` - string representing a comparison sign. Available signs can be found as constant in the `LoggedAtCriterion` class itself.

| Comparison            | Value | Constant                 |
|-----------------------|-------|--------------------------|
| Equal                 | `=`   | `LoggedAtCriterion::EQ`  |
| Not equal             | `<>`  | `LoggedAtCriterion::NEQ` |
| Less than             | `<`   | `LoggedAtCriterion::LT`  |
| Less than or equal    | `<=`  | `LoggedAtCriterion::LTE` |
| Greater than          | `>`   | `LoggedAtCriterion::GT`  |
| Greater than or equal | `>=`  | `LoggedAtCriterion::GTE` |

## Example

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\LoggedAtCriterion(new \DateTime('- 1 day'), ActivityLog\Criterion\LoggedAtCriterion::GTE),
]);
```
