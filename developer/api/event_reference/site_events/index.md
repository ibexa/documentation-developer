# Site events

Events that are triggered when working with sites.

Editions: Experience

The following events are dispatched when managing [Sites](../../../multisite/site_factory/site_factory/index.md).

| Event                   | Dispatched by             | Properties                                                             |
| ----------------------- | ------------------------- | ---------------------------------------------------------------------- |
| `BeforeCreateSiteEvent` | `SiteService::createSite` | `SiteCreateStruct $siteCreateStruct` `Site $site`                      |
| `CreateSiteEvent`       | `SiteService::createSite` | `Site $site` `SiteCreateStruct $siteCreateStruct`                      |
| `BeforeUpdateSiteEvent` | `SiteService::updateSite` | `Site $site` `SiteUpdateStruct $siteUpdateStruct` `?Site $updatedSite` |
| `UpdateSiteEvent`       | `SiteService::updateSite` | `Site $updatedSite` `Site $site` `SiteUpdateStruct $siteUpdateStruct`  |
| `BeforeDeleteSiteEvent` | `SiteService::deleteSite` | `Site $site`                                                           |
| `DeleteSiteEvent`       | `SiteService::deleteSite` | `Site $site`                                                           |
