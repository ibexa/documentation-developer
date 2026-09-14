---
description: Customize dashboard.
edition: experience
---

# Customize dashboard

!!! note

     The Dashboard Builder is available only in the Experience edition.
     The dashboard from the Headless edition can be customized using [Twig Components](components.md).

You can customize the dashboard depending on your needs using Dashboard Builder.
Customized dashboard displays a set of widgets selected by the user.

!!! tip

     For detailed instruction on how to customize dashboards with the Dashboard Builder, see [User Documentation]([[= user_doc =]]/getting_started/dashboard/work_with_dashboard/#customize-dashboard).

## Manage permissions

To customize dashboard, you need to have `dashboard/customize` [policy](permission_overview.md).

By default, all the users belonging to the `Editors` user group, have `Dashboard`[role](roles_admin_panel.md) assigned, so they can edit, create, or delete dashboard.
If, by any reason, you want to narrow this permission, you can set up specific [limitations](limitations.md).

## Add custom layout

For new dashboard you need to choose layout which defines the available zones.
While opening Dashboard Builder, layout window appears - you can choose one from available layouts.

You can also add custom layout that then can be available in Dashboard Builder.

## Create custom blocks

Dashboard Builder provides set of ready-to-use blocks, for example, Common content, Quick actions, or [[= product_name =]] News.

For more information about available blocks, see [User Documentation]([[= user_doc =]]/getting_started/dashboard/dashboard_block_reference/).

In addition to existing blocks available in Dashboard Builder, you can also create custom blocks.

To do it, follow the instruction on how to [create custom page block](create_custom_page_block.md).
