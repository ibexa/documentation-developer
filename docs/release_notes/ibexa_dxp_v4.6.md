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

Ibexa Content changes name to Ibexa Headless to emphasize Ibexa's capacity for headless architecture.

The feature set and capabilities of the product remain the same.

### New features and improvements in Personalization

#### Email triggers

You can increase the engagement of your visitors and customers by delivering recommendations straight to their mailboxes. 
The feature requires that you expose an endpoint that passes data to an internal mailing system and supports the following two use cases:

- Inducing a purchase by pushing a message with cart contents or equivalents, when the customer's cart status remains unchanged for a set time.

- Inviting a visitor to come back to the site by pushing a message with recommendations, when the customer hasn't returned to the site for a set time.

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

#### Shipments

## Other changes

### 

### API improvements

#### REST API for shipping [[% include 'snippets/commerce_badge.md' %]]

This release adds new endpoints that allow you to manage orders by using REST API:

- GET `/shipments` -  loads a list of shipments
- GET `/shipments/{identifier}` - loads a single shipment based on its identifier
- PATCH `/shipments/{identifier}` - updates a shipment
- GET `/shipping/methods` - loads shipping methods
- GET `/shipping/methods/{identifier}` - loads shipping methods based on their identifiers
- GET `/shipping/method-types` - loads shipping methods types
- GET `/shipping/method-types/{identifier}` - loads shipping methods type based on their identifiers
- GET `/orders/order/{identifier}/shipments` - loads a list of shipments.

#### REST API for company accounts [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

This release adds new endpoints that allow you to manage companies in your platform with REST API:

- GET `/sales-representatives` - returns paginated list of available sales representatives

#### PHP API 

### 

### 

### Ibexa Connect

For list of changes in Ibexa Connect, see [Ibexa app release notes](https://doc.ibexa.co/projects/connect/en/latest/general/ibexa_app_release_notes/).

### DDEV

[Ibexa DXP can officially be run on DDEV](https://ddev.readthedocs.io/en/latest/users/quickstart/#ibexa-dxp). For more information, see the [DDEV guide](https://doc.ibexa.co/en/master/getting_started/install_with_ddev/), which offers a step-by-step walkthrough for installing Ibexa DXP.

### Deprecations

#### 

## Full changelog

| Ibexa Headless | Ibexa Experience | Ibexa Commerce|
|---------------|------------------|---------------|
| [Ibexa Headless v4.6](https://github.com/ibexa/headless/releases/tag/v4.6.0) | [Ibexa Experience v4.6](https://github.com/ibexa/experience/releases/tag/v4.6.0) | [Ibexa Commerce v4.6](https://github.com/ibexa/commerce/releases/tag/v4.6.0) |
