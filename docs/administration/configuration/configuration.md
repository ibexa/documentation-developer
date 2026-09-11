---
description: In Cohesivo you store and manage configuration in project files, typically in YAML format.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Describes the configuration system, including SiteAccess-aware settings that take a
    different value per SiteAccess, per SiteAccess group, or globally. Confirm how much
    of this remains accurate once configuration is delivered through a UI rather than
    project files.

    Links to the deleted php_api.md, repository_configuration.md,
    template_configuration.md, devops.md, development_security.md, sessions.md and
    persistence_cache.md pages were removed; check that the surrounding text still reads
    correctly.
---

# Configuration

TODO: Rework this to describe the SiteAccess UI, and siteacces-aware settings.

Merge the content from docs/multisite/siteaccess/siteaccess_aware_configuration.md 


#### `admin` SiteAccess

The predefined `admin` SiteAccess in `admin_group` serves the back office.



## Location tree

You can restrict SiteAccesses to different parts of the content tree.
When you do it, only the selected location and its descendants are reachable from this SiteAccess.

Configure this under the `ibexa.systems.<scope>.content.tree_root` [configuration key](configuration.md#configuration-files), for example:

``` yaml
ibexa:
    system:
        <scope>:
            content:
                tree_root:
                    location_id: 42
                    excluded_uri_prefixes: [/media/, /images/]
            index_page: /EventFrontPage
```

- `location_id` defines the location ID of the content root for the SiteAccess.
- `excluded_uri_prefixes` defines which URIs ignore the root limit set by using `location_id`.
  In the example above, to access the Media and Images folders, you can use their own URI, even though they're outside the location provided in `content.tree_root.location_id`.
  It's an array of prefixes. So, for example, `[/media]` would also exclude `/mediation` from root limit.
- `index_page` is the page shown when you access the root index `/`.

!!! note

    Prefixes aren't case sensitive.
    Leading slashes (`/`) are automatically trimmed internally, so they can be ignored.
