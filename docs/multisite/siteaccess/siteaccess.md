---
description: SiteAccesses enable you to provide separate configuration for each site in a multisite setup.
---

# SiteAccess

A SiteAccess is a set of configuration settings that the application uses when you access the site through a specific address.
When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration.
If it finds a set of fitting rules, this SiteAccess is used.

Each SiteAccess can have different:

- [templates and designs](design_engine.md)
- [languages](set_up_translation_siteaccess.md)
- [tree roots](multisite_configuration.md#location-tree)
- [repositories](persistence_cache.md#multi-repository-setup)
- [recommendations](enable_personalization.md#configure-personalization)

Many other settings in the application are also configured per SiteAccess (also known as "SiteAccess-aware").

!!! tip

    When possible, always use semantic (SiteAccess-aware) configuration.
    Manually editing internal settings is possible, but at your own risk, as unexpected behavior can occur.

[[= cards([
    "multisite/siteaccess/siteaccess_matching",
    "multisite/siteaccess/siteaccess_aware_configuration",
    "multisite/siteaccess/injecting_siteaccess",
], columns=3) =]]
