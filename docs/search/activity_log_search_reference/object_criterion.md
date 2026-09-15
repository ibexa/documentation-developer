# Object Criterion

The `object_class` Activity Log Criterion matches activity log groups that have a log entry
about the given class name, and optionally one of the given IDs.

## Arguments

- `class` - class of the object concerned by the searched log entries
- (optional) `ids` - list of object IDs

## Example

You can use this Criterion over the REST API, in the `criteria` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request:

``` json
{
    "ActivityLogGroupListInput": {
        "criteria": [
            {
                "type": "object_class",
                "class": "Ibexa\\Contracts\\Core\\Repository\\Values\\Content\\Content",
                "ids": [72, 73]
            }
        ]
    }
}
```
