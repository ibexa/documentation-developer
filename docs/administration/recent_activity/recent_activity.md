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

First, inject `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface` into your PHP class having to log an activity (such as a custom event subscriber, event listener, service, or controller).

In the following example, an event subscriber is subscribing to an event dispatched by a custom feature. This event has the information needed by a log entry (see details after the example).

```php
[[= include_file('code_samples/recent_activity/src/EventSubscriber/MyFeatureEventSubscriber.php') =]]
```

`ActivityLogService::build` function returns an `Ibexa\Contracts\ActivityLog\Values\CreateActivityLogStruct` which can then be passed to `ActivityLogService::save`.

`ActivityLogService::build` has three arguments:

* `$className` is the FQCN of the object actually manipulated by the feature. For example `Ibexa\Contracts\Core\Repository\Values\Content\Content::class`
* `$id` is the ID or identifier of the manipulated object. For example, the Content ID cast to string.
* `$action` is the identifier of the performed object manipulation. For example, `create`, `update` or `delete`.

The returned `CreateActivityLogStruct` is always related to the currently logged-in user.

If the object you log an activity on can become unavailable (like after a `delete` action), you might want to also log the name the object has at log time to be able to display it even when the object becomes unavailable. To add this name, use `CreateActivityLogStruct::setName` before saving the log entry.

!!! caution

    Keep activity logging as light as possible. Do not make database request or heavy computation at logging time. Keep them for activity log list display time.

To display your log entry, if your object's PHP class isn't already covered, you'll have to:

* implement `ClassNameMapperInterface` to associate the class name with an identifier,
* eventually create a `PostActivityListLoadEvent` subscriber if you need to load the object for the template,
* create a template to display this class log entries.

You can have a template:

* specific to an action on an identifier and placed in `templates/themes/<theme>/activity_log/ui/<identifier>/<action>.html.twig`
* specific to an identifier and placed in `templates/themes/<theme>/activity_log/ui/<identifier>.html.twig`

Template existence is tested in this order. For the same identifier, you could have one template for several actions and some templates for other actions.

Your template can extend `@ibexadesign/activity_log/ui/default.html.twig` and only redefine the `activity_log_description_widget` block for your objects. This default template is itself used if no template is found for the identifier and the action, or the identifier alone. The built-in default template has an empty `activity_log_description_widget` block and display nothing for unknown objects.

First, follows an example of a default template overriding the one from the bundle. It can be used at development time as a fallback for classes not yet mapped.

``` twig
[[= include_file('code_samples/recent_activity/templates/themes/admin/activity_log/ui/default.html.twig') =]]
```

Here is an example of a `ClassNameMapperInterface` associating the class `App\MyFeature\MyFeature` with the identifier `my_feature`:

``` php
[[= include_file('code_samples/recent_activity/src/ActivityLog/ClassNameMapper/MyFeatureNameMapper.php') =]]
```

This mapper is also providing a translation for the class name in the Filters menu. This translation can be extracted with `php bin/console translation:extract en --domain=ibexa_activity_log --dir=src --output-dir=translations`.

To be taken into account, this mapper must be registered as a service:

``` yaml
[[= include_file('code_samples/recent_activity/config/append_to_services.yaml') =]]
```

Here is an example of a `PostActivityListLoadEvent` subscriber which load the related object when it's a `App\MyFeature\MyFeature`, and attach it to the log entry:

``` php
[[= include_file('code_samples/recent_activity/src/EventSubscriber/MyFeaturePostActivityListLoadEventSubscriber.php') =]]
```

The following template is made to display the object of `App\MyFeature\MyFeature` (now identified as `my_feature`) when the action is `simulate`,
so, it's named in `templates/themes/admin/activity_log/ui/my_feature/simulate.html.twig`.
Thanks to the previous subscriber, the related object is available at display time:

``` twig
[[= include_file('code_samples/recent_activity/templates/themes/admin/activity_log/ui/my_feature/simulate.html.twig') =]]
```

## REST API

REST API can be used to browse activity logs, see in the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#monitoring-activity-log).
