---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

Recent activity log summaries last actions on the repository (whatever their origin, such as Back Office, REST, migration, CLI, or CRON).

To learn more about its Back Office usage and the actions logged by default, see [Recent activity in the User documentation]([[= user_doc =]]/recent_activity/recent_activity/).

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
To minimize the number of entries to delete, it's recommended to execute the command more than one time a day.

For every exact hour, the cronjob line is:
`0 * * * * cd [path-to-ibexa]; php bin/console ibexa:activity-log:truncate --quiet --env=prod`

## Permission and security

The "Activity Log / Read" policy ([`activity_log/read`](policies.md#activity-log)) gives a role the access to
the "Admin > Activity list", the dashboard's "Recent activity" block, and the user profile's "Recent activity".
It can be limited to "Only own log".

The "Activity Log / Read" policy should be given to every roles having access to the Back Office,
at least with the "Only own log" owner limitation,
to allow them to use the "Recent activity" block in the default dashboard or their custom dashboard.
This policy is also required by user having a profile to properly view their own.

!!! caution

    Never give `activity_log/read` permission to Anonymous role, even with the owner limitation,
    as this role is shared among all unauthenticated users.

## PHP API

The `ActivityLogService` PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log groups

You can search among the activity log entry groups using `ActivityLogService::findGroups` by passing an `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query`.
This `Query`'s constructor has four arguments:

1. `$criteria`: an array of criterion from `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion` related as a logical AND.
2. `$sortClauses`: an array of `Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause`.
3. `$offset`: a zero-based index integer indicating at which group to start, its default value is `0` (zero, nothing skipped).
4. `$limit`: an integer as the maximum returned group count, default is 25.

See [Activity Log Search Criteria reference](activity_log_criteria.md) and [Activity Log Search Sort Clauses reference](activity_log_sort_clauses.md) to discover query possibilities.

In the following example, log groups containing at least one creation of a Content item will be displayed in terminal, with a maximum of 10 groups within the last hour.
This uses the default `admin` user to have the [permission](#permission-and-security) to list everyone entries.

```php hl_lines="36-40"
[[= include_file('code_samples/recent_activity/src/Command/MonitorRecentContentCreationCommand.php') =]]
```

```console
% php bin/console app:monitor-content-creation

web
---

 --------------------------- --------- ------------- -------- ---------- 
  Logged at                   Obj. ID   Object Name   Action   User      
 --------------------------- --------- ------------- -------- ---------- 
  2024-01-29T15:01:57+00:00   323       Folder        create   jane_doe  
 --------------------------- --------- ------------- -------- ---------- 

migration
---------

 Migrating file: create_foo_company
 --------------------------- --------- ------------------- -------------- ------- 
  Logged at                   Obj. ID   Object Name         Action         User   
 --------------------------- --------- ------------------- -------------- ------- 
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    create         admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    publish        admin  
  2024-01-29T14:58:53+00:00   318       Members             create         admin  
  2024-01-29T14:58:53+00:00   318       Members             publish        admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    create_draft   admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    update         admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    publish        admin  
  2024-01-29T14:58:53+00:00   319       Address Book        create         admin  
  2024-01-29T14:58:53+00:00   319       Address Book        publish        admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    create_draft   admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    update         admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    publish        admin  
  2024-01-29T14:58:53+00:00   320       HQ                  create         admin  
  2024-01-29T14:58:53+00:00   320       HQ                  publish        admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    create_draft   admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    update         admin  
  2024-01-29T14:58:53+00:00   317       Foo Company Ltd.    publish        admin 
 --------------------------- --------- ------------------- -------------- ------- 
```

### Adding custom Activity Log entries

!!! caution

    Keep activity logging as light as possible. Do not make database request or heavy computation at logging time. Keep them for activity log list display time.

#### Entry

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

#### Context group

If you log several entries at once, you can group them into a context. A context group counts as one item in regard to `activity_logs_limit` configuration and `ActivityLogService::find`'s `$limit` argument.
In the following example, several actions are logged into one context group, even actions triggered by cascade outside the piece of code:

- `my_feature`
    - `init`
    - `create`
    - `publish`
    - `simulate`
    - `complete`

```php
$this->activityLogService->prepareContext('my_feature', 'Operation description');

$this->activityLogService->save($this->activityLogService->build(MyFeature::class, $id, 'init'));

$contentCreateStruct = $this->contentService->newContentCreateStruct(
    $this->repository->getContentTypeService()->loadContentTypeByIdentifier('folder'),
    'eng-GB'
);
$contentCreateStruct->setField('name', "My Feature Folder #$id", 'eng-GB');
$locationCreateStruct = new LocationCreateStruct(['parentLocationId' => 2]);
$draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);
$this->contentService->publishVersion($draft->versionInfo);

$event = new MyFeatureEvent(new MyFeature(['id' => $id, 'name' => "My Feature #$id"]), 'simulate');
$this->eventDispatcher->dispatch($event);

$this->activityLogService->save($this->activityLogService->build(MyFeature::class, $id, 'complete'));

$this->activityLogService->dismissContext();
```

TODO: Groups can't be nested. If a new context group is prepared while a context is already grouping log entries, this new context group will be ignored. To start a new context group, make sure to dismiss the existing one.

#### List

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
