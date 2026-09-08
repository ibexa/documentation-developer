---
description: Log and monitor activity through UI, PHP API and REST API.
month_change: false
---

# Recent activity

Recent activity log displays last actions in the repository (whatever their origin is, for example, back office, REST, migration, CLI, or CRON).

![Recent activity](admin_panel_recent_activity.png)

To learn more about its back office usage and the actions logged by default, see [Recent activity in User Documentation]([[= user_doc =]]/recent_activity/recent_activity/).

## Configuration

With some configuration, you can customize the log length in the database or on screen, or disable the logging completely.
A command maintains the log size in database, it should be scheduled through CRON.

### Log retention

The `ibexa.repositories.<repository>.activity_log.truncate_after_days` setting sets the number of days a log entry is kept before it's deleted by the `ibexa:activity-log:truncate` command (default value: 30 days).

For example, the following configuration sets 15 days of life to the log entries on the `default` repository:

```yaml
ibexa:
    repositories:
        default:
            activity_log:
                truncate_after_days: 15
```

To automate a regular truncation, you must schedule the command `ibexa:activity-log:truncate`.
To minimize the number of entries to delete, it's recommended that you execute the command more than one time a day.

### Display limit

The `ibexa.system.<scope>.activity_log.pagination.activity_logs_limit` setting sets the number of log items shown per page in the back office (default value: 25).

For example, the following configuration sets 20 context groups per page for the `admin_group` SiteAccess group:

```yaml
ibexa:
    system:
        admin_group:
            activity_log:
                pagination:
                    activity_logs_limit: 20
```

A log item is a group of entries, or an entry without group.

### Disable activity log

The `ibexa.repositories.<repository>.activity_log.enabled` setting can disable activity log entirely for a given repository.

For example, to disable the activity log for the `default` repository:

```yaml
ibexa:
    repositories:
        default:
            activity_log:
                enabled: false
```

## Permission and security

The [`activity_log/read`](policies.md#activity-log) policy gives a role the access to the **Admin** -> **Activity list**, the dashboard's **Recent activity** block, and the user profile's **Recent activity**.
It can be limited to "Only own logs" ([`ActivityLogOwner`](limitation_reference.md#activity-log-owner-limitation)).

The policy should be given to every roles having access to the back office, at least with the `ActivityLogOwner` owner limitation, to allow them to use the "Recent activity" block in the [default dashboard](configure_default_dashboard.md).
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
