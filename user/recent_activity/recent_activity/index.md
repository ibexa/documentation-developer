# Recent activity log

Monitor recent activity logged actions.

Editions: Experience

Ibexa DXP logs various operations on the repository and in the application.

If you have **Setup / Administrate** and **Activity Log / Read** [permissions](../../permission_management/permission_system/index.md), you can review the most recent activity log in the back office, **Admin** -> **Recent activity**.

![Recent activity](https://doc.ibexa.co/projects/userguide/en/5.0/recent_activity/img/recent_activity.png "Recent activity")

By default, actions on the following items are displayed:

- [Content](../../content_management/content_items/index.md)
- [Location](../../content_management/content_organization/manage_locations_urls/index.md#content-locations)
- [Product](../../product_catalog/products/index.md)
- [Product variant](../../product_catalog/work_with_product_variants/index.md)
- [Site](../../website_organization/work_with_sites/index.md)

> **Note: Note**
>
> If your implementation requires that other actions are logged, see [custom log entry Developer Documentation](../../../developer/administration/recent_activity/recent_activity/index.md#add-custom-activity-log-entries).
>
> By default, log entries are kept for 30 days. This time can be modified through configuration. For more information, see [Developer Documentation](../../../developer/administration/recent_activity/recent_activity/index.md#configuration).

Log entries are grouped by date, then by logical bond (like web request, or migration file).

Each activity log entry shows:

- when the action was performed,
- who performed it (avatar, first name, last name),
- the action itself as a verb,
- and the item the action was performed on.

Depending on the system configuration, activity logs may also be shown:

- on the dashboard with the [Recent activity block](../../getting_started/dashboard/dashboard_block_reference/index.md#recent-activity-block)
- within the [user profile](../../getting_started/get_started/index.md#view-and-edit-user-profile)

## Filter activities

You can filter the activities to:

- follow the activity of selected users or user group,
- narrow the results to selected item types, or actions.

To do it, on the right side, in the **Filters** menu, choose selected filters, and click the **Apply** button. Click the **Clear** button to reset all the filters.

The following example shows, how to narrow the results by selecting **Action** and **Time** filters. With these settings, activity list displays only `Publish` actions from `Last week` time period.

![Published last week](https://doc.ibexa.co/projects/userguide/en/5.0/recent_activity/img/recent_activity_filters.png "Published last week filter set")
