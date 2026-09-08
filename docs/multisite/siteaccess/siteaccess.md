---
description: SiteAccesses enable you to provide separate configuration for each site in a multisite setup.
page_type: landing_page
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    The landing page defines what a SiteAccess is and lists what can differ per
    SiteAccess. Confirm that the definition and the list still match the product once
    SiteAccess configuration moves to a UI.

    Links to the deleted design_engine.md and persistence_cache.md pages were removed;
    check that the surrounding text still reads correctly.
---

# SiteAccess

A SiteAccess is a set of configuration settings that the application uses when you access the site through a specific address.
When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration.
If it finds a set of fitting rules, this SiteAccess is used.

Each SiteAccess can have different:

- templates and designs
- [languages](set_up_translation_siteaccess.md)
- [tree roots](multisite_configuration.md#location-tree)
- repositories
- [recommendations](connector_installation_configuration.md#siteaccess-aware-configuration)

Many other settings in the application are also configured per SiteAccess (also known as "SiteAccess-aware").

!!! tip

    When possible, always use semantic (SiteAccess-aware) configuration.
    Manually editing internal settings is possible, but at your own risk, as unexpected behavior can occur.

[[= cards([
    "multisite/siteaccess/siteaccess_matching",
    "multisite/siteaccess/siteaccess_aware_configuration",
], columns=3) =]]
