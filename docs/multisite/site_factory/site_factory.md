---
month_change: false
description: Site Factory allows creating multiple sites (SiteAccesses) from the back office.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Site Factory is set up by adding empty SiteAccess groups and enabling the Site
    Factory SiteAccess matcher in YAML. Confirm both steps, and how Site Factory sites
    relate to configured SiteAccesses, once SiteAccess configuration moves to a UI.

    Links to the deleted design_engine.md page were removed; check that the surrounding
    text still reads correctly.
---

# Site Factory

Site Factory is a site management interface, integrated with the back office.
It enables you to configure new sites without editing [YAML-based SiteAccess configuration](multisite_configuration.md).

!!! note

    A SiteAccess that you define for a site by following the [configuration](multisite_configuration.md) is always treated with higher priority than a SiteAccess created by using the Site Factory.
    For example, if you define a French site within a YAML file, and then create a site that uses the `fr` path in Site Factory, matchers ignore the second site.

Site Factory is disabled by default.
If you plan to use Site Factory, you need to [enable and configure it](#enable-site-factory).

## Enable Site Factory

To enable Site Factory, set the `ibexa_site_factory.enabled` [configuration key](configuration.md#configuration-files) to `true`.

### Configure designs

Next, configure Site Factory by adding empty SiteAccess groups.
At least one empty group is required.
The number of empty SiteAccess groups must be equal to the number of templates that you want to have when you create the new site.

In this example, you add two SiteAccess groups (`example_site_factory_group_1` and `example_site_factory_group_2`) that correspond to the two templates (`site1` and `site2`) that you add in the next step.

Add the groups under the `ibexa.siteaccess` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    siteaccess:
        # ...
        groups:
            site_group: [import, site]
            storefront_group: [site]
            corporate_group: [corporate]
            example_site_factory_group_1: [ ]
            example_site_factory_group_2: [ ]

    system:
        example_site_factory_group_1:
        example_site_factory_group_2:
```

Uncomment the SiteAccess matcher (`Ibexa\SiteFactory\SiteAccessMatcher`):

``` yaml
ibexa:
    siteaccess:
        match:
            '@Ibexa\SiteFactory\SiteAccessMatcher': ~
```

Next, add the design engine configuration for new specific designs and their theme lists:

``` yaml
ibexa_design_engine:
    design_list:
        example_1: [example_1_theme]
        example_2: [example_2_theme]
```

Finally, configure designs for empty SiteAccess groups:

``` yaml
ibexa:
    system:
        example_site_factory_group_1:
            design: example_1
        example_site_factory_group_2:
            design: example_2
```

### Add site template configuration

Add thumbnails and names for your site templates:

```yaml
ibexa_site_factory:
    templates:
        site1:
            siteaccess_group: example_site_factory_group_1
            name: Example site 1
            thumbnail: /path/to/image/example-thumbnail_1.png
        site2:
            siteaccess_group: example_site_factory_group_2
            name: Example site 2
            thumbnail: /path/to/image/example-thumbnail_2.png
```

You can check the results of your work in the back office by going to **Site management** and selecting **Sites**.

There, you should be able to add a new site and choose a design for it.

### Define site directory

You can adjust the place where the directory of the new site is created (location with ID 2 by default).
To do it, go to configuration files and under the `ibexa.system.<scope>.site_factory` [configuration key](configuration.md#configuration-files) add the following parameter:

``` yaml
ibexa:
    system:
        default:
            site_factory:
                sites_location_id: 42
```

Now, all new directories are created under "[[= product_name =]]".

### Provide access

The Site Factory is set up, now you can provide sufficient permissions to the users.

Set the below policies to allow users to:

- `site/view` - enter the Site Factory interface
- `site/create` - create sites
- `site/edit` - edit sites
- `site/change_status` - change status of the public accesses to `Live` or `Offline`
- `site/delete` - delete sites

For full documentation on how permissions work and how to set them up, see [the permissions section](permissions.md).

To learn how to use Site Factory, see [User Documentation]([[= user_doc =]]/website_organization/work_with_sites/).
