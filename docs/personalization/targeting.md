---
description: Use the Targeting block to display content based on a visitor's audiences.
edition: experience
month_change: true
---

# Targeting block

The Targeting block is a [Page Builder](page_builder_guide.md) block that displays a content variant based on the [audiences](audiences.md) a visitor belongs to.

## Multi-audience configuration

The Targeting block lets you assign multiple audiences to a single content item in one configuration pass.

Each variation in the block is configured with:

- one or more audiences
- the content item to display when a visitor matches

If a visitor belongs to multiple audiences, the first matching variant in the configured order is used, subject to content permissions.
An audience group selected for one variant cannot be selected for another, so its rules aren't overwritten.

## Configure Targeting block

To configure a Targeting block:

1. Under **Content matching priority rules**, click **Select content**, choose the content item or items, and confirm your selection.
   The selected content is listed with its name, type, and size. Hover over its name to see a preview.
2. Click **Select audience** next to the content.
   The selection window lists audience groups under **Results**, with the number of audiences in each group.
3. Select one or more groups or individual audiences.
   The selection banner shows the selected groups or audiences.
   If more than one is selected, click the arrow next to the number to expand the list.
   Use **X** next to an item to remove it, or **Clear all** to clear the selection.
   Click **Add** to confirm.
4. To add more variants, click **Add** and repeat the previous steps.
5. Optionally, under **Fallback content**, click **Select content** to choose content for visitors who don't match a variant.
6. Click **Save and close**.

## Permissions

Audience evaluation takes content permissions into account.
The system checks if the visitor can access the content for each audience.

If a visitor belongs to multiple audiences:

- the system checks audiences in the configured order
- the system checks the next matching audience if the visitor cannot access the content for the first one
- the system stops when it finds content the visitor can access

If a visitor belongs to only one audience and cannot access the associated content, the system shows the [fallback content](#fallback-content).

## Fallback content

Fallback content is rendered:

- if a visitor belongs to only one audience and the associated content is not accessible
- whenever no accessible content variation can be displayed across all audiences the visitor belongs to
- the visitor doesn't belong to any of the configured audiences

You can find the fallback selector at the bottom of the configuration screen.

If fallback content is not selected, the block appears empty to all other audiences.
