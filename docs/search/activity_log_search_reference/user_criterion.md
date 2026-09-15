# User Criterion

The `user` Activity Log Criterion matches activity log groups that have an activity
by one of the users given by their IDs.

## Arguments

- `value` - list of user IDs

## Example

You can use this Criterion over the REST API, in the `criteria` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request:

``` json
{
    "ActivityLogGroupListInput": {
        "criteria": [
            {
                "type": "user",
                "value": [14]
            }
        ]
    }
}
```
