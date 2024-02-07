---
title: Default dashboard configuration
description: Configure default dashboard.
---

# Configure default dashboard

You can configure default dashboard under the `ibexa.system.<scope>.admin_group` [configuration key](configuration.md#configuration-files).

Create `ibexa_dashboard.yaml` file in the `config/packages/` directory.
The following example configuration defines default dashboard:

``` yaml
ibexa:
    system:
        admin_group: 
            dashboard:
                container_remote_id: dashboard_container
                default_dashboard_remote_id: default_dashboard
                users_container_remote_id: user_dashboards
                predefined_container_remote_id: predefined_dashboards
                section_identifier: dashboard
                content_type_identifier: dashboard_landing_page
                container_content_type_identifier: folder 
```

Configuration can be set per [SiteAccess](multisite/multisite_configuration/#siteaccess-configuration)
or [SiteAccess group](multisite/multisite_configuration/#siteaccess-groups).

All the settings in the configuration are reflected in the Back Office.

## Container remote ID

Defines starting location container for all the dashboards, including customized and predifined ones.
You can see it in the Admin panel, **Dashboards** section, **Dashboards** folder in the Content Tree. In the **Technical details** tab it is defined as **Location remote ID**.

![Container remote ID](dashboard_container_remote_id.png)

## Default dashboard remote ID

Specifies default predefined dashboard. This is the dashboard that all the users see as a starting dashboard in the Back Office.
You can see it in the Admin panel, **Dashboards** section, **Default dashboard** folder inside of **Predefined dashboards** container in the Content Tree. 
In the **Technical details** tab it is defined as **Location remote ID**.

## Users container remote ID

Defines a container for users folders, which contain all customized dashboards.
You can see it in the Admin panel, **Dashboards** section, **User dashboards** folder inside of main **Dashboards** container in the Content Tree. 
In the **Technical details** tab it is defined as **Location remote ID**.

## Predefined container remote ID

Defines a container that contains all predefined dashboards created by Administrator.
You can see it in the Admin panel, **Dashboards** section, **Predefined dashboards** folder inside of main **Dashboards** container in the Content Tree. 
In the **Technical details** tab it is defined as **Location remote ID**.

## Section identifier

Specifies the name of the [Section](administration/content_organization/sections/).

## Content Type identifier

It is an identifier that represents dashboard Content Type.
You can find it in the Admin panel, **Dashboard Content Type** section, **View/Global properties** tab.

## Container Content Type identifier

Determines the Content Type identifier of the container for dashboards and let you create additional structure for the predefined dashboards.
By default all the dashboards containers are set as a folders.

![Container Content Type](dashboard_container_type.png)

