---
description: Configure SiteAccesses to serve different content.
---

# Multisite configuration

You can configure the available SiteAccesses by using the [configuration](configuration.md).

## SiteAccess configuration

``` yaml
ibexa:
    siteaccess:
        list: [site, event]
        groups:
            site_group: [site]
            event_group: [event]
        default_siteaccess: site
        match:
            URIElement: 1
```

### SiteAccess groups

`ibexa.siteaccess.groups` defines which groups SiteAccesses belong to.

``` yaml
ibexa:
    siteaccess:
        groups:
            site_group: [site]
            event_group: [event]
```

You can use groups when you want to use common settings for several SiteAccesses and avoid duplicating configuration.
SiteAccess groups act like regular SiteAccesses as far as configuration is concerned.
A SiteAccess can be part of several groups. SiteAccess configuration has always precedence over group configuration.
