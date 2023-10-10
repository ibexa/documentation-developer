---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

Recent activity log summaries last actions on the database (whatever their origin, such as Back Office, REST, CLI or CRON).

The following activities are recorded by default:

* Create, update or delete (send to trash) a Content item
* Create, update or delete a [Product](products.md)
* Hide or show a [Location](locations.md#location-visibility) or [Content item]([[= user_doc =]]/content_management/content_organization/copy_move_hide_content/#hide-content)
* Create, update or delete a [Site Factory](site_factory.md) site

## Configuration

* `ibexa.site_access.config.<scope>.activity_log.pagination.activity_logs_limit`: Set the number of log entries per page shown in the Back Office
* TODO: Period kept (30 days)

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
