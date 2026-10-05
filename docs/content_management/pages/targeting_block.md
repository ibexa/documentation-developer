---
description: Targeting block provides recommendation of content based on users related to the configured segments.
edition: experience
month_change: true
---

# Targeting block

The Targeting block is a [Page Builder](page_builder_guide.md) block that displays a content variation based on the [audiences](cdp_audience_metadata.md) a visitor belongs to.
While configuring the block, you can see each audience's size, timestamp, and tags inline.

## Multi-audience configuration

The Targeting block lets you assign multiple audiences to a single content item in one configuration pass.

Each variation in the block is configured with:

- one or more audiences
- the content item to display when a visitor matches

The system uses audiences in the order set by the editor.
If a visitor belongs to multiple audiences, the first matching audience determines the displayed variation.

The same audience can be assigned to more than one variation.
If the same audience appears in multiple variations, visitors see the variation that comes first in the list.
To avoid audience overlaps, audiences already assigned to another variation are disabled and cannot be selected again.

## Permissions

Audience evaluation takes content permissions into account.
The system checks if the visitor can access the content for each audience.

If a visitor belongs to multiple audiences:

- the system checks audiences in the configured order
- the system checks the next matching audience if the visitor cannot access the content for the first one
- the system stops when it finds content the visitor can access

If a visitor belongs to only one audience and cannot access the associated content, the system shows the [fallback content](targeting_block.md#fallback-content).

## Fallback content

Fallback content is rendered:

- if a visitor belongs to only one audience and the associated content is not accessible
- whenever no accessible content variation can be displayed across all audiences the visitor belongs to
- the visitor doesn't belong to any of the configured audiences

You can find the fallback selector at the bottom of the configuration screen, as it should be treated as the default option rather than the primary choice.
