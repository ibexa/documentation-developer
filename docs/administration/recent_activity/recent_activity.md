---
description: Log and monitor activity through UI and REST API.
month_change: false
---

# Recent activity

Recent activity log displays last actions in the repository (whatever their origin is, for example, back office, REST).

![Recent activity](admin_panel_recent_activity.png)

To learn more about its back office usage and the actions logged by default, see [Recent activity in User Documentation]([[= user_doc =]]/recent_activity/recent_activity/).

## Permission and security

The [`activity_log/read`](policies.md#activity-log) policy gives a role the access to the **Administration** -> **Activity list**, the dashboard's **Recent activity** block, and the user profile's **Recent activity**.
It can be limited to "Only own logs" ([`ActivityLogOwner`](limitation_reference.md#activity-log-owner-limitation)).

The policy should be given to every roles having access to the back office, at least with the `ActivityLogOwner` owner limitation, to allow them to use the "Recent activity" block in the dashboard.
This policy is required to view [activity log in user profile]([[= user_doc =]]/getting_started/get_started/#view-and-edit-user-profile), if the user profile is enabled.

!!! caution

    Don't assign `activity_log/read` permission to the Anonymous role, even with the owner limitation, because this role is shared among all unauthenticated users.

## REST API

You can browse activity logs with REST API.
For more information, see the [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log).
