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
  If no location is given, the draft is created by copying the current user's active dashboard.
  If a location is given, the draft is created by copying the given location.
  This new Content is located in the user_dashboards
- `createDashboard(DashboardCreateStruct $dashboardCreateStruct): Content` publishes the given
  dashboard creation structure (`Ibexa\Contracts\Dashboard\Values\DashboardCreateStruct`)
  under `dashboard.predefined_container_remote_id`
