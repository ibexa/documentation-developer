<!-- vale VariablesVersion = NO -->
---
description: Ibexa DXP v4.6 brings improvements to Commerce, PIM and Personalization offerings, and a number of changes in CDP and Ibexa Connect.
---

# Ibexa DXP v4.6

**Version number**: v4.6

**Release date**: July 20, 2023

**Release type**: [LTS](https://support.ibexa.co/Public/service-life)

**Update**: [v4.5.x to v4.6](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/)

## Notable changes

### Ibexa Headless

[[= product_name_content =]] changes name to [[= product_name_headless =]] to emphasize [[= product_name_base =]]'s capacity for headless architecture.

The feature set and capabilities of the product remain the same.

### User interface improvements

Several improvements to the Back Office interface enhance the user experience.

#### Simplified user actions

Button text now precisely describes actions, so that users who create or edit content understand the purpose of each button.

![Improved button text](img/4.6_publishing_options.png)

#### Draft section added to Content

For streamlining purpose, the **Draft** section is now situated under **Content**.
Users can now easily find and manage their drafts and published content from one area.

![Draft section added to Content](img/4.6_drafts.png)

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

For more information, see [Email triggers](https://doc.ibexa.co/projects/userguide/en/4.5/personalization/triggers.md).

#### Multiple attributes in recommendation computation

With this feature, you get an option to combine several attribute types when computing recommendations.
As a result, users can be presented with recommendations from an intersection of submodel results.

For more information, see [Submodel parameters](recommendation_api.md#submodel-parameters) and [Submodels]https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#submodels).

#### New scenario filter

Depending on a setting that you make when defining a scenario, the recommendation response can now include either product variants or base products only.
This way you can deliver more accurate recommendations and avoid showing multiple variants of the same product to the client.

For more information, see [Commerce-specific filters](https://doc.ibexa.co/projects/userguide/en/latest/personalization/filters/#commerce-specific-filters).

###  New features and improvements in Commerce [[% include 'snippets/commerce_badge.md' %]]

#### Reorder

With the new Reorder feature, customers can effortlessly repurchase previously bought items
directly from their order history with a single click, eliminating the need for manual item selection.
The system streamlines the process by recreating the cart, retrieving shipping information, and pre-filling payment details from past orders.
This feature is exclusively accessible to logged-in users, ensuring a secure and personalized shopping experience.

For more information, see [reorder documentation](TODO add link).

#### Orders block

Orders block displays a list of orders associated with a specific company or an individual customer.
This block allows customization of the number of orders shown, sorting order, and placement on the page.

For more information, see [Orders block documentation](https://doc.ibexa.co/projects/userguide/en/master/content_management/block_reference/#orders-block).

#### Quick order

The quick order form allows users to streamlines the process of placing orders
with multiple items in bulk directly from the storefront.
Customers don't need to look for products,
they can fill in a provided form with products' SKU number and quantity,
or upload their own list directly into the system.
Quick order form is available to both registered and guest users.

For more information, see [Quick order documentation](https://doc.ibexa.co/en/master/commerce/cart/quick_order/).

#### Shipping management

Shipping management allows you to work with the shipments: view and modify their status, filter shipments in shipment lists and check all the details.
You can access shipments for your own orders or all the shipments that exist in the system, depending on your permissions.

For more information, see [Work with shipments](https://doc.ibexa.co/projects/userguide/en/master/commerce/shipping_management/work_with_shipments/).

#### Owner criterion

Orders and shipments search now supports user reference:

- `OwnerCriterion` Criterion searches for orders based on the user reference.
- `Owner` Criterion searches for shipments based on the user reference.

#### Customize checkout workflow

You can create a PHP definition of the new strategy that allows for workflow manipulation.
Defining strategy allows to add conditional steps for workflow if needed.
When a conditional step is added, the checkout process uses the specified workflow and proceeds to the defined step.

For more information, see (https://doc.ibexa.co/en/master/commerce/checkout/customize_checkout/#create-custom-strategy)

#### Adding context data to cart

Attach context data to both the Cart and its individual Cart Entries.
This feature enhances the flexibility and customization of your e-commerce application,
enabling you to associate additional information with your cart and its contents.
By leveraging context data, such as promo codes or custom texts,
you can tailor the e-commerce experience for your customers and enhance the capabilities of your application.

### New features and improvements in PIM

#### Virtual products

With this feature, you can create virtual products - non-tangible items such as memberships, services, warranties.
To create a virtual product, first, you have to create a virtual product type.
Virtual products don’t require shipment when they are purchased without other physical products.

For more information, see [Create virtual products](https://doc.ibexa.co/projects/userguide/en/master/pim/create_virtual_product/.)

#### IsVirtual Criterion

Product search now supports product virutal and physical product type:

- `IsVirtual` - searches for virtual or physical products.

#### Product page URLs

When you are creating a new product type, you can set up a product URL alias name pattern.
With this feature, you can also create custom URL and URL alias name pattern field based on product attributes.
Customized URLs are easier to remember, help with SEO optimization and reduce bounce rates on the website.

For more information, see [Product page URLs](https://doc.ibexa.co/projects/userguide/en/master/pim/work_with_product_page_urls/).

#### Updated VAT configuration

VAT rates configuration has been extended to accept additional flags under the `extras` key. You can use them, for example, to pass additional information to the UI, or define special exclusion rules.

For more information, see [VAT rates](https://doc.ibexa.co/en/master/pim/pim_configuration/#vat-rates).

#### VAT assignment moved to a new place

Users who are creating or editing a product type are less likely to forget about setting VAT rates, because they now have a more prominent place.

![Assigning VAT rates to a product type](img/4.6_catalog_vat_rates.png)

For more information, see [Create product types](https://doc.ibexa.co/projects/userguide/en/master/pim/create_product_types/).

## Other changes

### Expression Language

New `project_dir()` expression language function that allows you to reference current project directory.

### Site Factory events

Site Factory events have been moved from the `lib` directory to `contracts`.
For a full list of events, see [Site events](https://doc.ibexa.co/en/latest/api/event_reference/site_events/).

Event handling system was improved with the addition of listeners based on `CreateSiteEvent`, `DeleteSiteEvent`, and `UpdateSiteEvent`.
New listeners automatically grant permissions to log in to a site, providing a more seamless site management experience.

### API improvements

#### REST API for shipping [[% include 'snippets/commerce_badge.md' %]]

Endpoints that allow you to manage orders by using REST API:

- GET `/shipments` -  loads a list of shipments
- GET `/shipments/{identifier}` - loads a single shipment based on its identifier
- PATCH `/shipments/{identifier}` - updates a shipment
- GET `/shipping/methods` - loads shipping methods
- GET `/shipping/methods/{identifier}` - loads shipping methods based on their identifiers
- GET `/shipping/method-types` - loads shipping methods types
- GET `/shipping/method-types/{identifier}` - loads shipping methods type based on their identifiers
- GET `/orders/order/{identifier}/shipments` - loads a list of shipments.

#### REST API for company accounts [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Endpoints that allow you to manage companies in your platform with REST API:

- GET `/sales-representatives` - returns paginated list of available sales representatives

#### PHP API


### Ibexa Connect

For a list of changes in [[= product_name_connect =]], see [Ibexa app release notes](https://doc.ibexa.co/projects/connect/en/latest/general/ibexa_app_release_notes/).

#### Scenario block

New [[= product_name_connect =]] scenario block retrieves and displays data from an [[= product_name_connect =]] webhook.
Scenario block is a regular Page block and can be configured on field definition level as any other block.
You also need to configure scenario block in the Page Builder. To do it, you need to provide name for the block, enter webhook link for the [[= product_name_connect =]] webhook and select the template to be used to present the webhook.

For more information, see [Ibexa Connect scenario block](https://doc.ibexa.co/en/master/content_management/pages/ibexa_connect_scenario_block/).

### DDEV

[Ibexa DXP can officially be run on DDEV](https://ddev.readthedocs.io/en/latest/users/quickstart/#ibexa-dxp). For more information, see the [DDEV guide](https://doc.ibexa.co/en/master/getting_started/install_with_ddev/), which offers a step-by-step walkthrough for installing Ibexa DXP.

### Deprecations

####

## Full changelog

| Ibexa Headless | Ibexa Experience | Ibexa Commerce|
|---------------|------------------|---------------|
| [Ibexa Headless v4.6](https://github.com/ibexa/headless/releases/tag/v4.6.0) | [Ibexa Experience v4.6](https://github.com/ibexa/experience/releases/tag/v4.6.0) | [Ibexa Commerce v4.6](https://github.com/ibexa/commerce/releases/tag/v4.6.0) |
