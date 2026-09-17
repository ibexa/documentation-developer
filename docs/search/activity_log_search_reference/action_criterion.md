# Action Criterion

The `action` Activity Log Criterion matches activity log groups that have a log entry
with one of the given actions.

## Arguments

- `value` - list of action name strings, for example `create`, `publish`, or `delete`

## Example

You can use this Criterion over the REST API, in the `criteria` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request:

``` json
{
    "ActivityLogGroupListInput": {
        "criteria": [
            {
                "type": "action",
                "value": ["create", "publish"]
            }
        ]
    }
}
```
