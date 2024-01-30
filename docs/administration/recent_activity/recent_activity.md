---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

Recent activity log summaries last actions on the repository (whatever their origin, such as Back Office, REST, CLI or CRON).

To learn more about its interface usage and the actions logged by default, see [Recent activity in the User documentation]([[= user_doc =]]/recent_activity/recent_activity/).

## Configuration and cronjob

* The parameter `ibexa.site_access.config.<scope>.activity_log.pagination.activity_logs_limit` set the number of log items shown per page in the Back Office (default: 25 items per page). (A log item is a group of entries, or an entry without group.)
* The configuration `ibexa.repositories.<repository>.activity_log.truncate_after_days` set the number of days a log entry is kept before being deleted by the `ibexa:activity-log:truncate` command (default: 30 days).

For example, the following set 20 log groups per page for the `admin` SiteAccess, and 15 days of life to the log entries on the `default` repository:

```yaml
parameters:
    ibexa.site_access.config.admin.activity_log.pagination.activity_logs_limit: 20
ibexa:
    repositories:
        default:
            activity_log:
                truncate_after_days: 15
```

To automate a regular truncation, the command `ibexa:activity-log:truncate` must be added to a crontab.
To minimize the number of entries to delete, it is recommended to execute the command more than one time a day.

For every exact hour, the cronjob line is:
`0 * * * * cd [path-to-ibexa]; php bin/console ibexa:activity-log:truncate --quiet --env=prod`

## PHP API

The ActivityLogService PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log entries

TODO: Quick example of …\ActivityLog\Query passed to ActivityLogService(Interface)::find and loop through the returned ActivityList(Interface)

See [Activity Log Search Criteria reference](activity_log_search.md) to discover query possibilities.

### Adding custom Activity Log entries

Your custom features could write into the activity log.

TODO: Illustrate the use of ActivityLogService(Interface)::build & ActivityLogService(Interface)::save

## REST API

REST API can be used to browse activity logs, see in the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#monitoring-activity-log).
