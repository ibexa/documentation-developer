# Multisite

Multisite configuration is done using SiteAccesses.

A SiteAccess is a set of configuration settings that the application uses when you access the site through a specific address.
When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration.
If it finds a set of fitting rules, this SiteAccess is used.

You can create a multisite setup with SiteAccesses covering different use cases, for example:

- [different language versions of the webpage](set_up_translation_siteaccess.md)
- [a special sub-site for a campaign or event](set_up_campaign_siteaccess.md)
- additional [Back Office](multisite_configuration.md#admin-siteaccess)

A multisite set-up enables you to configure different things per SiteAccess, for example:

- [templates and designs](../content_rendering/design_engine/design_engine.md)
- [languages](set_up_translation_siteaccess.md)
- [tree roots](multisite_configuration.md#location-tree)
- [repositories](../config_repository.md) and [cache strategies](../persistence_cache.md#multi-repository-setup)
- [recommendations](../personalization/enabling_personalization.md#configure-personalization)

Many other settings in the application are also configured per SiteAccess (also known as "SiteAccess-aware").

!!! tip

    When possible, always use semantic (SiteAccess-aware) configuration.
    Manually editing internal settings is possible, but at your own risk, as unexpected behavior can occur.

To quickly set up new sites with predefined site templates, use [Site Factory](site_factory.md).
