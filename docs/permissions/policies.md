---
description: Policies are the main building block of the permissions system which lets you define the accesses for specific user Roles.
page_type: reference
---

# Policies

Policies are the main building block of the permissions system.
Each Role you assign to  user or user group consists of Policies which define, which parts of the application or website the user has access to.

## Available Policies

### All

| Module | Function | Effect                                                      | Possible Limitations |
|--------|----------|-------------------------------------------------------------|----------------------|
| `*`    | `*`      | all modules, all functions: grant all available permissions |                      |

Foreach each module, all functions can be given without limitation.

### Content management

#### Content

| Module    | Function             | Effect                                                                                                                                  | Possible Limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|-----------|----------------------|-----------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `content` | `*`                  | all `content` module functions                                                                                                          |
|           | `cleantrash`         | empty the Trash (even when the User does not have access to individual Content items)                                                   |
|           | `create`             | create new content. Note: even without this Policy the User is able to enter edit mode, but cannot finalize work with the Content item. | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Owner of Parent](limitation_reference.md#owner-of-parent-limitation)</br>[Content Type Group of Parent](limitation_reference.md#content-type-group-of-parent-limitation)</br>[Content Type of Parent](limitation_reference.md#content-type-of-parent-limitation)</br>[Parent Depth](limitation_reference.md#parent-depth-limitation)</br>[Field Group](limitation_reference.md#field-group-limitation)</br>[Change Owner](limitation_reference.md#change-owner-limitation)             |
|           | `diff`               | unused                                                                                                                                  |
|           | `edit`               | edit existing content                                                                                                                   | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Workflow Stage](limitation_reference.md#workflow-stage-limitation)</br>[Field Group](limitation_reference.md#field-group-limitation)</br>[Version Lock](limitation_reference.md#version-lock-limitation)</br>[Change Owner](limitation_reference.md#change-owner-limitation) |
|           | `hide`               | hide and reveal content Locations                                                                                                       | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                       |
|           | `manage_locations`   | remove Locations and send content to Trash                                                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
|           | `pendinglist`        | unused                                                                                                                                  |
|           | `publish`            | publish content. Without this Policy, the User can only save drafts or send them for review (in [[= product_name_exp =]])               | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Workflow Stage](limitation_reference.md#workflow-stage-limitation)                                                                                                                                                                                                           |
|           | `read`               | view the content both in front and back end                                                                                             | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                               |
|           | `remove`             | remove Locations and send content to Trash                                                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                   |
|           | `restore`            | restore content from Trash                                                                                                              |
|           | `reverserelatedlist` | see all content that a Content item relates to (even when the User is not allowed to view it as an individual Content items)            | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
|           | `translate`          | unused                                                                                                                                  | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                       |
|           | `translations`       | manage the language list in Admin                                                                                                       |
|           | `unlock`             | unlock drafts locked to a user for performing actions                                                                                   | [Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Version Lock](limitation_reference.md#version-lock-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
|           | `urltranslator`      | manage URL aliases of a Content item                                                                                                    |
|           | `versionread`        | view content after publishing, and to preview any content in the Site mode                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>Status</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                    |
|           | `versionremove`      | remove archived content versions                                                                                                        | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>Status</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                    |
|           | `view_embed`         | view content embedded in another Content item (even when the User is not allowed to view it as an individual Content item)              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |

#### Content Types

| Module  | Function | Effect                                                                   | Possible Limitations |
|---------|----------|--------------------------------------------------------------------------|----------------------|
| `class` | `*`      | all Content Types function                                               |
|         | `create` | create new Content Types. Also required to edit exiting Content Types    |
|         | `delete` | delete Content Types                                                     |
|         | `update` | modify existing Content Types. Also required to create new Content Types |

#### Sections

| Module    | Function | Effect                                                                           | Possible Limitations                                                                                                                                                                                                                              |
|-----------|----------|----------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `section` | `*`      | all section functions                                                            |                                                                                                                                                                                                                                                   |
|           | `assign` | assign Sections to content                                                       | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[New Section](limitation_reference.md#new-section-limitation) |
|           | `edit`   | edit existing Sections and create new ones                                       |
|           | `view`   | view the Sections list in Admin. Required for all other section-related Policies |

#### Object States

| Module  | Function       | Effect                                | Possible Limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|---------|----------------|---------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `state` | `*`            | all object state functions            |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
|         | `assign`       | assign Object states to Content items | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[New State](limitation_reference.md#new-state-limitation) |
|         | `administrate` | view, add and edit Object states      |

#### Taxonomy

| Module     | Function | Effect                        | Possible Limitations |
|------------|----------|-------------------------------|----------------------|
| `taxonomy` | `*`      | all taxonomy functions        |
|            | `assign` | tag or untag content          |
|            | `manage` | create, edit, and delete tags |
|            | `read`   | view the Taxonomy interface   |

#### Workflow and version comparison

| Module       | Function       | Effect                                 | Possible Limitations                                                          |
|--------------|----------------|----------------------------------------|-------------------------------------------------------------------------------|
| `comparison` | `view`         | view version comparison                |
| `workflow`   | `change_stage` | change stage in the specified workflow | [Workflow Transition](limitation_reference.md#workflow-transition-limitation) |

### Administration and user management

#### Customer groups

| Module           | Function | Effect                        | Possible Limitations |
|------------------|----------|-------------------------------|----------------------|
| `customer_group` | `*`      | all customer group functions  |
|                  | `create` | create a customer group       |
|                  | `delete` | delete a customer group       |
|                  | `edit`   | edit a customer group         |
|                  | `view`   | view customer groups          |

#### Personalization

| Module            | Function | Effect                                                            | Possible Limitations                                                                |
|-------------------|----------|-------------------------------------------------------------------|-------------------------------------------------------------------------------------|
| `personalization` | `*`      | all personalization functions                                     |                                                                                     |
|                   | `edit`   | modify scenario configuration for selected SiteAccesses           | [Personalization access](limitation_reference.md#personalization-access-limitation) |
|                   | `view`   | view scenario configuration and results for selected SiteAccesses | [Personalization access](limitation_reference.md#personalization-access-limitation) |

#### Roles

| Module | Function | Effect                                                                     | Possible Limitations |
|--------|----------|----------------------------------------------------------------------------|----------------------|
| `role` | `*`      | all Roles functions                                                        |
|        | `assign` | assign Roles to Users and User Groups                                      |
|        | `create` | create new Roles                                                           |
|        | `delete` | delete Roles                                                               |
|        | `read`   | view the Roles list in Admin. Required for all other role-related Policies |
|        | `update` | modify existing Roles                                                      |

#### Setup

| Module  | Function       | Effect                                   | Possible Limitations |
|---------|----------------|------------------------------------------|----------------------|
| `setup` | `*`            | all setup functions                      |
|         | `administrate` | access Admin                             |
|         | `install`      | unused                                   |
|         | `setup`        | unused                                   |
|         | `system_info`  | view the System Information tab in Admin |

#### Sites [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

| Module | Function        | Effect                                                                                   | Possible Limitations |
|--------|-----------------|------------------------------------------------------------------------------------------|----------------------|
| `site` | `*`             | all sites functions                                                                      |
|        | `change_status` | change status of the public accesses of sites to `Live` or `Offline` in the Site Factory |
|        | `create`        | create sites in the Site Factory                                                         |
|        | `delete`        | delete sites from the Site Factory                                                       |
|        | `edit`          | edit sites in the Site Factory                                                           |
|        | `update`        | update sites in the Site Factory                                                         |
|        | `view`          | view the "Sites" in the top navigation                                                   |

#### Users

| Module | Function      | Effect                                           | Possible Limitations |
|--------|---------------|--------------------------------------------------|----------------------|
| `user` | `*`           | all user functions                               |
|        | `activation`  | unused                                           |
|        | `invite`      | create and send invitations to create an account |
|        | `login`       | log in to the application                        |
|        | `password`    | unused                                           |
|        | `preferences` | access and set user preferences                  |
|        | `register`    | register using the `/register` route             |
|        | `selfedit`    | unused                                           |

### PIM

#### Catalogs

| Module    | Function | Effect                | Possible Limitations |
|-----------|----------|-----------------------|----------------------|
| `catalog` | `*`      | all catalog functions |
|           | `create` | create a catalog      |
|           | `delete` | delete a catalog      |
|           | `edit`   | edit a catalog        |
|           | `view`   | view catalogs         |

#### Products

| Module    | Function | Effect                                      | Possible Limitations                                                                                                        |
|-----------|----------|---------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
| `product` | `*`      | all product functions                       |                                                                                                                             |
|           | `create` | create a product                            | [Product Type](limitation_reference.md#product-type-limitation)</br>[Language](limitation_reference.md#language-limitation) |
|           | `delete` | delete a product                            | [Product Type](limitation_reference.md#product-type-limitation)                                                             |
|           | `edit`   | edit a product                              | [Product Type](limitation_reference.md#product-type-limitation)</br>[Language](limitation_reference.md#language-limitation) |
|           | `view`   | view products listed in the product catalog | [Product Type](limitation_reference.md#product-type-limitation)                                                             |

#### Product types

| Module         | Function | Effect                                                                                                          | Possible Limitations |
|----------------|----------|-----------------------------------------------------------------------------------------------------------------|----------------------|
| `product_type` | `*`      | all product type functions                                                                                      |
|                | `create` | create a product type, a new attribute, a new attribute group and add translation to product type and attribute |
|                | `delete` | delete a product type, attribute, attribute group                                                               |
|                | `edit`   | edit a product type, attribute, attribute group                                                                 |
|                | `view`   | view product types, attributes and attribute groups                                                             |

### Commerce

#### Cart [[% include 'snippets/commerce_badge.md' %]]

| Module | Function | Effect                                                              | Possible Limitations                                      |
|--------|----------|---------------------------------------------------------------------|-----------------------------------------------------------|
| `cart` | `*`      | all cart functions                                                  |  |
|        | `create` | create a cart                                                       | [CartOwner](limitation_reference.md#cartowner-limitation) |
|        | `delete` | delete cart, for example, after successful checkout                 | [CartOwner](limitation_reference.md#cartowner-limitation) |
|        | `edit`   | change cart metadata (name, currency, owner), add/remove cart items | [CartOwner](limitation_reference.md#cartowner-limitation) |
|        | `view`   | view a cart                                                         | [CartOwner](limitation_reference.md#cartowner-limitation) |

#### Checkout [[% include 'snippets/commerce_badge.md' %]]

| Module     | Function | Effect                                                              | Possible Limitations |
|------------|----------|---------------------------------------------------------------------|----------------------|
| `checkout` | `*`      | all checkout functions                                              |
|            | `create` | create new checkout, for example, after workflow fails to complete  |
|            | `delete` | delete checkout, for example, after workflow completes successfully |
|            | `update` | change currency, quantity                                           |
|            | `view`   | access checkout                                                     |

#### Currencies and regions

| Module     | Function   | Effect                 | Possible Limitations |
|------------|------------|------------------------|----------------------|
| `commerce` | `*`        | All commerce functions |
|            | `currency` | manage currencies      |
|            | `region`   | manage regions         |

#### Orders [[% include 'snippets/commerce_badge.md' %]]

| Module  | Function | Effect                    | Possible Limitations                                         |
|---------|----------|---------------------------|--------------------------------------------------------------|
| `order` | `*`      | all order functions       |                                                              |
|         | `cancel` | cancel an order           | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|         | `create` | create an order           | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|         | `update` | change status of an order | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|         | `view`   | view orders               | [OrderOwner](limitation_reference.md#order-owner-limitation) |

#### Payments [[% include 'snippets/commerce_badge.md' %]]

| Module    | Function | Effect                | Possible Limitations                                            |
|-----------|----------|-----------------------|-----------------------------------------------------------------|
| `payment` | `*`      | all payment functions |                                                                 |
|           | `create` | create a payment      | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|           | `delete` | delete a payment      | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|           | `edit`   | modify a payment      | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|           | `view`   | view payments         | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |

#### Payment methods [[% include 'snippets/commerce_badge.md' %]]

| Module           | Function | Effect                       | Possible Limitations |
|------------------|----------|------------------------------|----------------------|
| `payment_method` | `*`      | all payment method functions |
|                  | `create` | create a payment method      |
|                  | `delete` | delete a payment method      |
|                  | `edit`   | modify a payment method      |
|                  | `view`   | view payment methods         |

#### Segments [[% include 'snippets/commerce_badge.md' %]]

| Module    | Function         | Effect                   | Possible Limitations                                              |
|-----------|------------------|--------------------------|-------------------------------------------------------------------|
| `segment` | `*`              | all Segment functions    |                                                                   |
|           | `assign_to_user` | assign Segments to Users | [Segment Group](limitation_reference.md#segment-group-limitation) |
|           | `create`         | create Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |
|           | `read`           | load Segment information | [Segment Group](limitation_reference.md#segment-group-limitation) |
|           | `remove`         | remove Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |
|           | `update`         | update Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |

#### Segment groups [[% include 'snippets/commerce_badge.md' %]]

| Module          | Function | Effect                         | Possible Limitations |
|-----------------|----------|--------------------------------|----------------------|
| `segment_group` | `*`      | all Segment Group functions    |
|                 | `create` | create Segment Groups          |
|                 | `read`   | load Segment Group information |
|                 | `remove` | remove Segment Groups          |
|                 | `update` | update Segment Groups          |


#### Shipments [[% include 'snippets/commerce_badge.md' %]]

| Module     | Function | Effect                      | Possible Limitations                                               |
|------------|----------|-----------------------------|--------------------------------------------------------------------|
| `shipment` | `*`      | all shipment functions      |                                                                    |
|            | `create` | create a shipment           | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|            | `delete` | delete a shipment           | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|            | `update` | change status of a shipment | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|            | `view`   | view shipments              | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |

#### Shipping methods [[% include 'snippets/commerce_badge.md' %]]

| Module            | Function | Effect                        | Possible Limitations |
|-------------------|----------|-------------------------------|----------------------|
| `shipping_method` | `*`      | all shipping method functions |
|                   | `create` | create a shipping method      |
|                   | `delete` | delete a shipping method      |
|                   | `update` | modify a shipping method      |
|                   | `view`   | view shipping methods         |

## Combining Policies

Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply.

If you want to combine more than one Limitation with the *or* relation, not *and*,
you can split your Policy in two, each with one of these Limitations.
