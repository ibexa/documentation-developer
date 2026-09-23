---
description: Activity Log Search Criteria
page_type: reference
---

# Activity Log Search Criteria reference

Activity Log Search Criteria filter the activity log groups returned by activity log search.

You use them over the REST API, in the `criteria` element of the payload of the
[`POST /activity-log-group/list`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log/operation/ibexa.activity_log.rest.activity_log_group.list.post) request.
Each criterion is an object with a `type` property that selects the criterion, and its own arguments.

Criteria are applied to log entry groups.
For example, with the `action` criterion, you get log entry groups that have at least one entry
with this action (and possibly other actions as well).

For more information about the activity log itself, see [Recent activity](../../administration/admin_panel/recent_activity_admin_panel.md).

## Value-based criteria

| Search Criterion                                  | Search based on                                             |
|---------------------------------------------------|-------------------------------------------------------------|
| [`action`](action_criterion.md)                   | Performed action name(s)                                    |
| [`logged_at`](logged_at_criterion.md)             | Before, after or at a given date and time                   |
| [`object_class`](object_criterion.md)             | Manipulated object's class name, and optionally objects' IDs |
| [`user`](user_criterion.md)                       | User performing the action                                  |

## Logical criteria

| Search Criterion | Description                                                                        |
|------------------|------------------------------------------------------------------------------------|
| `not`            | Logical NOT criterion that matches if the provided criteria don't match.            |
| `and`            | Logical AND criterion that matches if all the provided criteria match.              |
| `or`             | Logical OR criterion that matches if at least one of the provided criteria matches. |

Logical criteria take a `criteria` element with the criteria to combine:

``` json
{
    "ActivityLogGroupListInput": {
        "criteria": [
            {
                "type": "or",
                "criteria": [
                    { "type": "action", "value": ["create"] },
                    { "type": "action", "value": ["publish"] }
                ]
            }
        ]
    }
}
```
