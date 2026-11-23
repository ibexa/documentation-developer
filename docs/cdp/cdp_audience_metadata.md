---
description: Audience metadata retrieved from Raptor is synced and persisted on the CMS side, and served through APIs.
edition: experience
month_change: true
---

# Audience metadata

For each [audience](cdp_guide.md#audience-builder) built in [[= product_name_cdp =]], [[= product_name =]] retrieves and stores the following metadata:

- number of profiles in the audience
- audience description
- audience tags
- last audience update timestamp

Audience metadata is synced from [[= product_name_cdp =]] and persisted on the [[= product_name =]] side.
It's exposed through APIs, rather than being fetched from [[= product_name_cdp =]] on every request.

This means that components, such as the [Targeting block](targeting_block.md), [audience preview](page_builder_guide.md#audience-preview), and the [Segments view](segments_admin_panel.md#segments-view), read metadata from [[= product_name =]] directly, instead of making a runtime request to [[= product_name_cdp =]].
This makes setting up targeting rules and browsing audiences faster.

Metadata refreshes automatically, without editors having to manually trigger an update.

To retrieve audience metadata through the API, use the `SegmentationService`, as described in [Segment API](segment_api.md#getting-segment-information).
