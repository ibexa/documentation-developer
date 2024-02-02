---
title: Dashboard service's PHP API
description: You can use DashboardService to manage dashboards
---

# Dashboard service's PHP API 

You can use `DashboardService`'s PHP API to manage custom dashboards.
To obtain this service, inject the `Ibexa\Contracts\Dashboard\DashboardServiceInterface`.
The service exposes two functions:

- `createCustomDashboardDraft(?Location $location = null): Content`
  returns a new Content item in draft state of `dashboard` content type.
  If no location is given, it creates by copying the current user's active dashboard.
  If a location is given, it creates by copying the given location.
  This new Content draft is located in the current user custom dashboard container`.`
- `createDashboard(DashboardCreateStruct $dashboardCreateStruct): Content` publishes the given
  dashboard creation structure (`Ibexa\Contracts\Dashboard\Values\DashboardCreateStruct`)
  under `dashboard.predefined_container_remote_id`

The following example is a command deploying a custom dashboard to users of content groups.
It loads the users of the groups using `admin` account,
then it logs each user in,
sets a custom dashboard by copying a model into a draft,
and publishes this dashboard draft.
First argument is the Content ID of the dashboard to copy.
Following arguments are the User Group (Content) IDs.

``` php hl_lines="70"
[[= include_file('code_samples/back_office/dashboard/src/Command/DashboardCommand.php') =]]
```

```bash
php bin/console doc:dashboard 74 13 --siteaccess=admin
```
