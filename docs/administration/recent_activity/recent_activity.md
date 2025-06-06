---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Recent activity log displays last actions in the repository (whatever their origin is, for example, back office, REST, migration, CLI, or CRON).

![Recent activity](admin_panel_recent_activity.png)

To learn more about its back office usage and the actions logged by default, see [Recent activity in User Documentation]([[= user_doc =]]/recent_activity/recent_activity/).

## Configuration and cronjob

With some configuration, you can customize the log length in the database or on screen.
A command maintains the log size in database, it should be scheduled through CRON.

- The configuration `ibexa.system.<scope>.activity_log.pagination.activity_logs_limit` sets the number of log items shown per page in the back office (default value: 25).
A log item is a group of entries, or an entry without group.
- The configuration `ibexa.repositories.<repository>.activity_log.truncate_after_days` sets the number of days a log entry is kept before it's deleted by the `ibexa:activity-log:truncate` command (default value: 30 days).

For example, the following configuration sets 15 days of life to the log entries on the `default` repository, and 20 context groups per page for the `admin_group` SiteAccess group:

```yaml
ibexa:
    repositories:
        default:
            activity_log:
                truncate_after_days: 15
    system:
        admin_group:
            activity_log:
                pagination:
                    activity_logs_limit: 20
```

To automate a regular truncation, the command `ibexa:activity-log:truncate` must be added to a crontab.
To minimize the number of entries to delete, it's recommended to execute the command more than one time a day.

For every exact hour, the cronjob line is:
`0 * * * * cd [path-to-ibexa]; php bin/console ibexa:activity-log:truncate --quiet --env=prod`

## Permission and security

