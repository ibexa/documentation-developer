---
description: Create unique Customer Portals for your clients with Page Builder.
edition: experience
---

# Create Customer Portal

On this page, you will learn how to configure the Customer Portal feature to be editable with Page Builder.

## Configure Page Builder access to Customer Portal

First, you need to create a folder for Customer Portals, 
its `location_id` will be later specified in the configuration as [a tree root](multisite_configuration.md#siteaccesses-and-page-build).
To do it, go to **Content**->**Content structure** and add a new folder in the Content tree where you will be adding Customer Portals.

![Customer Portals folder](img/cp_folder_for_portals.png)

To be able to see Customer Portal site in the Page Builder you need to add `custom_portal` to the configuration.
First, go to `config/packages/ibexa.yaml` and add `custom_portal` to
the SiteAccess `list` and to `corporate_group`.

Next add configuration for `corporate_group` and `custom_portal` under `system`.
Remember to specify `location_id` of the root folder for Customer Portals, you will find it under **Details**. 

```yaml hl_lines="8 12 14 16"
ibexa:
    siteaccess:
        list:
            - import
            - site
            - admin
            - corporate
            - custom_portal    
        groups:
            site_group: [import, site]
            storefront_group: [site]
            corporate_group: [corporate, custom_portal]
    system:
        corporate_group:
            languages: [eng-GB]
        custom_portal:
            languages: [ eng-GB ]
            content:
                tree_root:
                    location_id: location_id_of_customer_portals_root_folder
                    excluded_uri_prefixes: [ /media, /images ]
```

Next, go to `config/packages/ibexa_admin_ui.yaml` and add `custom_portal` to the SiteAccess list available to Page Builder:

```yaml
ibexa:
    system:
        page_builder:
            siteaccess_list:
                - site
                - corporate
                - custom_portal
```

## Customer Portal vs Customer Portal Page

Now, you can go back to your **Customer Portals** folder and select **Create content**.
There you will see two possibilities **Customer Portal** and **Customer Portal Page**.
The first one is a container for your Customer Portal pages. 
We highly recommend that you use them to divide and store your portals.

![Create content tab](img/cp_portal_vs_page.png)