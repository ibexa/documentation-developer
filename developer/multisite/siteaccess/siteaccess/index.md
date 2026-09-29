# SiteAccess

SiteAccesses enable you to provide separate configuration for each site in a multisite setup.

A SiteAccess is a set of configuration settings that the application uses when you access the site through a specific address. When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration. If it finds a set of fitting rules, this SiteAccess is used.

Each SiteAccess can have different:

- [templates and designs](../../../templating/design_engine/design_engine/index.md)
- [languages](../../set_up_translation_siteaccess/index.md)
- [tree roots](../../multisite_configuration/index.md#location-tree)
- [repositories](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#multi-repository-setup)
- [recommendations](../../../recommendations/raptor_integration/connector_installation_configuration/index.md#siteaccess-aware-configuration)

Many other settings in the application are also configured per SiteAccess (also known as "SiteAccess-aware").

> **Tip: Tip**
>
> When possible, always use semantic (SiteAccess-aware) configuration. Manually editing internal settings is possible, but at your own risk, as unexpected behavior can occur.

- [SiteAccess matching](../siteaccess_matching/index.md): Use SiteAccess matchers to control which site is served when and to which user.
- [SiteAccess-aware configuration](../siteaccess_aware_configuration/index.md): Make sure your custom development's configuration can be used with SiteAccesses.
- [Injecting SiteAccess](../injecting_siteaccess/index.md): Inject the SiteAccess service to get SiteAccess information in your custom PHP code.
