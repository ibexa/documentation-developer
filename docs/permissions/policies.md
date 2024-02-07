---
description: Policies are the main building block of the permissions system which lets you define the accesses for specific user Roles.
page_type: reference
---

# Policies

Policies are the main building block of the permissions system.
Each Role you assign to user or user group consists of Policies
which define, which parts of the application or website the user has access to.

## Available Policies

### Access to all functions

| Module | Function | Effect                                                      | Possible Limitations |
|--------|----------|-------------------------------------------------------------|----------------------|
| `*`    | `*`      | all modules, all functions: grant all available permissions |                      |

!!! tip

    For each module, all functions can be given without limitation.
    For example, `content/*` gives access to all functions of the `content` module, even future ones.

### Content management

#### Content

| Module                 | Function                          | Effect                                                                                                                                  | Possible Limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|------------------------|-----------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <nobr>`content`</nobr> | <nobr>`cleantrash`</nobr>         | empty the Trash (even when the User does not have access to individual Content items)                                                   |
|                        | <nobr>`create`</nobr>             | create new content. Note: even without this Policy the User is able to enter edit mode, but cannot finalize work with the Content item. | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Owner of Parent](limitation_reference.md#owner-of-parent-limitation)</br>[Content Type Group of Parent](limitation_reference.md#content-type-group-of-parent-limitation)</br>[Content Type of Parent](limitation_reference.md#content-type-of-parent-limitation)</br>[Parent Depth](limitation_reference.md#parent-depth-limitation)</br>[Field Group](limitation_reference.md#field-group-limitation)</br>[Change Owner](limitation_reference.md#change-owner-limitation)             |
|                        | <nobr>`diff`</nobr>               | unused                                                                                                                                  |
|                        | <nobr>`edit`</nobr>               | edit existing content                                                                                                                   | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Workflow Stage](limitation_reference.md#workflow-stage-limitation)</br>[Field Group](limitation_reference.md#field-group-limitation)</br>[Version Lock](limitation_reference.md#version-lock-limitation)</br>[Change Owner](limitation_reference.md#change-owner-limitation) |
|                        | <nobr>`hide`</nobr>               | hide and reveal content Locations                                                                                                       | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                       |
|                        | <nobr>`manage_locations`</nobr>   | remove Locations and send content to Trash                                                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
|                        | <nobr>`pendinglist`</nobr>        | unused                                                                                                                                  |
|                        | <nobr>`publish`</nobr>            | publish content. Without this Policy, the User can only save drafts or send them for review (in [[= product_name_exp =]])               | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Workflow Stage](limitation_reference.md#workflow-stage-limitation)                                                                                                                                                                                                           |
|                        | <nobr>`read`</nobr>               | view the content both in front and back end                                                                                             | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                               |
|                        | <nobr>`remove`</nobr>             | remove Locations and send content to Trash                                                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                   |
|                        | <nobr>`restore`</nobr>            | restore content from Trash                                                                                                              |
|                        | <nobr>`reverserelatedlist`</nobr> | see all content that a Content item relates to (even when the User is not allowed to view it as an individual Content items)            | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
|                        | <nobr>`translate`</nobr>          | unused                                                                                                                                  | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                       |
|                        | <nobr>`translations`</nobr>       | manage the language list in Admin                                                                                                       |
|                        | <nobr>`unlock`</nobr>             | unlock drafts locked to a user for performing actions                                                                                   | [Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Language](limitation_reference.md#language-limitation)</br>[Version Lock](limitation_reference.md#version-lock-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
|                        | <nobr>`urltranslator`</nobr>      | manage URL aliases of a Content item                                                                                                    |
|                        | <nobr>`versionread`</nobr>        | view content after publishing, and to preview any content in the Site mode                                                              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>Status</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                    |
|                        | <nobr>`versionremove`</nobr>      | remove archived content versions                                                                                                        | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>Status</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                    |
|                        | <nobr>`view_embed`</nobr>         | view content embedded in another Content item (even when the User is not allowed to view it as an individual Content item)              | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |

#### Content Types

| Module               | Function              | Effect                                                                   | Possible Limitations |
|----------------------|-----------------------|--------------------------------------------------------------------------|----------------------|
| <nobr>`class`</nobr> | <nobr>`create`</nobr> | create new Content Types. Also required to edit exiting Content Types    |
|                      | <nobr>`delete`</nobr> | delete Content Types                                                     |
|                      | <nobr>`update`</nobr> | modify existing Content Types. Also required to create new Content Types |

#### Sections

| Module                 | Function              | Effect                                                                           | Possible Limitations                                                                                                                                                                                                                              |
|------------------------|-----------------------|----------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <nobr>`section`</nobr> | <nobr>`assign`</nobr> | assign Sections to content                                                       | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[New Section](limitation_reference.md#new-section-limitation) |
|                        | <nobr>`edit`</nobr>   | edit existing Sections and create new ones                                       |
|                        | <nobr>`view`</nobr>   | view the Sections list in Admin. Required for all other section-related Policies |

#### Object States

| Module               | Function                    | Effect                                | Possible Limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|----------------------|-----------------------------|---------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <nobr>`state`</nobr> | <nobr>`assign`</nobr>       | assign Object states to Content items | [Content Type](limitation_reference.md#content-type-limitation)</br>[Section](limitation_reference.md#section-limitation)</br>[Owner](limitation_reference.md#owner-limitation)</br>[Content Type Group](limitation_reference.md#content-type-group-limitation)</br>[Location](limitation_reference.md#location-limitation)</br>[Subtree](limitation_reference.md#subtree-limitation)</br>[Object State](limitation_reference.md#object-state-limitation)</br>[New State](limitation_reference.md#new-state-limitation) |
|                      | <nobr>`administrate`</nobr> | view, add and edit Object states      |

#### Taxonomy

| Module                  | Function              | Effect                        | Possible Limitations |
|-------------------------|-----------------------|-------------------------------|----------------------|
| <nobr>`taxonomy`</nobr> | <nobr>`assign`</nobr> | tag or untag content          |
|                         | <nobr>`manage`</nobr> | create, edit, and delete tags |
|                         | <nobr>`read`</nobr>   | view the Taxonomy interface   |

#### Workflow and version comparison

| Module                    | Function                    | Effect                                 | Possible Limitations                                                          |
|---------------------------|-----------------------------|----------------------------------------|-------------------------------------------------------------------------------|
| <nobr>`comparison`</nobr> | <nobr>`view`</nobr>         | view version comparison                |
| <nobr>`workflow`</nobr>   | <nobr>`change_stage`</nobr> | change stage in the specified workflow | [Workflow Transition](limitation_reference.md#workflow-transition-limitation) |

### Administration and user management

#### Customer groups

| Module                        | Function              | Effect                  | Possible Limitations |
|-------------------------------|-----------------------|-------------------------|----------------------|
| <nobr>`customer_group`</nobr> | <nobr>`create`</nobr> | create a customer group |
|                               | <nobr>`delete`</nobr> | delete a customer group |
|                               | <nobr>`edit`</nobr>   | edit a customer group   |
|                               | <nobr>`view`</nobr>   | view customer groups    |

#### Personalization

| Module                         | Function            | Effect                                                            | Possible Limitations                                                                |
|--------------------------------|---------------------|-------------------------------------------------------------------|-------------------------------------------------------------------------------------|
| <nobr>`personalization`</nobr> | <nobr>`edit`</nobr> | modify scenario configuration for selected SiteAccesses           | [Personalization access](limitation_reference.md#personalization-access-limitation) |
|                                | <nobr>`view`</nobr> | view scenario configuration and results for selected SiteAccesses | [Personalization access](limitation_reference.md#personalization-access-limitation) |

#### Roles

| Module              | Function              | Effect                                                                     | Possible Limitations |
|---------------------|-----------------------|----------------------------------------------------------------------------|----------------------|
| <nobr>`role`</nobr> | <nobr>`assign`</nobr> | assign Roles to Users and User Groups                                      |
|                     | <nobr>`create`</nobr> | create new Roles                                                           |
|                     | <nobr>`delete`</nobr> | delete Roles                                                               |
|                     | <nobr>`read`</nobr>   | view the Roles list in Admin. Required for all other role-related Policies |
|                     | <nobr>`update`</nobr> | modify existing Roles                                                      |

#### Setup

| Module               | Function                    | Effect                                   | Possible Limitations |
|----------------------|-----------------------------|------------------------------------------|----------------------|
| <nobr>`setup`</nobr> | <nobr>`administrate`</nobr> | access Admin                             |
|                      | <nobr>`install`</nobr>      | unused                                   |
|                      | <nobr>`setup`</nobr>        | unused                                   |
|                      | <nobr>`system_info`</nobr>  | view the System Information tab in Admin |

#### Sites [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

| Module              | Function                     | Effect                                                                                                | Possible Limitations |
|---------------------|------------------------------|-------------------------------------------------------------------------------------------------------|----------------------|
| <nobr>`site`</nobr> | <nobr>`change_status`</nobr> | change status of the public accesses of sites to <nobr>`Live` or `Offline`</nobr> in the Site Factory |
|                     | <nobr>`create`</nobr>        | create sites in the Site Factory                                                                      |
|                     | <nobr>`delete`</nobr>        | delete sites from the Site Factory                                                                    |
|                     | <nobr>`edit`</nobr>          | edit sites in the Site Factory                                                                        |
|                     | <nobr>`update`</nobr>        | update sites in the Site Factory                                                                      |
|                     | <nobr>`view`</nobr>          | view the "Sites" in the top navigation                                                                |

#### Users

| Module              | Function                   | Effect                                            | Possible Limitations |
|---------------------|----------------------------|---------------------------------------------------|----------------------|
| <nobr>`user`</nobr> | <nobr>`activation`</nobr>  | unused                                            |
|                     | <nobr>`invite`</nobr>      | create and send invitations to create an account  |
|                     | <nobr>`login`</nobr>       | log in to the application                         |
|                     | <nobr>`password`</nobr>    | unused                                            |
|                     | <nobr>`preferences`</nobr> | access and set user preferences                   |
|                     | <nobr>`register`</nobr>    | register using the <nobr>`/register`</nobr> route |
|                     | <nobr>`selfedit`</nobr>    | unused                                            |

### PIM

#### Catalogs

| Module                 | Function              | Effect           | Possible Limitations |
|------------------------|-----------------------|------------------|----------------------|
| <nobr>`catalog`</nobr> | <nobr>`create`</nobr> | create a catalog |
|                        | <nobr>`delete`</nobr> | delete a catalog |
|                        | <nobr>`edit`</nobr>   | edit a catalog   |
|                        | <nobr>`view`</nobr>   | view catalogs    |

#### Products

| Module                 | Function              | Effect                                      | Possible Limitations                                                                                                        |
|------------------------|-----------------------|---------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
| <nobr>`product`</nobr> | <nobr>`create`</nobr> | create a product                            | [Product Type](limitation_reference.md#product-type-limitation)</br>[Language](limitation_reference.md#language-limitation) |
|                        | <nobr>`delete`</nobr> | delete a product                            | [Product Type](limitation_reference.md#product-type-limitation)                                                             |
|                        | <nobr>`edit`</nobr>   | edit a product                              | [Product Type](limitation_reference.md#product-type-limitation)</br>[Language](limitation_reference.md#language-limitation) |
|                        | <nobr>`view`</nobr>   | view products listed in the product catalog | [Product Type](limitation_reference.md#product-type-limitation)                                                             |

#### Product types

| Module                      | Function              | Effect                                                                                                          | Possible Limitations |
|-----------------------------|-----------------------|-----------------------------------------------------------------------------------------------------------------|----------------------|
| <nobr>`product_type`</nobr> | <nobr>`create`</nobr> | create a product type, a new attribute, a new attribute group and add translation to product type and attribute |
|                             | <nobr>`delete`</nobr> | delete a product type, attribute, attribute group                                                               |
|                             | <nobr>`edit`</nobr>   | edit a product type, attribute, attribute group                                                                 |
|                             | <nobr>`view`</nobr>   | view product types, attributes and attribute groups                                                             |

### Commerce

#### Cart [[% include 'snippets/commerce_badge.md' %]]

| Module              | Function              | Effect                                                              | Possible Limitations                                      |
|---------------------|-----------------------|---------------------------------------------------------------------|-----------------------------------------------------------|
| <nobr>`cart`</nobr> | <nobr>`create`</nobr> | create a cart                                                       | [CartOwner](limitation_reference.md#cartowner-limitation) |
|                     | <nobr>`delete`</nobr> | delete cart, for example, after successful checkout                 | [CartOwner](limitation_reference.md#cartowner-limitation) |
|                     | <nobr>`edit`</nobr>   | change cart metadata (name, currency, owner), add/remove cart items | [CartOwner](limitation_reference.md#cartowner-limitation) |
|                     | <nobr>`view`</nobr>   | view a cart                                                         | [CartOwner](limitation_reference.md#cartowner-limitation) |

#### Checkout [[% include 'snippets/commerce_badge.md' %]]

| Module                  | Function              | Effect                                                              | Possible Limitations |
|-------------------------|-----------------------|---------------------------------------------------------------------|----------------------|
| <nobr>`checkout`</nobr> | <nobr>`create`</nobr> | create new checkout, for example, after workflow fails to complete  |
|                         | <nobr>`delete`</nobr> | delete checkout, for example, after workflow completes successfully |
|                         | <nobr>`update`</nobr> | change currency, quantity                                           |
|                         | <nobr>`view`</nobr>   | access checkout                                                     |

#### Currencies and regions

| Module                  | Function                | Effect            | Possible Limitations |
|-------------------------|-------------------------|-------------------|----------------------|
| <nobr>`commerce`</nobr> | <nobr>`currency`</nobr> | manage currencies |
|                         | <nobr>`region`</nobr>   | manage regions    |

#### Orders [[% include 'snippets/commerce_badge.md' %]]

| Module               | Function              | Effect                    | Possible Limitations                                         |
|----------------------|-----------------------|---------------------------|--------------------------------------------------------------|
| <nobr>`order`</nobr> | <nobr>`cancel`</nobr> | cancel an order           | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|                      | <nobr>`create`</nobr> | create an order           | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|                      | <nobr>`update`</nobr> | change status of an order | [OrderOwner](limitation_reference.md#order-owner-limitation) |
|                      | <nobr>`view`</nobr>   | view orders               | [OrderOwner](limitation_reference.md#order-owner-limitation) |

#### Payments [[% include 'snippets/commerce_badge.md' %]]

| Module                 | Function              | Effect           | Possible Limitations                                            |
|------------------------|-----------------------|------------------|-----------------------------------------------------------------|
| <nobr>`payment`</nobr> | <nobr>`create`</nobr> | create a payment | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|                        | <nobr>`delete`</nobr> | delete a payment | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|                        | <nobr>`edit`</nobr>   | modify a payment | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |
|                        | <nobr>`view`</nobr>   | view payments    | [PaymentOwner](limitation_reference.md#paymentowner-limitation) |

#### Payment methods [[% include 'snippets/commerce_badge.md' %]]

| Module                        | Function              | Effect                  | Possible Limitations |
|-------------------------------|-----------------------|-------------------------|----------------------|
| <nobr>`payment_method`</nobr> | <nobr>`create`</nobr> | create a payment method |
|                               | <nobr>`delete`</nobr> | delete a payment method |
|                               | <nobr>`edit`</nobr>   | modify a payment method |
|                               | <nobr>`view`</nobr>   | view payment methods    |

#### Segments [[% include 'snippets/commerce_badge.md' %]]

| Module                 | Function                      | Effect                   | Possible Limitations                                              |
|------------------------|-------------------------------|--------------------------|-------------------------------------------------------------------|
| <nobr>`segment`</nobr> | <nobr>`assign_to_user`</nobr> | assign Segments to Users | [Segment Group](limitation_reference.md#segment-group-limitation) |
|                        | <nobr>`create`</nobr>         | create Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |
|                        | <nobr>`read`</nobr>           | load Segment information | [Segment Group](limitation_reference.md#segment-group-limitation) |
|                        | <nobr>`remove`</nobr>         | remove Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |
|                        | <nobr>`update`</nobr>         | update Segments          | [Segment Group](limitation_reference.md#segment-group-limitation) |

#### Segment groups [[% include 'snippets/commerce_badge.md' %]]

| Module                       | Function              | Effect                         | Possible Limitations |
|------------------------------|-----------------------|--------------------------------|----------------------|
| <nobr>`segment_group`</nobr> | <nobr>`create`</nobr> | create Segment Groups          |
|                              | <nobr>`read`</nobr>   | load Segment Group information |
|                              | <nobr>`remove`</nobr> | remove Segment Groups          |
|                              | <nobr>`update`</nobr> | update Segment Groups          |

#### Shipments [[% include 'snippets/commerce_badge.md' %]]

| Module                  | Function              | Effect                      | Possible Limitations                                               |
|-------------------------|-----------------------|-----------------------------|--------------------------------------------------------------------|
| <nobr>`shipment`</nobr> | <nobr>`create`</nobr> | create a shipment           | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|                         | <nobr>`delete`</nobr> | delete a shipment           | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|                         | <nobr>`update`</nobr> | change status of a shipment | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |
|                         | <nobr>`view`</nobr>   | view shipments              | [ShipmentOwner](limitation_reference.md#shipment-owner-limitation) |

#### Shipping methods [[% include 'snippets/commerce_badge.md' %]]

| Module                         | Function              | Effect                   | Possible Limitations |
|--------------------------------|-----------------------|--------------------------|----------------------|
| <nobr>`shipping_method`</nobr> | <nobr>`create`</nobr> | create a shipping method |
|                                | <nobr>`delete`</nobr> | delete a shipping method |
|                                | <nobr>`update`</nobr> | modify a shipping method |
|                                | <nobr>`view`</nobr>   | view shipping methods    |

## Combining Policies

Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply.

If you want to combine more than one Limitation with the *or* relation, not *and*,
you can split your Policy in two, each with one of these Limitations.
