---
description: Create a special SiteAccess to host a campaign site with different content subtree.
---

# Set up campaign SiteAccess

The following example shows how to set up a special `campaign` SiteAccess.
This SiteAccess serves a site devoted to a special campaign, separate from the main company website (`site` SiteAccess).

The `campaign` site uses a different part of the content tree than the main site, but shares some media files with it.

## Configure SiteAccesses

First, in the SiteAccess configuration in `config/packages/ibexa.yaml`,
add the `campaign` SiteAccess to the list under `ibexa.siteaccess`:

``` yaml
ibexa:
    siteaccess:
        list: [site, campaign]
        groups:
            site_group: [site, campaign]
        default_siteaccess: site
        match:
            Map\URI:
                summer-sale: campaign
                site: site
```

The `match` setting ensures that when a visitor accesses the `<yourdomain>/summer-sale` URI,
they see the `campaign` SiteAccess.

## Set root folder

Next, with the following content structure, you need to separate the "Campaign" folder as root for the new site:

![Content structure](config_content_structure.png "Content structure")

To do it, set the root level for `campaign` to access the "Campaign" Location and its sub-items only:

``` yaml
ibexa:
    system:
        campaign:
            content:
                tree_root:
                    # LocationId of "Campaign"
                    location_id: 57
```

Thanks to this configuration, you can access `<your site>/campaign/Articles/Article2`,
but not `<your site>/campaign/General/Articles/Article1`.

## Reuse content

Finally, reuse some content between sites, for example "Logos" from "Images/Media".
You can allow the `campaign` site to access them, even though they are in a different part of the tree, via `excluded_uri_prefixes`:

``` yaml
ibexa:
    system:
        campaign:
            content:
                tree_root:
                    location_id: 57
                    excluded_uri_prefixes: [ /media/images/logos ]
```

Now, when you use the `campaign` SiteAccess, you can reach `<your site>/campaign/Media/Images/Logos`,
despite the fact that it is not a sub-item of the "Campaign" Location.

As a next step, you can configure different [designs](design_engine.md)
for the two SiteAccesses.
