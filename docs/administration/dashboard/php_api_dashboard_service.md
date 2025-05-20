---
title: Dashboard service's PHP API
description: Use DashboardService to manage dashboards.
---

# DashboardService's PHP API

You can use `DashboardService`'s PHP API to manage custom dashboards.
To obtain this service, inject the `Ibexa\Contracts\Dashboard\DashboardServiceInterface`.

The service exposes two functions:

- `createCustomDashboardDraft(?Location $location = null): Content` - returns a new content item in draft state of `dashboard` content type.
  If no location is given, it creates a copy of the dashboard of the user currently logged in.
  If a location is given, it creates a copy with the given location.
  The default name of the customized dashboard is set as `My dashboard`.
  This new Content draft is located in the current user custom dashboard container.
- `createDashboard(DashboardCreateStruct $dashboardCreateStruct): Content` - publishes the given dashboard creation structure (`Ibexa\Contracts\Dashboard\Values\DashboardCreateStruct`) under `dashboard.predefined_container_remote_id`.

## Customize dashboard using DashboardService

The following example is a command deploying a custom dashboard to users of content groups.
Using the `admin` account, it loads the group members, logs each one in, creates a custom dashboard by copying a default one, and then publishes the draft version of customized dashboard.
First argument is the `Content ID` of the dashboard to copy.
Following arguments are the Content IDs of the user groups.

``` php hl_lines="63"
[[= include_file('code_samples/back_office/dashboard/src/Command/DashboardCommand.php') =]]
```

The following line runs the command with `74` as the model dashboard's Content ID, `13` the user group's Content ID, and on the SiteAccess `admin` to have the right `user_content_type_identifier` config:

```bash
php bin/console doc:dashboard 74 13 --siteaccess=admin
```
