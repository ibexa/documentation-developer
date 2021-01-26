# Site events [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

The following events are dispatched when managing [Sites](../../site_factory.md).

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateSiteEvent`|`SiteService::createSite`|`SiteCreateStruct $siteCreateStruct`</br>`Site $site`|
|`CreateSiteEvent`|`SiteService::createSite`|`Site $site`</br>`SiteCreateStruct $siteCreateStruct`|
|`BeforeUpdateSiteEvent`|`SiteService::updateSite`|`Site $site`</br>`SiteUpdateStruct $siteUpdateStruct`</br>`Site|null $updatedSite`|
|`UpdateSiteEvent`|`SiteService::updateSite`|`Site $updatedSite`</br>`Site $site`</br>`SiteUpdateStruct $siteUpdateStruct`|
|`BeforeDeleteSiteEvent`|`SiteService::deleteSite`|`Site $site`|
|`DeleteSiteEvent`|`SiteService::deleteSite`|`Site $site`|
