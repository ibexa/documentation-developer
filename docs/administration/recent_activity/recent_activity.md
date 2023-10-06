---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

TODO: Feature introduction and description, link to the user doc, …

## PHP API

The ActivityLogService PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log entries

TODO: Quick example of …\ActivityLog\Query passed to ActivityLogService(Interface)::find and loop through the returned ActivityList(Interface)

See [Activity Log Search Criteria reference](activity_log_search.md) to discover query possibilities.

### Adding custom Activity Log entries

Your custom features could write into the activity log.

TODO: Illustrate the use of ActivityLogService(Interface)::build & ActivityLogService(Interface)::save

## REST API

REST API can be used to browse activity logs or write new entries.

See in the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#activity-log) routes starting with `/activity-log/`.