The [`activity_log/read`](policies.md#activity-log) policy gives a role the access to the **Admin** -> **Activity list**, the dashboard's **Recent activity** block, and the user profile's **Recent activity**.
It can be limited to "Only own logs" ([`ActivityLogOwner`](limitation_reference.md#activitylogowner-limitation)).

The policy should be given to every roles having access to the back office, at least with the `ActivityLogOwner` owner limitation, to allow them to use the "Recent activity" block in the [default dashboard](configure_default_dashboard.md) or their [custom dashboard](customize_dashboard.md).
This policy is required to view [activity log in user profile]([[= user_doc =]]/getting_started/get_started/#view-and-edit-user-profile), if [profile is enabled](update_from_4.5.md#user-profile).

!!! caution

    Don't assign `activity_log/read` permission to the Anonymous role, even with the owner limitation, because this role is shared among all unauthenticated users.

## User privacy

!!! caution

    A username of the User who performs the action is logged.
    When acting through the web server, the User's IP address is also logged.
    Other access, such as console commands, doesn't log an IP.
    Your Data Protection Officer or GDPR representative should be aware of this, so they can ensure users are informed if needed, depending on your use case, jurisdiction, and company policy.

    For example, if a content edition feature, such as reader's comments, is available in the front office, the recent activity log records the front users' IPs.

## PHP API

The `ActivityLogService` PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log groups

You can search among the activity log entry groups with the `ActivityLogService::findGroups` method, by passing an `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query` object.
This `Query`'s constructor has four arguments:

- `$criteria` - an array of criteria from `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion` combined as a logical AND.
- `$sortClauses` - an array of `Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause`.
- `$offset` - a zero-based index integer indicating at which group to start, its default value is `0` (zero, nothing skipped).
- `$limit` - an integer as the maximum returned group count, default is 25.

See [Activity Log Search Criteria reference](activity_log_criteria.md) and [Activity Log Search Sort Clauses reference](activity_log_sort_clauses.md) to discover query possibilities.

In the following example, log groups that contain at least one creation of a Content item are displayed in terminal, with a maximum of 10 groups within the last hour.
It uses the default `admin` user that has a [permission](#permission-and-security) to list everyone's entries.

```php hl_lines="39-43"
[[= include_file('code_samples/recent_activity/src/Command/MonitorRecentContentCreationCommand.php') =]]
```

```console
% php bin/console app:monitor-content-creation

web
---

 --------------------------- --------- --------------------------- -------- ---------- ------------
  Logged at                   Obj. ID   Object Name                 Action   User       IP
 --------------------------- --------- --------------------------- -------- ---------- ------------
  2024-01-29T15:01:57+00:00   323       “Bar” (formerly “Folder”)   create   jane_doe   172.20.0.5
 --------------------------- --------- --------------------------- -------- ---------- ------------

migration
---------

 Migrating file: create_foo_company
 --------------------------- --------- -------------------- -------------- ------- ----
  Logged at                   Obj. ID   Object Name          Action         User    IP
 --------------------------- --------- -------------------- -------------- ------- ----
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   create         admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   publish        admin
  2024-01-29T14:58:53+00:00   318       “Members“            create         admin
  2024-01-29T14:58:53+00:00   318       “Members“            publish        admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   create_draft   admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   update         admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   publish        admin
  2024-01-29T14:58:53+00:00   319       “Address Book“       create         admin
  2024-01-29T14:58:53+00:00   319       “Address Book“       publish        admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   create_draft   admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   update         admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   publish        admin
  2024-01-29T14:58:53+00:00   320       “HQ“                 create         admin
  2024-01-29T14:58:53+00:00   320       “HQ“                 publish        admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   create_draft   admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   update         admin
  2024-01-29T14:58:53+00:00   317       “Foo Company Ltd.“   publish        admin
 --------------------------- --------- -------------------- -------------- ------- ----
```

### Add custom Activity Log entries

!!! caution

    Keep activity logging as light as possible.
    Don't make database requests or heavy computation at logging time.
    Keep them for activity log list display time.

#### Create an entry

Your custom features can write into the activity log.

First, inject `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface` into your PHP class from where you want to log an activity (such as a custom event subscriber, event listener, service, or controller).

In the following example, an event subscriber is subscribing to an event dispatched by a custom feature.
This event has the information needed by a log entry (see details after the example).

```php
[[= include_file('code_samples/recent_activity/src/EventSubscriber/MyFeatureEventSubscriber.php') =]]
```

`ActivityLogService::build()` function returns an `Ibexa\Contracts\ActivityLog\Values\CreateActivityLogStruct` which can then be passed to `ActivityLogService::save`.

`ActivityLogService::build` has three arguments:

- `$className` is a FQCN of the object actually manipulated by the feature, for example `Ibexa\Contracts\Core\Repository\Values\Content\Content::class`
- `$id` is an ID or identifier of the manipulated object, for example, the Content ID cast to string
- `$action` is an identifier of the performed object manipulation, or example, `create`, `update` or `delete`

The returned `CreateActivityLogStruct` is always related to the currently logged-in user.

You can still display activity log of an object which was deleted or renamed.
To store the name of the log, you need to use `CreateActivityLogStruct::setName` before saving the log entry.
This stored name can be used at the time of displaying information whether the associated object isn't available anymore, or to check if it has been renamed.

#### Context group

If you log several related entries at once, you can group them into a context.
Context is a set of actions done for the same purpose, for example, it could group the actions of a CRON that fetches third party data and updates content items.
The built-in contexts include:

- `web` - groups actions made in the back office, like the update and the publishing of a new content item's version
- `migration` - groups every action from a migration file execution

A context group counts as one item in regard to `activity_logs_limit` configuration and `ActivityLogService::findGroups`'s `$limit` argument.

To open a context group, use `ActivityLogService::prepareContext` which has two arguments:

- `$source` - describes, usually through a short identifier, what is triggering the set of actions.
For example, some already existing sources are `web` (incl. actions from the back office), `graphql`, `rest` and `migration`
- `$description` - an optional, more specific contextualisation.
For example, `migration` context source is associated with the migration file name in its context description.

To close a context group, use `ActivityLogService::dismissContext`.

In the following example, several actions are logged into one context group, even those triggered by a cascade outside the piece of code:

- `my_feature`
    - `init`
    - `create`
    - `publish`
    - `simulate`
    - `complete`

``` php
[[= include_file('code_samples/recent_activity/src/Command/ActivityLogContextTestCommand.php', 62, 82) =]]
```

Context groups can't be nested.
If a new context is prepared when a context is already grouping log entries, this new context is ignored.
To start a new context, make sure to previously dismiss the existing one.

When displayed in the back office, a context group is folded below its first entry.
The `my_feature` context from the example is folded below its first action, the `init` action.
Other actions are displayed after you click the **Show more** button.

![The example context group displayed on the Recent Activity page](activity_log_group.png "`my_feature` context from the example")

#### Display log entries

To display your log entry, if your object's PHP class isn't already covered, you have to:

- implement `ClassNameMapperInterface` to associate the class name with an identifier,
- eventually create a `PostActivityListLoadEvent` subscriber if you need to load the object for the template,
- create a template to display this class log entries.

You can have a template that is:

- specific to a class identifier and placed in `templates/themes/<theme>/activity_log/ui/<identifier>.html.twig`
- specific to an action on an identifier and placed in `templates/themes/<theme>/activity_log/ui/<identifier>/<action>.html.twig`

Template existence is tested in reverse order: if there is no action that specifies the template, the identifier's default is used.
For the same identifier, you could have specific templates for few actions, and a default one for the remaining actions.

A default template is used if no template is found for the identifier.
The built-in default template `@ibexadesign/activity_log/ui/default.html.twig` has an empty `activity_log_description_widget` block and doesn't display anything for unknown objects.
Your template can extend `@ibexadesign/activity_log/ui/default.html.twig`, and only redefine the `activity_log_description_widget` block for your objects.

First, follow an example of a default template overriding the one from the bundle.
It can be used during development as a fallback for classes that aren't mapped yet.

``` twig
[[= include_file('code_samples/recent_activity/templates/themes/admin/activity_log/ui/default.html.twig') =]]
```

Here is an example of a `ClassNameMapperInterface` associating the class `App\MyFeature\MyFeature` with the identifier `my_feature`:

``` php
[[= include_file('code_samples/recent_activity/src/ActivityLog/ClassNameMapper/MyFeatureNameMapper.php') =]]
```

This mapper also provides a translation for the class name in the **Filters** menu.
This translation can be extracted with `php bin/console translation:extract en --domain=ibexa_activity_log --dir=src --output-dir=translations`.

To be taken into account, this mapper must be registered as a service:

``` yaml
[[= include_file('code_samples/recent_activity/config/append_to_services.yaml') =]]
```

Here is an example of a `PostActivityListLoadEvent` subscriber which loads the related object when it's an `App\MyFeature\MyFeature`, and attaches it to the log entry:

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

You can browse activity logs with REST API.
For more information, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#monitoring-activity).
