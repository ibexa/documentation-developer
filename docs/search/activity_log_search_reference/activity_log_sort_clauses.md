# Activity Log Search Sort Clauses reference

Activity Log Search Sort Clauses set the order of the activity log groups returned by activity log search.

You use them over the REST API, in the `sortClauses` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request.

- `logged_at` - sorts activity log groups by their date and time.
Takes an optional `direction` argument, either `ASC` or `DESC` (default).

## Example

``` json
{
    "ActivityLogGroupListInput": {
        "sortClauses": [
            {
                "type": "logged_at",
                "direction": "DESC"
            }
        ]
    }
}
```
