# Policies

Policies are the main building block of the permissions system which lets you define the accesses for specific user roles.

Policies are the main building block of the permissions system. Each role you assign to user or user group consists of policies which define, which parts of the application or website the user has access to.

## Available policies

### Access to all functions

| Module | Function | Effect                                                      | Possible limitations |
| ------ | -------- | ----------------------------------------------------------- | -------------------- |
| `*`    | `*`      | all modules, all functions: grant all available permissions |                      |

> **Tip: Tip**
>
> For each module, all functions can be given without limitation. For example, `content/*` gives access to all functions of the `content` module, even future ones.

### Administration and user management

#### Activity log

| Module         | Function | Effect               | Possible Limitations                                                                                            |
| -------------- | -------- | -------------------- | --------------------------------------------------------------------------------------------------------------- |
| `activity_log` | `read`   | access activity list | [ActivityLogOwner](../limitation_reference/index.md#activity-log-owner-limitation) |

#### AI actions

| Module                 | Function  | Effect                 | Possible Limitations |
| ---------------------- | --------- | ---------------------- | -------------------- |
| `action_configuration` | `view`    | view AI Action         |                      |
|                        | `create`  | create a new AI action |                      |
|                        | `edit`    | edit an AI action      |                      |
|                        | `delete`  | delete an AI action    |                      |
|                        | `execute` | execute an AI action   |                      |

#### Customer groups

| Module           | Function | Effect                  | Possible limitations |
| ---------------- | -------- | ----------------------- | -------------------- |
| `customer_group` | `create` | create a customer group |                      |
|                  | `delete` | delete a customer group |                      |
|                  | `edit`   | edit a customer group   |                      |
|                  | `view`   | view customer groups    |                      |

#### Roles

| Module | Function | Effect                                                                     | Possible limitations |
| ------ | -------- | -------------------------------------------------------------------------- | -------------------- |
| `role` | `assign` | assign roles to users and user groups                                      |                      |
|        | `create` | create new roles                                                           |                      |
|        | `delete` | delete roles                                                               |                      |
|        | `read`   | view the roles list in Admin. Required for all other role-related policies |                      |
|        | `update` | modify existing roles                                                      |                      |

#### Setup

| Module  | Function       | Effect                                       | Possible limitations |
| ------- | -------------- | -------------------------------------------- | -------------------- |
| `setup` | `administrate` | access Admin                                 |                      |
|         | `install`      | unused                                       |                      |
|         | `setup`        | unused                                       |                      |
|         | `system_info`  | view the **System Information** tab in Admin |                      |

#### Sites (Experience, Commerce)

| Module | Function        | Effect                                                                                   | Possible limitations |
| ------ | --------------- | ---------------------------------------------------------------------------------------- | -------------------- |
| `site` | `change_status` | change status of the public accesses of sites to `Live` or `Offline` in the Site Factory |                      |
|        | `create`        | create sites in the Site Factory                                                         |                      |
|        | `delete`        | delete sites from the Site Factory                                                       |                      |
|        | `edit`          | edit sites in the Site Factory                                                           |                      |
|        | `update`        | update sites in the Site Factory                                                         |                      |
|        | `view`          | view the "Sites" in the top navigation                                                   |                      |

#### Users

| Module | Function      | Effect                                           | Possible limitations |
| ------ | ------------- | ------------------------------------------------ | -------------------- |
| `user` | `activation`  | unused                                           |                      |
|        | `invite`      | create and send invitations to create an account |                      |
|        | `login`       | log in to the application                        |                      |
|        | `password`    | unused                                           |                      |
|        | `preferences` | access and set user preferences                  |                      |
|        | `register`    | register using the `/register` route             |                      |
|        | `selfedit`    | unused                                           |                      |

### Commerce

#### Cart (Commerce)

| Module | Function | Effect                                                              | Possible limitations                                                                             |
| ------ | -------- | ------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| `cart` | `create` | create a cart                                                       | [CartOwner](../limitation_reference/index.md#cart-owner-limitation) |
|        | `delete` | delete cart, for example, after successful checkout                 | [CartOwner](../limitation_reference/index.md#cart-owner-limitation) |
|        | `edit`   | change cart metadata (name, currency, owner), add/remove cart items | [CartOwner](../limitation_reference/index.md#cart-owner-limitation) |
|        | `view`   | view a cart                                                         | [CartOwner](../limitation_reference/index.md#cart-owner-limitation) |

#### Checkout (Commerce)

| Module     | Function | Effect                                                              | Possible limitations |
| ---------- | -------- | ------------------------------------------------------------------- | -------------------- |
| `checkout` | `create` | create new checkout, for example, after workflow fails to complete  |                      |
|            | `delete` | delete checkout, for example, after workflow completes successfully |                      |
|            | `update` | change currency, quantity                                           |                      |
|            | `view`   | access checkout                                                     |                      |

#### Currencies and regions

| Module     | Function   | Effect            | Possible limitations |
| ---------- | ---------- | ----------------- | -------------------- |
| `commerce` | `currency` | manage currencies |                      |
|            | `region`   | manage regions    |                      |

#### Discounts (Commerce)

The [discount](../../discounts/discounts/index.md) policies decide which actions can be executed by given user or user group.

> **Caution: Customers and discount policies**
>
> Customers don't need any policies to use the discounts on the [storefront](../../commerce/storefront/storefront/index.md). Even the `discount/view` policy would allow them to access all the discount details, including the coupon codes to activate them, which could lead to system abuse.

| Module     | Function  | Effect                                 | Possible limitations                                                                                     |
| ---------- | --------- | -------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| `discount` | `create`  | create a discount                      | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |
|            | `update`  | modify discount parameters             | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |
|            | `view`    | view discounts (including its details) | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |
|            | `delete`  | delete a discount                      | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |
|            | `enable`  | enable a discount                      | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |
|            | `disable` | disable a discount                     | [DiscountOwner](../limitation_reference/index.md#discount-owner-limitation) |

#### Orders (Commerce)

| Module  | Function | Effect                    | Possible limitations                                                                               |
| ------- | -------- | ------------------------- | -------------------------------------------------------------------------------------------------- |
| `order` | `cancel` | cancel an order           | [OrderOwner](../limitation_reference/index.md#order-owner-limitation) |
|         | `create` | create an order           | [OrderOwner](../limitation_reference/index.md#order-owner-limitation) |
|         | `update` | change status of an order | [OrderOwner](../limitation_reference/index.md#order-owner-limitation) |
|         | `view`   | view orders               | [OrderOwner](../limitation_reference/index.md#order-owner-limitation) |

#### Payments (Commerce)

| Module    | Function | Effect           | Possible limitations                                                                                  |
| --------- | -------- | ---------------- | ----------------------------------------------------------------------------------------------------- |
| `payment` | `create` | create a payment | [PaymentOwner](../limitation_reference/index.md#paymentowner-limitation) |
|           | `delete` | delete a payment | [PaymentOwner](../limitation_reference/index.md#paymentowner-limitation) |
|           | `edit`   | modify a payment | [PaymentOwner](../limitation_reference/index.md#paymentowner-limitation) |
|           | `view`   | view payments    | [PaymentOwner](../limitation_reference/index.md#paymentowner-limitation) |

#### Payment methods (Commerce)

| Module           | Function | Effect                  | Possible limitations |
| ---------------- | -------- | ----------------------- | -------------------- |
| `payment_method` | `create` | create a payment method |                      |
|                  | `delete` | delete a payment method |                      |
|                  | `edit`   | modify a payment method |                      |
|                  | `view`   | view payment methods    |                      |

#### Segments (Commerce)

| Module    | Function         | Effect                   | Possible limitations                                                                                    |
| --------- | ---------------- | ------------------------ | ------------------------------------------------------------------------------------------------------- |
| `segment` | `assign_to_user` | assign segments to users | [Segment Group](../limitation_reference/index.md#segment-group-limitation) |
|           | `create`         | create segments          | [Segment Group](../limitation_reference/index.md#segment-group-limitation) |
|           | `read`           | load segment information | [Segment Group](../limitation_reference/index.md#segment-group-limitation) |
|           | `remove`         | remove segments          | [Segment Group](../limitation_reference/index.md#segment-group-limitation) |
|           | `update`         | update segments          | [Segment Group](../limitation_reference/index.md#segment-group-limitation) |

#### Segment groups (Commerce)

| Module          | Function | Effect                         | Possible limitations |
| --------------- | -------- | ------------------------------ | -------------------- |
| `segment_group` | `create` | create segment groups          |                      |
|                 | `read`   | load segment group information |                      |
|                 | `remove` | remove segment groups          |                      |
|                 | `update` | update segment groups          |                      |

#### Shipments (Commerce)

| Module     | Function | Effect                      | Possible limitations                                                                                     |
| ---------- | -------- | --------------------------- | -------------------------------------------------------------------------------------------------------- |
| `shipment` | `create` | create a shipment           | [ShipmentOwner](../limitation_reference/index.md#shipment-owner-limitation) |
|            | `delete` | delete a shipment           | [ShipmentOwner](../limitation_reference/index.md#shipment-owner-limitation) |
|            | `update` | change status of a shipment | [ShipmentOwner](../limitation_reference/index.md#shipment-owner-limitation) |
|            | `view`   | view shipments              | [ShipmentOwner](../limitation_reference/index.md#shipment-owner-limitation) |

#### Shipping methods (Commerce)

| Module            | Function | Effect                   | Possible limitations |
| ----------------- | -------- | ------------------------ | -------------------- |
| `shipping_method` | `create` | create a shipping method |                      |
|                   | `delete` | delete a shipping method |                      |
|                   | `update` | modify a shipping method |                      |
|                   | `view`   | view shipping methods    |                      |

#### Shopping lists (LTS Update, Commerce)

| Module          | Function | Effect                 | Possible limitations                                                                                        |
| --------------- | -------- | ---------------------- | ----------------------------------------------------------------------------------------------------------- |
| `shopping_list` | `create` | create a shopping list | [ShoppingListOwner](../limitation_reference/index.md#shopping-list-limitation) |
|                 | `delete` | delete a shopping list | [ShoppingListOwner](../limitation_reference/index.md#shopping-list-limitation) |
|                 | `edit`   | modify a shopping list | [ShoppingListOwner](../limitation_reference/index.md#shopping-list-limitation) |
|                 | `view`   | view shopping lists    | [ShoppingListOwner](../limitation_reference/index.md#shopping-list-limitation) |

### Content management

#### Content

| Module    | Function             | Effect                                                                                                                                  | Possible limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| --------- | -------------------- | --------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `content` | `cleantrash`         | empty the Trash (even when the User doesn't have access to individual content items)                                                    |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `create`             | create new content. Note: even without this policy the user is able to enter edit mode, but cannot finalize work with the content item. | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation) [Owner of Parent](../limitation_reference/index.md#owner-of-parent-limitation) [Content type Group of Parent](../limitation_reference/index.md#content-type-group-of-parent-limitation) [Content type of Parent](../limitation_reference/index.md#content-type-of-parent-limitation) [Parent Depth](../limitation_reference/index.md#parent-depth-limitation) [Field Group](../limitation_reference/index.md#field-group-limitation) [Change Owner](../limitation_reference/index.md#change-owner-limitation)                                               |
|           | `diff`               | unused                                                                                                                                  |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `edit`               | edit existing content                                                                                                                   | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation) [Object State](../limitation_reference/index.md#object-state-limitation) [Workflow Stage](../limitation_reference/index.md#workflow-stage-limitation) [Field Group](../limitation_reference/index.md#field-group-limitation) [Version Lock](../limitation_reference/index.md#version-lock-limitation) [Change Owner](../limitation_reference/index.md#change-owner-limitation) |
|           | `hide`               | hide and reveal content locations                                                                                                       | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
|           | `manage_locations`   | remove locations and send content to Trash                                                                                              | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
|           | `pendinglist`        | unused                                                                                                                                  |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `publish`            | publish content. Without this Policy, the User can only save drafts or send them for review (in Ibexa Experience)                       | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation) [Object State](../limitation_reference/index.md#object-state-limitation) [Workflow Stage](../limitation_reference/index.md#workflow-stage-limitation)                                                                                                                                                                                                                                                                                                                 |
|           | `read`               | view the content both in front and back end                                                                                             | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
|           | `remove`             | remove locations and send content to Trash                                                                                              | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation) [Language](../limitation_reference/index.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
|           | `restore`            | restore content from Trash                                                                                                              |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `reverserelatedlist` | see all content that a content item relates to (even when the User isn't allowed to view it as an individual content items)             | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
|           | `translate`          | unused                                                                                                                                  | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
|           | `translations`       | manage the language list in Admin                                                                                                       |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `unlock`             | unlock drafts locked to a user for performing actions                                                                                   | [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Language](../limitation_reference/index.md#language-limitation) [Version Lock](../limitation_reference/index.md#version-lock-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
|           | `urltranslator`      | manage URL aliases of a content item                                                                                                    |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|           | `versionread`        | view content after publishing, and to preview any content in the Site mode                                                              | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) Status [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|           | `versionremove`      | remove archived content versions                                                                                                        | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) Status [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|           | `view_embed`         | view content embedded in another content item (even when the User isn't allowed to view it as an individual content item)               | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |

#### Content collaborative editing

| Module    | Function | Effect                                                                                                                                                                                     | Possible limitations                                                                                                                                                                                                                                                                                                                                |
| --------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `content` | `share`  | share content drafts with internal and external users through [collaborative editing](../../content_management/collaborative_editing/collaborative_editing/index.md) | [Owner](../limitation_reference/index.md#collaborative-editing-owner-limitation) [PublicLink](../limitation_reference/index.md#collaborative-editing-publiclink-limitation) [Scope](../limitation_reference/index.md#collaborative-editing-scope-limitation) |
| `rte`     | `edit`   | use [Real-time editing](../../content_management/collaborative_editing/collaborative_editing_guide/index.md#real-time-editing)                                               |                                                                                                                                                                                                                                                                                                                                                     |

#### Content types

| Module  | Function | Effect                                                                   | Possible limitations |
| ------- | -------- | ------------------------------------------------------------------------ | -------------------- |
| `class` | `create` | create new content types. Also required to edit exiting content types    |                      |
|         | `delete` | delete content types                                                     |                      |
|         | `update` | modify existing content types. Also required to create new content types |                      |

#### Sections

| Module    | Function | Effect                                                                           | Possible limitations                                                                                                                                                                                                                                                                                                                                                                          |
| --------- | -------- | -------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `section` | `assign` | assign Sections to content                                                       | [content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [New Section](../limitation_reference/index.md#new-section-limitation) |
|           | `edit`   | edit existing Sections and create new ones                                       |                                                                                                                                                                                                                                                                                                                                                                                               |
|           | `view`   | view the Sections list in Admin. Required for all other section-related policies |                                                                                                                                                                                                                                                                                                                                                                                               |

#### Object States

| Module  | Function       | Effect                                | Possible limitations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| ------- | -------------- | ------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `state` | `assign`       | assign object states to content items | [Content type](../limitation_reference/index.md#content-type-limitation) [Section](../limitation_reference/index.md#section-limitation) [Owner](../limitation_reference/index.md#owner-limitation) [Content type Group](../limitation_reference/index.md#content-type-group-limitation) [Location](../limitation_reference/index.md#location-limitation) [Subtree](../limitation_reference/index.md#subtree-limitation) [Object State](../limitation_reference/index.md#object-state-limitation) [New State](../limitation_reference/index.md#new-state-limitation) |
|         | `administrate` | view, add and edit object states      |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |

#### Taxonomy

| Module     | Function | Effect                        | Possible limitations |
| ---------- | -------- | ----------------------------- | -------------------- |
| `taxonomy` | `assign` | tag or untag content          |                      |
|            | `manage` | create, edit, and delete tags |                      |
|            | `read`   | view the Taxonomy interface   |                      |

#### Workflow and version comparison

| Module       | Function       | Effect                                 | Possible limitations                                                                                                |
| ------------ | -------------- | -------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `comparison` | `view`         | view version comparison                |                                                                                                                     |
| `workflow`   | `change_stage` | change stage in the specified workflow | [Workflow Transition](../limitation_reference/index.md#workflow-transition-limitation) |

### Product catalog

#### Catalogs

| Module    | Function | Effect           | Possible limitations |
| --------- | -------- | ---------------- | -------------------- |
| `catalog` | `create` | create a catalog |                      |
|           | `delete` | delete a catalog |                      |
|           | `edit`   | edit a catalog   |                      |
|           | `view`   | view catalogs    |                      |

#### Products

| Module    | Function | Effect                                      | Possible limitations                                                                                                                                                                                |
| --------- | -------- | ------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `product` | `create` | create a product                            | [Product Type](../limitation_reference/index.md#product-type-limitation) [Language](../limitation_reference/index.md#language-limitation) |
|           | `delete` | delete a product                            | [Product Type](../limitation_reference/index.md#product-type-limitation)                                                                                               |
|           | `edit`   | edit a product                              | [Product Type](../limitation_reference/index.md#product-type-limitation) [Language](../limitation_reference/index.md#language-limitation) |
|           | `view`   | view products listed in the product catalog | [Product Type](../limitation_reference/index.md#product-type-limitation)                                                                                               |

> **Caution: Caution**
>
> The `ProductType` limitation can't be used when using [Quable](../../product_catalog/quable/quable/index.md).

#### Product collaborative editing

| Module    | Function | Effect                                                                                                                                                                               | Possible limitations                                                                                                                                                                                                                                                                                                                                |
| --------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `product` | `share`  | share products with internal and external users through [collaborative editing](../../content_management/collaborative_editing/collaborative_editing/index.md) | [Owner](../limitation_reference/index.md#collaborative-editing-owner-limitation) [PublicLink](../limitation_reference/index.md#collaborative-editing-publiclink-limitation) [Scope](../limitation_reference/index.md#collaborative-editing-scope-limitation) |

#### Product types

| Module         | Function | Effect                                                                                                           | Possible limitations                                                                                  |
| -------------- | -------- | ---------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| `product_type` | `create` | create a product type, a new attribute, a new attribute group, and add translation to product type and attribute | [Product Type](../limitation_reference/index.md#product-type-limitation) |
|                | `delete` | delete a product type, attribute, attribute group                                                                |                                                                                                       |
|                | `edit`   | edit a product type, attribute, attribute group                                                                  | [Product Type](../limitation_reference/index.md#product-type-limitation) |
|                | `view`   | view product types, attributes and attribute groups                                                              |                                                                                                       |

> **Caution: Caution**
>
> The `ProductType` limitation can't be used when using [Quable](../../product_catalog/quable/quable/index.md).

## Combining policies

Policies on one role are connected with the *and* relation, not *or*, so when policy has more than one limitation, all of them have to apply.

If you want to combine more than one limitation with the *or* relation, not *and*, you can split your policy in two, each with one of these limitations.
