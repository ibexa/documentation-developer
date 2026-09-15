---
description: Manage URL aliases and wildcards, and validate external URLs.
month_change: false
---

# URL management

You can manage external URL addresses and URL wildcards in the back office, **Admin** tab, the **URL Management** node.
Configure URL aliases to have human-readable URL addresses throughout your system.

## Link manager

When developing a site, users can enter links to external websites in either RichText or URL fields.
Each such link is then displayed in the URL table. You can view and update all external links that exist within the site, without having to modify and re-publish the individual content items.

The **Link manager** tab contains all the information about each link, including its status (valid or invalid) and the time the system last attempted to validate the URL address.
Click an entry in the list to display its details and check which content items use this link.
Edit the entry to update the URL address in all the occurrences throughout the website.

!!! note

    When you edit the details of an entry to update the URL address, the status automatically changes to valid.

## URL aliases

You can define URL aliases for individual content items, for example, when you reorganize the content, and want to provide users with continuity.
For each URL alias definition the history of changes is preserved, so that users who have bookmarked the URL addresses of content items can still find the information they desire.

!!! caution "Storage limitation"

    URL aliases that initially had the same name in multiple languages aren't archived.

URL aliases aren't SiteAccess-aware. When creating an alias, you can select a SiteAccess to base it on.
If the SiteAccess root path (configured in `content.tree_root.location_id`) is different than the default,
the prefix path that results from the configured content root is prepended to the final alias path.
