---
description: You can use Audiences to display specific content to specific users.
edition: experience
month_change: true
---

# Audiences

You can use audiences to display specific content to specific [users](users.md).
For example, use the [Targeting block](targeting.md) in Page Builder to display different content to different audiences.
Audiences are organized into groups.
The API uses the technical terms segment and segment group for audiences and audience groups.

## Audiences view

To access the *Audiences* view, expand **Personalization** in the main menu and select **Audiences**.
The Personalization menu also includes **Overview**.

The *Audiences* view lists audiences in a searchable, sortable, and filterable table.

The table shows the following metadata:

- **Name** - the audience's name
- **Identifier** - the audience identifier
- **Authors and editors** - the users who created or modified the audience, with a **Created** or **Edited** timestamp
- **Action** - an icon for editing the audience

Raptor audiences also have a **Description** column containing tags that you can use for filtering.
Raptor audience metadata can also include the number of profiles and the last update timestamp.

Use the search bar to find an audience or audience group.
To filter by audience group, click the arrow next to **Group** to expand the filter and select groups.

If Raptor isn't connected, the banner next to the search bar displays "Connect Raptor to unlock its audience targeting."
The banner reflects whether a Raptor connection is configured in [[= product_name =]].

For more information on how Raptor audience metadata is retrieved and kept up to date, see [Audience metadata](cdp/cdp_audience_metadata.md).

You can assign users to audiences [through the API](segment_api.md#assigning-users).

## Create an audience group

In the *Audiences* view, click **Create** in the top-right corner and fill in the group's **Name** and **Identifier**.
To add audiences to the group, click **Add** next to *Audiences under this group* and fill in the **Name** and **Identifier** for each audience.
You can also use **Remove** to remove an audience from the list.
