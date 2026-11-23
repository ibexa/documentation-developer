---
description: You can use segments to display specific content to specific users.
edition: experience
month_change: true
---

# Segments

You can use segments to display specific content to specific [users](users.md).
They're used out of the box in the [Targeting block](targeting_block.md) in the page.

You can collect segments in segment groups:

![Segment groups](admin_panel_segment_groups.png)

Each segment group can contain segments that you can target content for.

![Segment](admin_panel_segment.png)

## Segments view

The segments view lists all segments within a segment group in a searchable, sortable, and filterable table.

The table shows the following metadata:

- **Name** - the audience's name
- **Identifier** - the unique audience identifier used, for example, in the [Targeting block](targeting_block.md)
- **Size** - the number of profiles currently in the audience
- **Last updated** - the timestamp of the most recent audience sync

Secondary metadata, such as the audience's description and tags, is available through contextual UI elements, for example tooltips or hover states.
Additional metadata may also be displayed when it's available from the source system.

All of this metadata is synced from your CDP and served from [[= product_name =]], so opening the Segments view doesn't trigger a live request per audience.
For more information on how metadata is retrieved and kept up to date, see [Audience metadata](cdp_audience_metadata.md).

You can assign users to segments [through the API](segment_api.md#assigning-users).
