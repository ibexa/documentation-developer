---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

TODO: Feature introduction and description, link to the user doc, …

## PHP API

The `ActivityLogService` PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log entries

You can search among the activity log entries using `ActivityLogService::find` by passing an `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query`.
This `Query`'s constructor has four arguments:

1. `$criteria`: an array of criterion from `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion` related as a logical AND.
2. `$sortClauses`: an array of `Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause`.
3. `$offset`: a zero-based index integer indicating at which entry to start, its default value is `0` (zero, nothing skipped).
4. `$limit`: an integer as the maximum returned entry count, default is 25.

```php
[[= include_file('code_samples/recent_activity/src/Command/MonitorRecentContentCreationCommand.php') =]]
```

See [Activity Log Search Criteria reference](activity_log_search.md) to discover query possibilities.

### Adding custom Activity Log entries

Your custom features could write into the activity log.

First, inject `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface` into your custom event subscriber, event listener, service, controller or whatever PHP class having to log an activity.

In the following example, an event subscriber is subscribing to an event dispatched by a custom feature. This event has the information needed by a log entry (see details after the example).

```php
[[= include_file('code_samples/recent_activity/src/EventSubscriber/MyFeatureEventSubscriber.php') =]]
```

`ActivityLogService::build` function returns an `Ibexa\Contracts\ActivityLog\Values\CreateActivityLogStruct` which can then be passed to `ActivityLogService::save`.

`ActivityLogService::build` has three arguments:

* `$className` is the FQCN of the object actually manipulated by the feature. For example `Ibexa\Contracts\Core\Repository\Values\Content\Content::class`
* `$id` is the ID or identifier of the manipulated object. For example, the Content ID cast to string.
* `$action` is the identifier of the performed object manipulation. For example, `create`, `update` or `delete`.

The returned `CreateActivityLogStruct` is, by default, related to the currently logged-in user.

If your object PHP class is not already covered, you'll have to set up a template to display its log entry.

TODO: FQCN=>identifier map

You can have a template

* specific to the identifier plus an action and placed in `templates/themes/admin/activity_log/ui/<identifier>/<action>.html.twig`
* just specific to the identifier and placed in `templates/themes/admin/activity_log/ui/<identifier>.html.twig`
* common to every className not having a mapped identifier at `templates/themes/admin/activity_log/ui/common.html.twig`

Your template can extend `@ibexadesign/activity_log/ui/default.html.twig` and just redefine the `activity_log_description_widget` for your objects.

Follow an example of common template working whatever the object class is. It is not very user-friendly but can be used at development time as a fallback for classes not yet mapped.

```twig
[[= include_file('code_samples/recent_activity/templates/themes/admin/activity_log/ui/common.html.twig') =]]
```

## REST API

REST API can be used to browse activity logs, see in the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#monitoring-activity-log).
