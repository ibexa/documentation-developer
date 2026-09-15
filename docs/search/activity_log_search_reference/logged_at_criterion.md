# LoggedAt Criterion

The `logged_at` Activity Log Criterion matches activity log groups that have a log entry
created before, after, or at a given date and time.

## Arguments

- `value` - string that the `DateTime` constructor accepts, for example `2024-01-01 12:00:00` or `- 1 hour`
- (optional) `operator` - string that represents a comparison sign, `=` by default

| Comparison            | Value |
|-----------------------|-------|
| Equal                 | `=`   |
| Not equal             | `<>`  |
| Less than             | `<`   |
| Less than or equal    | `<=`  |
| Greater than          | `>`   |
| Greater than or equal | `>=`  |

## Example

You can use this Criterion over the REST API, in the `criteria` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request:

``` json
{
    "ActivityLogGroupListInput": {
        "criteria": [
            {
                "type": "logged_at",
                "value": "- 1 hour",
                "operator": ">="
            }
        ]
    }
}
```
