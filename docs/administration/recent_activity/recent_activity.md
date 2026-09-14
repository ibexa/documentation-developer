---
description: Log and monitor activity through UI, PHP API and REST API.
month_change: false
---

# Recent activity

Recent activity log displays last actions in the repository (whatever their origin is, for example, back office, REST).

![Recent activity](admin_panel_recent_activity.png)

To learn more about its back office usage and the actions logged by default, see [Recent activity in User Documentation]([[= user_doc =]]/recent_activity/recent_activity/).

## Permission and security

The [`activity_log/read`](policies.md#activity-log) policy gives a role the access to the **Admin** -> **Activity list**, the dashboard's **Recent activity** block, and the user profile's **Recent activity**.
It can be limited to "Only own logs" ([`ActivityLogOwner`](limitation_reference.md#activity-log-owner-limitation)).

The policy should be given to every roles having access to the back office, at least with the `ActivityLogOwner` owner limitation, to allow them to use the "Recent activity" block in the dashboard.
This policy is required to view [activity log in user profile]([[= user_doc =]]/getting_started/get_started/#view-and-edit-user-profile), if the user profile is enabled.

!!! caution

    Don't assign `activity_log/read` permission to the Anonymous role, even with the owner limitation, because this role is shared among all unauthenticated users.

## User privacy

!!! caution

    A username of the User who performs the action is logged.
    When acting through the web server, the User's IP address is also logged.
    Other access, such as console commands, doesn't log an IP.
    Your Data Protection Officer or GDPR representative should be aware of this, so they can ensure users are informed if needed, depending on your use case, jurisdiction, and company policy.

    For example, if a content edition feature, such as reader's comments, is available in the front office, the recent activity log records the front users' IPs.

## REST API

You can browse activity logs with REST API.
For more information, see the [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Activity-Log).
