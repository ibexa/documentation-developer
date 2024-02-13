---
description: Ibexa DXP v4.6 brings improvements to Commerce, PIM and Personalization offerings, and a number of changes in CDP and Ibexa Connect.
---

<!-- vale VariablesVersion = NO -->

# Ibexa DXP v4.6

**Version number**: v4.6

**Release date**: February 13, 2024

**Release type**: [LTS](https://support.ibexa.co/Public/service-life)

**Update**: [v4.5.x to v4.6](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/)

## Notable changes

### Ibexa Headless

[[= product_name_content =]] changes name to [[= product_name_headless =]] to emphasize [[= product_name_base =]]'s capacity for headless architecture.

The feature set and capabilities of the product remain the same.

### Customizable dashboard [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Users can now customize the dashboard depending on their needs and preferences, select required blocks, and easily access important information.
This solution uses an online editor - Dashboard Builder.
It improves productivity, allows to enhance the default dashboard with additional widgets,
and helps to make better business decisions based on data.

![Customizable dashboard](img/4.6_customizable_dashboard.png "Customizable dashboard")

For more information, see [Customizable dashboard](https://doc.ibexa.co/projects/userguide/en/master/getting_started/dashboard/dashboard/#customizable-dashboard).

### UX and UI improvements

Several improvements to the Back Office interface enhance the user experience.

#### Page Builder improvements

Page Builder user interface has new functionalities and improvements.

Here are the most important changes:

- new design of Page Builder interface, including block settings window,
- two main toolboxes: **Elements** and **Structure view**,
- quick preview of a structure of the page with the possibility of reorganizing the blocks,
- new visual feedback indicates the correct drop locations,
- intuitive dragging makes it easier for users to interact with the Page Builder,
- new actions added in the block settings toolbox,
- user can now adjust the size of the block settings window,
- **Undo** and **Redo** buttons.

![Page Builder interface](img/4.6_page_builder_interface.png "Page builder interface")

For more information, see [Page Builder interface](https://doc.ibexa.co/projects/userguide/en/master/content_management/create_edit_pages/#page-builder-interface).

#### Editing embedded Content items

User can now edit embedded Content items without leaving current window.
This function is available in the Rich Text Field when creating Content items, for selected blocks in the Page Builder,
and while adding or modifying a Content relation.

![Editing embedded Content items](img/4.6_editing_embedded_content_items.png "Editing embedded Content items")

For more information, see [Edit embedded Content items](https://doc.ibexa.co/projects/userguide/en/master/content_management/create_edit_content_items/#edit-embedded-content-items).

#### Focus mode

With multiple changes to the Back Office UI intended to expose the most important information and actions, editors can now better focus on their work.
The UI is now more friendly and appealing for marketers and editors, with simplified Content structure, designed with new and non-advanced users in mind.
For more information, see [Focus mode](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/discover_ui/#focus-mode).

![Focus mode](img/4.6_focus_mode.png "Focus mode")

As part of this effort, some other changes were introduced that apply to both regular and Focus mode:

- In Content item details view, tabs have been reordered by their relevance
- **Authors** and **Sub-items** are now separate tabs in Content item details view
- Former **Details** tab is now called **Technical details** and changed its position
- Preview is available in many new places, such as the **View** tab in Content item details view, or as miniatures when you hover over the Content Tree
- `ibexa_is_focus_mode_on` and `ibexa_is_focus_mode_off` Twig helpers have been introduced, which check whether focus mode is enabled or not.

![Sub-items tab](img/4.6_sub_items_tab.png "Sub-items tab")

#### Ability to change site context

With a drop-down list added to the top bar, which changes the site context, editors can choose that the Content Tree shows only those Content items that belong to the selected website.
And if Content items belong to multiple websites but use different designs or languages depending on the SiteAccess settings, their previews also change.

As part of this effort, the name of the "Sites" area of the main menu has changed to "Site management".

![Site context selector](img/4.6_site_selector.png "Site context selector")

#### Distraction free mode

While editing Rich Text Fields, user can switch to distraction free mode.
It expands the workspace to full screen and shows only editor toolbar.

![Distraction free mode](img/4.6_distraction_free_mode.png "Distraction free mode")

For more information, see [Distraction free mode](https://doc.ibexa.co/projects/userguide/en/master/content_management/create_edit_content_items/#distraction-free-mode).

#### Simplified user actions

Button text now precisely describes actions, so that users who create or edit content understand the purpose of each button.

![Improved button text](img/4.6_publishing_options.png "Improved button text")

#### Draft section added to Content

For streamlining purpose, the **Draft** section is now situated under **Content**.
Users can now easily find and manage their drafts and published content from one area.

![Draft section added to Content](img/4.6_drafts.png "Draft section added to Content")

#### User profile and new options in user settings

With personal touch in mind, editors can now upload their photos (avatar), and provide the following information in their user profiles:

- Email
- Department
- Position
- Location
- Signature
- Roles the user is assigned to
- Recent activity

![User profile](img/user_profile_preview.png "User profile")

Also, editors and other users can customize their experience even better, with new preferences that have been added to user settings.

For more information, see [user profile and settings documentation](https://doc.ibexa.co/projects/userguide/en/master/getting_started/get_started/#edit-user-profile).

#### Recent activity log

Several actions on the repository or the application are logged.
In the Back Office, last activity logs can be listed on a dedicated interface (Admin -> Activity list),
on the dashboard within Recent activity block, or on the user profile.

![Recent activity log](img/4.6_activity_list.png "Recent activity log")

For more information,
see feature's [user documentation](https://doc.ibexa.co/projects/userguide/en/master/recent_activity/recent_activity/),
and [developer documentation](https://doc.ibexa.co/en/master/docs/administration/recent_activity/recent_activity/).

#### Back Office search

##### Search bar, suggestions, autocompletion, and spellcheck

The search bar can be focused with the shortcut Ctrl+/ (Windows, Linux) or Command+/ (Mac).

While typing text in the bar, autocompletion suggestions is made under the bar itself.
If a relevant suggestion occurs, it can be clicked, or navigated too with up/down keys then selected with Enter, and the content is be directly opened.

In the search result page, a spellcheck suggestion can be made.
For example, if the searched text is "Comany", the result page may ask "Did you mean company?", which is clickable to relaunch the search with this word.

For more information,
see [user documentation](https://doc.ibexa.co/projects/userguide/en/master/search/search_for_content/),
and how to [customize autocompletion suggestions](https://doc.ibexa.co/en/master/docs/administration/back_office/search_suggestion/).

##### Filtering and sorting

The search result page can be sorted in other orders than relevance. Name, publication of modification dates, this can be extended.

Filters can be applied to the search page to narrow down the results.

For more information,
see [user documentation](https://doc.ibexa.co/projects/userguide/en/master/search/search_for_content/#filtered-search),
and how to [customize search sorting](https://doc.ibexa.co/en/master/docs/administration/back_office/search_sorting/).

#### New and updated Content Type icons

To help users quickly identify different content types in the Back Office, all Content Type references are now accompanied with icons.
Also, Content Type icons have changed slightly.

![Content type icons](img/4.6_content_type_icons.png "Content type icons")

### Ibexa Image picker

Editors can now use a Digital Asset Management platform that enables storing media assets in a central location, as well as organizing, distributing, and sharing them across many channels.

For more information, see [Ibaxa DAM](https://doc.ibexa.co/projects/userguide/en/master/dam/ibexa_dam/).

### New features and improvements in PIM

#### Remote PIM support

This release introduces a foundation for connecting [[= product_name =]] to other sources of product data.
You can use it to implement a custom solution and connect to external PIM or ERP systems, import product data, and present it side-by-side with your organization's existing content, while managing product data in a remote system of your choice.

Here are the most important benefits of Remote PIM support:

- Integration with external data sources: your organization can utilize [[= product_name =]]'s features, without having to migrate data to a new environment.
- Increased accessibility of product information: customers and users can access product data through different channels, including [[= product_name =]].
- Centralized product data management: product information can be maintained and edited in one place, which then serves as a single source of truth for different applications.

Among other things, the Remote PIM support feature allows [[= product_name =]] customers to:

- let their users purchase products by following a regular or quick order path,
- manage certain aspects of product data,
- define and use product types,
- use product attributes for filtering,
- build product catalogs based on certain criteria, such as type, availability, or product attributes,
- use Customer Groups to apply different prices to products,
- define and use currencies.

For more information about Remote PIM support and the solution's limitations, see [PIM product guide](https://doc.ibexa.co/en/master/pim/pim_guide/#limitations).

#### Virtual products

With this feature, you can create virtual products - non-tangible items such as memberships, services, warranties.
Default Checkout and Order workflows have been adjusted to allow purchase of virtual products.

For more information, see [Create virtual products](https://doc.ibexa.co/projects/userguide/en/master/pim/create_virtual_product/).

#### Product page URLs

When you are creating a new product type, you can set up a product URL alias name pattern.
With this feature, you can also create custom URL and URL alias name pattern field based on product attributes.
Customized URLs are easier to remember, help with SEO optimization and reduce bounce rates on the website.

For more information, see [Product page URLs](https://doc.ibexa.co/projects/userguide/en/master/pim/work_with_product_page_urls/).

#### Improved UX of VAT rate assignment

Users who are creating or editing a product type are less likely to forget about setting VAT rates, because they now have a more prominent place.

![Assigning VAT rates to a product type](img/4.6_catalog_vat_rates.png "Assigning VAT rates to a product type")

For more information, see [Create product types](https://doc.ibexa.co/projects/userguide/en/master/pim/create_product_types/).

#### Updated VAT configuration

VAT rates configuration has been extended to accept additional flags under the `extras` key.
Developers can use them, for example, to pass additional information to the UI, or define special exclusion rules.

For more information, see [VAT rates](https://doc.ibexa.co/en/master/pim/pim_configuration/#vat-rates).

#### Ability to search through products in a catalog

When you are reviewing catalog details, on the **Products** tab, you can now see what criteria are used to include products in the catalog, and search for a specific product in the catalog.

#### New Twig functions

The `ibexa_is_pim_local` Twig helper has been introduced, which can be used in templates to [check whether product data comes from a local or remote data source](https://doc.ibexa.co/en/master/templating/twig_function_reference/storefront_twig_functions/#ibexa_is_pim_local), and adjust their behavior accordingly.
Also, several new Twig functions have been implemented that help [get product availability information](https://doc.ibexa.co/en/master/templating/twig_function_reference/product_twig_functions/#ibexa_has_product_availability).

#### New and modified query types

The `ProductContentAwareListQueryType` has been created to allow finding products that come from a local database, while `ProductListQueryType` has been modified to find products from an external source of truth.

#### New Search Criterion

With `IsVirtual` criterion that searches for virtual or physical products, product search now supports products of virtual and physical type.

#### Product migration

[Product variants](https://doc.ibexa.co/en/master/content_management/data_migration/importing_data/#product-variants) and [product assets](https://doc.ibexa.co/en/master/content_management/data_migration/importing_data/#product-assets) can now be created through [data migration](https://doc.ibexa.co/en/master/content_management/data_migration/data_migration/).

###  New features and improvements in Commerce [[% include 'snippets/commerce_badge.md' %]]

#### Reorder

With the new Reorder feature, customers can effortlessly repurchase previously bought items
directly from their order history with a single click, eliminating the need for manual item selection.
The system streamlines the process by recreating the cart, retrieving shipping information, and pre-filling payment details from past orders.
This feature is exclusively accessible to logged-in users, ensuring a secure and personalized shopping experience.

For more information, see [reorder documentation](https://doc.ibexa.co/en/master/commerce/checkout/reorder/).

#### Orders block

Orders block displays a list of orders associated with a specific company or an individual customer.
This block allows users to configure orders statuses, columns, number of orders, and sorting order.

For more information, see [Orders block documentation](https://doc.ibexa.co/projects/userguide/en/master/content_management/block_reference/#orders-block).

#### Quick order

The quick order form allows users to streamline the process of placing orders
with multiple items in bulk directly from the storefront.
Customers don't need to browse through products in the catalog.
They can fill in a provided form with products' code and quantity,
or upload their own list directly into the system.
Quick order form is available to both registered and guest users.

![Quick order](img/4.6_quick_order.png "Quick order")

For more information, see [Quick order documentation](https://doc.ibexa.co/en/master/commerce/cart/quick_order/).

#### Cancel order

This version allows you to customize order cancellations by defining a specific order status and related transition.

For more information, see [Define cancel order](https://doc.ibexa.co/en/master/commerce/order_management/configure_order_management/#define-cancel-order).

#### Integrate with payment gateways

[[= product_name =]] can now be configured to integrate with various payment gateways, like Stripe and PayPal, by using the solution provided by [Payum](https://github.com/Payum).

#### Shipments

Users can now work with the shipments: view and modify their status, filter shipments in shipment lists and check all the details.
You can access shipments for your own orders or all the shipments that exist in the system, depending on your permissions.

![Shipments](img/4.6_shipments.png "Shipments")

For more information, see [Work with shipments](https://doc.ibexa.co/projects/userguide/en/master/commerce/shipping_management/work_with_shipments/).

#### Owner criterion

Orders and shipments search now supports user reference:

- `OwnerCriterion` Criterion searches for orders based on the user reference.
- `Owner` Criterion searches for shipments based on the user reference.

#### Customize checkout workflow

You can create a PHP definition of the new strategy that allows for workflow manipulation.
Defining strategy allows to add conditional steps for workflow if needed.
When a conditional step is added, the checkout process uses the specified workflow and proceeds to the defined step.

For more information, see [Create custom strategy](https://doc.ibexa.co/en/master/commerce/checkout/customize_checkout/#create-custom-strategy).

#### Manage multiple checkout workflows

When working with multiple checkout workflows, you can now specify the desired workflow by passing its name as an argument to the checkout initiation button or link.

For more information, see [Manage multiple workflows](https://doc.ibexa.co/en/master/commerce/checkout/customize_checkout/#manage-multiple-workflows).

#### Adding context data to cart

Attach context data to both the Cart and its individual Cart Entries.
This feature enhances the flexibility and customization of your e-commerce application,
enabling you to associate additional information with your cart and its contents.
By leveraging context data, such as promo codes or custom texts,
you can tailor the shopping experience for your customers and enhance the capabilities of your application.

For more information, see [Adding context data](https://doc.ibexa.co/en/master/commerce/cart/cart_api/#adding-context-data).

### New features and improvements in Personalization

#### Triggers

Triggers are push messages delivered to end users.
With triggers, store managers can increase the engagement of their visitors and customers by delivering recommendations straight to their devices or mailboxes.
While they experience improved fulfillment of their needs, more engaged customers mean bigger income for the store.
The feature requires that your organization exposes an endpoint that passes data to an internal message delivery system and supports the following use cases:

- Inducing a purchase by pushing a message with cart contents or equivalents, when the customer's cart status remains unchanged for a set time.

- Inviting a customer to come back to the site by pushing a message with recommendations, when they haven't returned to the site for a set time.

- Reviving the customer's interest by pushing a message with products that are similar to the ones the customer has already seen.

- Inducing a purchase by pushing a message when a price of the product from the customer's wishlist decreases.

For more information, see [Email triggers](https://doc.ibexa.co/projects/userguide/en/master/personalization/triggers/).

#### Multiple attributes in recommendation computation

With this feature, you get an option to combine several attribute types when computing recommendations.
As a result, users can be presented with recommendations from an intersection of submodel results.

For more information, see [Submodel parameters](https://doc.ibexa.co/en/master/personalization/api_reference/recommendation_api/#submodel-parameters) and [Submodels](https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#submodels).

#### New scenario filter

Depending on a setting that you make when defining a scenario, the recommendation response can now include either product variants or base products only.
This way you can deliver more accurate recommendations and avoid showing multiple variants of the same product to the client.

For more information, see [Commerce-specific filters](https://doc.ibexa.co/projects/userguide/en/latest/personalization/filters/#commerce-specific-filters).

## Other changes

### Expression Language

New `project_dir()` expression language function that allows you to reference current project directory in YAML migration files.

### Site Factory events

Site Factory events have been moved from the `Ibexa\SiteFactory\ServiceEvent\Events` namespace to the `Ibexa\Contracts\SiteFactory\Events` namespace, keeping the backward compatibility.
For a full list of events, see [Site events](https://doc.ibexa.co/en/latest/api/event_reference/site_events/).

Event handling system was improved with the addition of listeners based on `CreateSiteEvent`, `DeleteSiteEvent`, and `UpdateSiteEvent`.
New listeners automatically grant permissions to log in to a site, providing a more seamless site management experience.

### Integration with Actito

By using the Actito gateway you can send emails to the end-users about changes in the status of various operations in your commerce presence.

### Integration with Qualifio Engage

Use Qualifio Engage integration to create engaging marketing experiences to your customers.

### Integration with SeenThis!

Unlike conventional streaming services, integration with SeenThis! service provides an adaptive streaming technology with no limitations.
It allows you to preserve the best video quality with a minimum amount of data transfer.

For more information, see [SeenThis! block](https://doc.ibexa.co/projects/userguide/en/latest/content_management/block_reference/#sales-representative).

### API improvements

#### REST API

##### REST API for shipping [[% include 'snippets/commerce_badge.md' %]]

Endpoints that allow you to manage shipping methods and shipments by using REST API:

- GET `/shipments` -  loads a list of shipments
- GET `/shipments/{identifier}` - loads a single shipment based on its identifier
- PATCH `/shipments/{identifier}` - updates a shipment
- GET `/shipping/methods` - loads shipping methods
- GET `/shipping/methods/{identifier}` - loads shipping methods based on their identifiers
- GET `/shipping/method-types` - loads shipping methods types
- GET `/shipping/method-types/{identifier}` - loads shipping methods type based on their identifiers
- GET `/orders/order/{identifier}/shipments` - loads a list of shipments.

##### REST API for company accounts [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Endpoints that allow you to manage companies in your platform with REST API:

- GET `/sales-representatives` - returns paginated list of available sales representatives

##### New method signature

A signature for the `\Ibexa\Contracts\Rest\Output\Generator::startValueElement` method has been updated to the following:

```php
    /**
     * @phpstan-param scalar $value
     * @phpstan-param array<string, scalar> $attributes
     */
    abstract public function startValueElement(string $name, $value, array $attributes = []): void;
```

Any third party code that extends `\Ibexa\Contracts\Rest\Output\Generator` needs to update the method signature accordingly.

### Helpers

A new helper method `ibexa.helpers.contentType.getContentTypeDataByHref` has been introduced to help you get Content Type data in JavaScript.

### Ibexa Connect

For a list of changes in [[= product_name_connect =]], see [Ibexa app release notes](https://doc.ibexa.co/projects/connect/en/latest/general/ibexa_app_release_notes/).

#### Scenario block

New [[= product_name_connect =]] scenario block retrieves and displays data from an [[= product_name_connect =]] webhook.
Scenario block is a regular Page block and can be configured on field definition level as any other block.
You also need to configure scenario block in the Page Builder. To do it, you need to provide name for the block, enter webhook link for the [[= product_name_connect =]] webhook and select the template to be used to present the webhook.

For more information, see [Ibexa Connect scenario block](https://doc.ibexa.co/en/master/content_management/pages/ibexa_connect_scenario_block/).

### DDEV

[Ibexa DXP can officially be run on DDEV](https://ddev.readthedocs.io/en/latest/users/quickstart/#ibexa-dxp). For more information, see the [DDEV guide](https://doc.ibexa.co/en/master/getting_started/install_with_ddev/), which offers a step-by-step walkthrough for installing Ibexa DXP.

### Customer Data Platform (CDP)

In this release, the CDP configuration allows you to automate the process of exporting data.
Users can now export not only Content, but also Users and Products data.

For more information, see [CDP Activation](https://doc.ibexa.co/en/master/cdp/cdp_activation/cdp_activation/).

## Developer experience

### Github statistics

Git events between v4.5.0 and v4.6.0

| Metric              | Value                      |
|:--------------------|:---------------------------|
| Commits             | 4668                       |
| Pull requests       | 3,413 opened (2,6k merged) |
| Reviews             | 8323                       |
| Total contributions | 16404                      |

### Code changes

Code changes between v4.5.0 and v4.6.0

| Repository                              | Files changed | Lines added | Lines removed |
|:----------------------------------------|--------------:|------------:|--------------:|
| ibexa/activity-log                      | 295           | 13438       | 157           |
| ibexa/admin-ui                          | 929           | 19264       | 6770          |
| ibexa/admin-ui-assets                   | 2             | 10          | 10            |
| ibexa/automated-translation             | 15            | 116         | 164           |
| ibexa/calendar                          | 22            | 82          | 77            |
| ibexa/cart                              | 133           | 3516        | 517           |
| ibexa/cdp                               | 81            | 4872        | 160           |
| ibexa/checkout                          | 157           | 7021        | 1012          |
| ibexa/connect                           | 42            | 2266        | 26            |
| ibexa/connector-dam                     | 15            | 111         | 59            |
| ibexa/connector-payum                   | 42            | 1627        | 141           |
| ibexa/content-forms                     | 28            | 350         | 167           |
| ibexa/content-tree                      | 19            | 248         | 127           |
| ibexa/core                              | 277           | 7119        | 1959          |
| ibexa/core-persistence                  | 41            | 3368        | 70            |
| ibexa/corporate-account                 | 176           | 1527        | 723           |
| ibexa/corporate-account-commerce-bridge | 26            | 652         | 143           |
| ibexa/cron                              | 1             |             |               |
| ibexa/dashboard                         | 221           | 11278       | 157           |
| ibexa/design-engine                     | 1             |             |               |
| ibexa/doctrine-schema                   | 3             | 155         | 1             |
| ibexa/elasticsearch                     | 24            | 726         | 34            |
| ibexa/fastly                            | 1             |             |               |
| ibexa/fieldtype-address                 | 14            | 37          | 28            |
| ibexa/fieldtype-matrix                  | 13            | 44          | 44            |
| ibexa/fieldtype-page                    | 68            | 1934        | 843           |
| ibexa/fieldtype-query                   | 6             | 24          | 16            |
| ibexa/fieldtype-richtext                | 32            | 934         | 188           |
| ibexa/form-builder                      | 88            | 146         | 183           |
| ibexa/graphql                           | 1             |             |               |
| ibexa/http-cache                        | 4             | 6           | 9             |
| ibexa/icons                             | 27            | 288         | 7             |
| ibexa/image-editor                      | 15            | 220         | 204           |
| ibexa/image-picker                      | 56            | 3144        | 3             |
| ibexa/installer                         | 26            | 935         | 46            |
| ibexa/measurement                       | 37            | 1245        | 59            |
| ibexa/migrations                        | 21            | 141         | 49            |
| ibexa/notifications                     | 44            | 1397        | 414           |
| ibexa/oauth2-client                     | 1             |             |               |
| ibexa/order-management                  | 143           | 3796        | 417           |
| ibexa/page-builder                      | 187           | 5442        | 1529          |
| ibexa/payment                           | 65            | 962         | 202           |
| ibexa/permissions                       | 3             | 16          | 16            |
| ibexa/personalization                   | 94            | 1641        | 337           |
| ibexa/post-install                      | 103           | 8           | 6240          |
| ibexa/product-catalog                   | 694           | 16031       | 3919          |
| ibexa/rest                              | 48            | 1376        | 438           |
| ibexa/scheduler                         | 78            | 294         | 224           |
| ibexa/search                            | 77            | 3821        | 82            |
| ibexa/segmentation                      | 49            | 1405        | 82            |
| ibexa/seo                               | 10            | 41          | 25            |
| ibexa/shipping                          | 281           | 9894        | 405           |
| ibexa/site-context                      | 101           | 4577        | 144           |
| ibexa/site-factory                      | 65            | 642         | 401           |
| ibexa/solr                              | 23            | 593         | 126           |
| ibexa/standard-design                   | 1             |             |               |
| ibexa/storefront                        | 125           | 4610        | 598           |
| ibexa/system-info                       | 19            | 91          | 174           |
| ibexa/taxonomy                          | 76            | 1564        | 125           |
| ibexa/tree-builder                      | 46            | 799         | 337           |
| ibexa/user                              | 56            | 310         | 249           |
| ibexa/version-comparison                | 32            | 117         | 104           |
| ibexa/workflow                          | 51            | 335         | 207           |
| Total                                   | 5431          | 146606      | 30948         |

### New packages 

The following packages has been introduced in Ibexa DXP v4.6.0:

- ibexa/oauth2-server (optional)
- ibexa/site-context
- ibexa/activity-log
- ibexa/notifications
- ibexa/dashboard
- ibexa/connector-seenthis (optional)
- ibexa/connector-actito (optional)
- ibexa/connector-qualifio (optional)
- ibexa/connector-payum
- ibexa/image-picker
- ibexa/core-persistence
- ibexa/corporate-account-commerce-bridge

!!! note

    The ibexa/content package has been renamed to ibexa/headless.

### REST APIs

Ibexa DXP v4.6.0 adds REST API coverage for the following features:

- Price engine
- Shipping
- Corporate accounts
- Activity Log
- UDW configuration (internal)

#### Endpoints list

The following endpoints have been added in 4.6.0 release (27 endpoints in total):

| Endpoint                                                               | Functions |     |     | Parameters                                                                                                          |
|-:----------------------------------------------------------------------|-:---------|-:---|-:---|-:-------------------------------------------------------------------------------------------------------------------|
| `ibexa.activity_log.rest.activity_log.list`                              | GET/POST  | ANY | ANY | `/api/ibexa/v2/activity-log/list`                                                                                     |
| `ibexa.udw.location.data`                                                | GET       | ANY | ANY | `/api/ibexa/v2/module/universal-discovery/location/{locationId}`                                                      |
| `ibexa.udw.location.gridview.data`                                       | GET       | ANY | ANY | `/api/ibexa/v2/module/universal-discovery/location/{locationId}/gridview`                                             |
| `ibexa.udw.locations.data`                                               | GET       | ANY | ANY | `/api/ibexa/v2/module/universal-discovery/locations`                                                                  |
| `ibexa.udw.accordion.data`                                               | GET       | ANY | ANY | `/api/ibexa/v2/module/universal-discovery/accordion/{locationId}`                                                     |
| `ibexa.udw.accordion.gridview.data`                                      | GET       | ANY | ANY | `/api/ibexa/v2/module/universal-discovery/accordion/{locationId}/gridview`                                            |
| `ibexa.rest.application_config`                                          | GET       | ANY | ANY | `/api/ibexa/v2/application-config`                                                                                    |
| `ibexa.cart.authorize`                                                   | POST      | ANY | ANY | `/api/ibexa/v2/cart/authorize`                                                                                        |
| `ibexa.rest.corporate_account.sales_representatives.get`                 | GET       | ANY | ANY | `/api/ibexa/v2/corporate/sales-representatives`                                                                       |
| `ibexa.product_catalog.rest.prices.create`                               | POST      | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices`                                                         |
| `ibexa.product_catalog.rest.prices.list`                                 | GET       | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices`                                                        |
| `ibexa.product_catalog.rest.prices.get.custom_price`                     | GET       | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices/{currencyCode}/customer-group/{customerGroupIdentifier}` |
| `ibexa.product_catalog.rest.prices.get.base_price`                       | GET       | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices/{currencyCode}`                                          |
| `ibexa.product_catalog.rest.prices.update`                               | PATCH     | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices/{id}`                                                    |
| `ibexa.product_catalog.rest.prices.delete`                               | DELETE    | ANY | ANY | `/api/ibexa/v2/product/catalog/products/{productCode}/prices/{id}`                                                    |
| `ibexa.product_catalog.personalization.rest.product_variant.get_by_code` | GET       | ANY | ANY | `/api/ibexa/v2/personalization/v1/product_variant/code/{code}`                                                        |
| `ibexa.product_catalog.personalization.rest.product_variant_list`        | GET       | ANY | ANY | `/api/ibexa/v2/personalization/v1/product_variant/list/{codes}`                                                      |
| `ibexa.shipping.rest.shipping_method.type.list`                          | GET       | ANY | ANY | `/api/ibexa/v2/shipping/method-types`                                                                                 |
| `ibexa.shipping.rest.shipping_method.type.get`                           | GET       | ANY | ANY | `/api/ibexa/v2/shipping/method-types/{identifier}`                                                                    |
| `ibexa.shipping.rest.shipping_method.get`                                | GET       | ANY | ANY | `/api/ibexa/v2/shipping/methods/{identifier}`                                                                         |
| `ibexa.shipping.rest.shipping_method.find`                               | GET       | ANY | ANY | `/api/ibexa/v2/shipping/methods`                                                                                      |
| `ibexa.shipping.rest.shipment.get`                                       | GET       | ANY | ANY | `/api/ibexa/v2/shipments/{shipmentIdentifier}`                                                                        |
| `ibexa.shipping.rest.shipment.delete`                                    | DELETE    | ANY | ANY | `/api/ibexa/v2/shipments/{shipmentIdentifier}`                                                                        |
| `ibexa.shipping.rest.shipment.all.find`                                  | GET       | ANY | ANY | `/api/ibexa/v2/shipments`                                                                                             |
| `ibexa.shipping.rest.shipment.order.find`                                | GET       | ANY | ANY | `/api/ibexa/v2/orders/order/{orderIdentifier}/shipments`                                                             |
| `ibexa.shipping.rest.shipment.create`                                    | POST      | ANY | ANY | `/api/ibexa/v2/orders/order/{orderIdentifier}/shipments`                                                              |
| `ibexa.shipping.rest.shipment.update`                                    | PATCH     | ANY | ANY | `/api/ibexa/v2/shipments/{shipmentIdentifier}`                                                                        |

### PHP API

- Autosave API (`\Ibexa\Contracts\AdminUi\Autosave\AutosaveServiceInterface`)
- Activity Log API
- Spellchecking API
- Site Context API (`\Ibexa\Contracts\SiteContext\SiteContextServiceInterface`)
- Dashboard API (`\Ibexa\Contracts\Dashboard\DashboardServiceInterface`)
- Price resolver API (`\Ibexa\Contracts\ProductCatalog\PriceResolverInterface`)
- Location Preview URL resolver (`\Ibexa\Contracts\SiteContext\PreviewUrlResolver\LocationPreviewUrlResolverInterface`, see [GitHub](https://github.com/ibexa/site-context/pull/25))
- ContentAware API (`\Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`)
- Sorting Definition API (`\Ibexa\Contracts\Search\SortingDefinition`)

### Search Criteria

Content

- `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentName`
- Image criteria:
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Dimensions`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\FileSize`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Height`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\MimeType`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Orientation`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Width`

Product

- `\Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\IsVirtual`
- `ProductStock` and `ProductStockRange`

### Sort Clauses

- `\Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductStock`

### Aggregations

- Aggregation API for product catalog
- Labeled ranges
- Range::INF to improve readability of unbounded ranges
- Added support for creating range aggregations from generator (see `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Ranges\RangesGeneratorInterface`) and built-in step generators:
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Ranges\DateTimeStepRangesGenerator`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Ranges\FloatStepRangesGenerator`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Ranges\IntegerStepRangesGenerator`
- Allowed direct access to aggregation keys from results
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\TermAggregationResult::getKeys`
    - `\Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResult::getKeys`

### Events

The following endpoints have been added in the v4.6.0 release (39 events in total):

- ibexa/activity-log
    - `\Ibexa\Contracts\ActivityLog\Event\PostActivityListLoadEvent`
- ibexa/admin-ui
    - `\Ibexa\Contracts\AdminUi\Event\FocusModeChangedEvent`
- ibexa/cart
    - `\Ibexa\Contracts\AdminUi\Event\FocusModeChangedEvent`
    - `\Ibexa\Contracts\Cart\Event\BeforeMergeCartsEvent`
- ibexa/core 
    - URL and name schema resolving events:
        - `\Ibexa\Contracts\Core\Event\NameSchema\ResolveUrlAliasSchemaEvent`
        - `\Ibexa\Contracts\Core\Event\NameSchema\ResolveNameSchemaEvent`
        - `\Ibexa\Contracts\Core\Event\NameSchema\ResolveContentNameSchemaEvent`
    - Tokens
        - `\Ibexa\Contracts\Core\Repository\Events\Token\BeforeRevokeTokenByIdentifierEvent`
        - `\Ibexa\Contracts\Core\Repository\Events\Token\BeforeRevokeTokenEvent`
        - `\Ibexa\Contracts\Core\Repository\Events\Token\RevokeTokenByIdentifierEvent`
        - `\Ibexa\Contracts\Core\Repository\Events\Token\RevokeTokenEvent`
- ibexa/migration
    - `\Ibexa\Contracts\Migration\Event\BeforeMigrationEvent`
    - `\Ibexa\Contracts\Migration\Event\MigrationEvent`
- ibexa/page-builder
    - `\Ibexa\Contracts\PageBuilder\Event\GenerateContentPreviewUrlEvent`
- ibexa/search:
    - `\Ibexa\Contracts\Search\Event\Service\BeforeSuggestEvent`
    - `\Ibexa\Contracts\Search\Event\Service\SuggestEvent`
- ibexa/segmentation
    - `\Ibexa\Contracts\Segmentation\Event\AssignUserToSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeAssignUserToSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeCreateSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeCreateSegmentGroupEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeRemoveSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeRemoveSegmentGroupEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeUnassignUserFromSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeUpdateSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\BeforeUpdateSegmentGroupEvent`
    - `\Ibexa\Contracts\Segmentation\Event\CreateSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\CreateSegmentGroupEvent`
    - `\Ibexa\Contracts\Segmentation\Event\RemoveSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\RemoveSegmentGroupEvent`
    - `\Ibexa\Contracts\Segmentation\Event\UnassignUserFromSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\UpdateSegmentEvent`
    - `\Ibexa\Contracts\Segmentation\Event\UpdateSegmentGroupEvent`
- ibexa/site-context
    - `\Ibexa\Contracts\SiteContext\Event\ResolveLocationPreviewUrlEvent`
- ibexa/site-factory
    - `\Ibexa\Contracts\SiteFactory\Events\BeforeCreateSiteEvent`
    - `\Ibexa\Contracts\SiteFactory\Events\BeforeDeleteSiteEvent`
    - `\Ibexa\Contracts\SiteFactory\Events\BeforeUpdateSiteEvent`
    - `\Ibexa\Contracts\SiteFactory\Events\CreateSiteEvent`
    - `\Ibexa\Contracts\SiteFactory\Events\DeleteSiteEvent`
    - `\Ibexa\Contracts\SiteFactory\Events\UpdateSiteEvent`

### Twig functions

- `ibexa_is_user_profile_available`
- `ibexa_is_focus_mode_on`
- `ibexa_is_focus_mode_off`
- `ibexa_is_pim_local`
- `ibexa_current_user`
- `ibexa_is_current_user`
- `ibexa_get_user_preference_value`
- `ibexa_has_user_preference`
- `ibexa_has_field`
- `ibexa_field_group_name`
- `ibexa_render_activity_log`
- `ibexa_render_activity_log_group`
- `ibexa_choices_as_facets`
- `ibexa_taxonomy_entries_for_content`
- `ibexa_url` / `ibexa_path` (support for content wrappers)

### View matchers

The following view matchers have been introduced in Ibexa DXP v4.6.0:

- `\Ibexa\Core\MVC\Symfony\Matcher\ContentBased\IsPreview`
- `\Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Id`
- `\Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Identifier`
- `\Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Level`
- `\Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Taxonomy`

## Full changelog

| [[= product_name_headless =]] | [[= product_name_exp =]] | [[= product_name_com =]] |
|---------------|------------------|---------------|
| [[[= product_name_headless =]] v4.6](https://github.com/ibexa/headless/releases/tag/v4.6.0) | [[[= product_name_exp =]] v4.6](https://github.com/ibexa/experience/releases/tag/v4.6.0) | [[[= product_name_com =]] v4.6](https://github.com/ibexa/commerce/releases/tag/v4.6.0) |
