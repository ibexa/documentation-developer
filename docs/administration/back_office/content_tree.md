---
description: Configure SiteAccess, displayed content items, depth and root location for the content tree.
---

# Content tree

With this configuration you can:

- define configuration for a SiteAccess or a SiteAccess group
- decide how many content items are displayed in the tree
- set maximum depth of expanded tree
- hide content types
- set a tree root Location
- override content tree's root for specific Locations

```yaml
ibexa:
    system:
        # any SiteAccess or SiteAccess group
        admin_group:
            content_tree_module:
                # defines how many children is be shown after expanding parent
                load_more_limit: 15
                # users won't be able to load more children than that
                children_load_max_limit: 200
                # maximum depth of expanded tree
                tree_max_depth: 10
                # content types to display in content tree, value of '*' allows all CTs to be displayed
                allowed_content_types: '*'
                # content tree won't display these content types, can be used only when 'allowed_content_types' is set to '*'
                ignored_content_types:
                   - post
                   - article
                # ID of Location to use as tree root. If omitted - content.tree_root.location_id setting is used.
                tree_root_location_id: 2
                # list of Location IDs for which content tree's root Location is changed
                contextual_tree_root_location_ids:
                   - 2 # Home (Content structure)
                   - 5 # Users
                   - 43 # Media
```