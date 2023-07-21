---
description: Create unique Customer Portals for your clients with Page Builder.
edition: experience
---

# Create Customer Portal

On this page, you will learn how to configure the Customer Portal feature to be editable with Page Builder.
If you already configured Customer Portal, you can learn how to build it with a Page Builder in [User Documentation.]([[= user_doc =]]/customer_management/build_customer_portal/) 

First, you need to decide if you want to create and configure [one portal](#create-and-configure-one-portal) or [multiple portals](#create-and-configure-multiple-portals) setup.

## Create and configure one portal

This setup is recommended for simple use cases with one Customer Portal for all markets. 
If you plan to expand your portal portfolio in the future, see [multiple portal configuration](#create-and-configure-multiple-portals).

### Configure Page Builder access to Customer Portal

First, create a Customer Portal page, its location ID will be later specified in the configuration.
To do it, go to **Content** -> **Content structure**, and select **Customer Portal Page**.

For now, you only need to add a name and a description in the Field view, you can find it in the top toolbar on the left side.
Next, click **Publish** to see the page in the content tree.

![Add name and description to Customer Portal](img/cp_name_description.png)

To be able to see the Customer Portal site template in the Page Builder you need to add `custom_portal` SiteAccess to the configuration.
First, under the `ibexa.siteaccess` [configuration key](configuration.md#configuration-files) add `custom_portal` to
the SiteAccess `list` and to `corporate_group`.

Next, add configuration for `corporate_group` and `custom_portal` under `ibexa.system`.
Remember to specify `location_id` of your Customer Portal, you can find it under the **Details** tab of your new page.

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
                    location_id: location_id_of_customer_portal
                    excluded_uri_prefixes: [ /media, /images ]
```

Next, under the `ibexa.system.admin.page_builder` [configuration key](configuration.md#configuration-files) add `custom_portal` to [the SiteAccess list available to Page Builder](multisite_configuration.md#siteaccesses-and-page-builder):

```yaml
ibexa:
    system:
        admin:
            page_builder:
                siteaccess_list:
                    - site
                    - corporate
                    - custom_portal
```

Now, you can go to your Customer Portal landing page and edit it in Page Builder.

![Edit Customer Portal in Page Builder](img/cp_edit_in_page_builder.png)

### Grant permissions to customers

You need to grant the following permissions to company members, so they can view custom Customer Portal:

- `user/login` to `custom_portal` SiteAccess
- `content/read` to the Customer Portal

![Single Customer Portal permissions](img/single_cp_permissions.png)

If members of the company don't have sufficient permissions for any Customer Portal, they are redirected to the default Customer Portal view.

!!! note

    Customer Portal is only available to users that are members of the company. Even if user has all the sufficient permissions but is not a member of a company, they can't see the Customer Portal.

## Create and configure multiple portals

This setup is recommended for global markets or company specific portals, where each portal is design specifically for its users and their needs.

### Customer Portal container

First, you need to create a root folder for Customer Portals,
its location ID will be later specified in the configuration as [a tree root](multisite_configuration.md#location-tree).
To do it, go to **Content** -> **Content structure**, and select **Create content**.
There you will see two possibilities **Customer Portal** and **Customer Portal Page**.

![Create content tab](img/cp_portal_vs_page.png)

The first one is a separate Content Type used as a container for your Customer Portal pages.
Customer Portals containers should be used to sort Customer Portal pages and any other Content Types used by them, such as articles, inside the root folder.
It is recommended that you use them instead of folders to divide and store your portals.
Select **Customer Portal**, define its name and publish.

![Customer Portals folder](img/cp_folder_for_portals.png)

### Configure Page Builder access to Customer Portal

To be able to see Customer Portal site template in the Page Builder you need to add `custom_portal` SiteAccess to the configuration.
First, under the `ibexa.siteaccess` [configuration key](configuration.md#configuration-files) add `custom_portal` to
the SiteAccess `list` and to `corporate_group`.

Next, add configuration for `corporate_group` and `custom_portal` under `ibexa.system`.
Remember to specify `location_id` of the root folder for Customer Portals, you can find it under the **Details** tab. 

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

Next, under the `ibexa.system.admin.page_builder` [configuration key](configuration.md#configuration-files) add `custom_portal` to [the SiteAccess list available to Page Builder](multisite_configuration.md#siteaccesses-and-page-builder):

```yaml
ibexa:
    system:
        admin:
            page_builder:
                siteaccess_list:
                    - site
                    - corporate
                    - custom_portal
```

Now, you can go back to your Customer Portal's container.
All landing pages that you create in it will have Customer Portal template.

### Assign Portal to Customer Group

You can assign multiple Customer Portal containers or Pages to a specific Customer Group.
First, you need to grant the following permissions to company members from the Customer Group: 

- `user/login` to `custom_portal` SiteAccess
- `content/read` to selected Customer Portals

![Customer Portal permissions](img/cp_permissions.png)

If members of the Customer Group don't have sufficient permissions for any Customer Portal assigned to them, they will be redirected to the default Customer Portal view.

!!! note

    Customer Portal is only available to users that are members of the company. Even if user has all the sufficient permissions but is not a member of a company, they won't see the Customer Portal.

#### Build-in portal mapping

Now, you need to assign your custom portals to Customer Groups.
Add portal mapping configuration in `config/services.yaml`:

```yaml hl_lines="3 4"
parameters:
    ibexa.corporate_account.customer_portal.customer_group_to_portal_map:
        eu:
            - 6bd4c938f9b3f668057c7e20987fac6c
            - 7bf85988a77ee859f2466av2b42bd909
        us:
            - 6ce85480aeaeed59f7431a12b46bc869
```

There, you can specify which Customer Portals should be available to which Customer Group by adding:

- Customer Group identifier. You can find it in the **Summary** section of the Company.
- Location remote ID of Customer Portal container or Customer Portal page. You can find it in the **Details** section.

Portals will be displayed to the Customer Group in order specified in the configuration based on company member's permissions.

#### Custom portal mapping

You can specify your own custom logic for redirecting members to a specific Customer Portal.
To do so, implement `\Ibexa\Contracts\CorporateAccount\CustomerPortal\PickRule\CustomerPortalPickRule` and tag it with `ibexa.corporate_account.customer_portal.pick_rule`.

### Multiple portals on single page

You can allow company members to see multiple versions of Customer Portal on a single page by [combining SiteAccess matchers](siteaccess_matching.md#custom-matchers) with `Compound\LogicalAnd`:

```json
ibexa:
    siteaccess:
        match:
            Compound\LogicalAnd:
                custom_portal:
                    matchers:
                        Map\Port:
                            eu: true
                        Map\Host:
                            example.com: true
                    match: custom_portal
            Map\Host:
                admin.example.com: site_admin
```

![Multiple portals in one view](img/cp_2_page_view.png)

## Change Customer Portal layout

You can change Customer Portal layout by adding your custom template under `ibexa.system.<portal_name>.page_layout`:

```yaml hl_lines="5"
ibexa:
    system:
        custom_portal:
            languages: [ eng-GB ]
            page_layout: "@App/my_page_layout.html.twig"
            content:
                tree_root:
                    location_id: location_id_of_customer_portals_root_folder
                    excluded_uri_prefixes: [ /media, /images ]
```

To generate the Customer Portal menu you should use `customer_portal.menu.main` key:

```html+twig hl_lines="4"
{% block side_column %}
    <div class="ibexa-main-container__side-column {% block side_column_class %}{% endblock %}">
        {% block left_sidebar %}
            {% set main_menu = knp_menu_get('customer_portal.menu.main', [], {}) %}
            {{ knp_menu_render(main_menu, {
                depth: 1,
                template: '@ibexadesign/customer_portal/menu.html.twig',
                currentClass: 'active',
                ancestorClass: 'active',
            }) }}
        {% endblock %}
    </div>
{% endblock %}
```
To learn more about creating a menu, see [Add navigation menu](add_navigation_menu.md).
