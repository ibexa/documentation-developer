---
description: Set up permission sets for common use cases.
---

# Permission use cases

Here are a few examples of sets of policies that you can use to get some common permission configurations.

## Enter back office

To allow the user to enter the back office interface and view all content, set the following policies:

- `user/login`
- `content/read`
- `content/versionread`
- `section/view`
- `content/reverserelatedlist`

These policies are necessary for all other cases below that require access to the content structure.

## Create content without publishing [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can use this option together with [[= product_name_exp =]]'s content review options.
Users assigned with these policies can create content, but cannot publish it.
To publish, they must send the content for review to another User with proper permissions (for example, senior editor or proofreader).

- `content/create`
- `content/edit`

Use this setup with [[= product_name_exp =]] or [[= product_name_com =]] only, as [[= product_name_headless =]] doesn't allow the User to continue working with their content.

## Create and publish content

To create and publish content, users must additionally have the following policies:

- `content/create`
- `content/edit`
- `content/publish`

This also lets the user copy and move content, and add new locations to a content item (but not remove them).

## Move content

To move a content item or a subtree to another location, the user must have the following policies:

- `content/read` - on the source location
- `content/create` - on the target location

## Remove content

To send content to Trash, the user needs to have the `content/remove` policy.
If content has more than one language, the user must have access to all the languages.
That is, the `content/remove` policy must have either no limitation, or a limitation for all languages of the content item.

To remove an archived version of content, the user must have the `content/versionremove` policy.

Further manipulation of Trash requires the `content/restore` policy to restore items from Trash, and `content/cleantrash` to completely delete all content from the Trash.

!!! caution

    With the `content/cleantrash` policy, the user can empty the Trash even if they don't have access to the trashed content, for example, because it belonged to a Section that the user doesn't have permissions for.

## Restrict editing to part of the tree

If you want to let the User create or edit content, but only in one part of the content tree, use limitations.
Three limitations that you could use here are `Section` limitation, `Location` limitation and `Subtree of Location` limitation.

### Section limitation

Let's assume you have two Folders under your Home: Blog and Articles.
You can let a user create content for the blogs, but not in Articles, by adding a `Section` limitation to the Blog content item.
This allows the User to publish content anywhere under this location in the structure.
Section doesn't have to belong to the same subtree of location in the content structure, any locations can be assigned to it.

### Location limitation

If you add a `Location` limitation and point to the same location, the user is able to publish content directly under the selected location, but not anywhere deeper in its subtree of location.

### Subtree of location limitation

To limit the user's access to a subtree, use the `Subtree of Location` limitation.
You do it by creating two new roles for a user group:

 1. Role with a `Subtree` limitation for the User
 1. Role with a `Location` limitation for the subtree

Follow the example below to learn how to do that.

**Cookbook**, **Dinner recipes** and **Dessert recipes** containers aren't accessible in the frontend.
Edit access to them in the **Admin** panel.

![Subtree file structure](subtree_usability_notes_1.png)

To give the vegetarian editors access only to the **Vegetarian** dinner recipes section, create a new role, for example, *EditorVeg*.
Next, add to it a `content/read` policy with the `Subtree` limitation for `Cookbook/Dinner recipes/Vegetarian`.
Assign the role to the vegetarian editors user group.
It allows users from that group to access the **Vegetarian** container but not **Cookbook** and **Dinner recipes**.

To give users access to **Cookbook** and **Dinner recipes** containers, create a new role, for example, *EditorVegAccess*.
Next, add to it a `content/read` policy with the `Location` limitations **Cookbook** and **Dinner recipes**.
Assign the new role to the vegetarian editors user group as well.
Only then the limitations are combined with `AND`, resulting in an empty set.

The vegetarian editors should now see the following content tree:

![Limited subtree file structure](subtree_usability_notes_2.png)

When a policy has more than one limitation, all of them have to apply, or the policy doesn't work.
For example, a `Location` limitation on location `1/2` and `Subtree of Location` limitation on `1/2/55` cannot work together, because no location can satisfy both those requirements at the same time.
To combine more than one limitation with the *or* relation, not *and*, you can split your policy in two, each with one of these limitations.

## Manage locations

To add a new location to a content item, the policies required for publishing content are enough.
To allow the user to remove a location, grant them the following policies:

- `content/remove`
- `content/manage_locations`

Hiding and revealing location requires one more policy: `content/hide`.

## Editorial workflows

You can control which stages in an editorial workflow the user can work with.

Do this by adding the `WorkflowStageLimitation` to `content` policies such as `content/edit` or `content/publish`.

You can also control which transitions the user can pass content through.
Do this by using the `workflow/change_stage` policy together with the `WorkflowTransitionLimitation`.

For example, to enable the user to edit only content in the "Design" stage and to pass it after creating design to the "Proofread stage", use following permissions:

- `content/edit` with `WorkflowStageLimitation` set to "Design".
- `workflow/change_stage` with `WorkflowTransitionLimitation` set to `to_proofreading`

## Multi-file upload

Creating content through multi-file upload is treated in the same way as regular creation.
To enable upload, you need you set the following permissions:

- `content/create`
- `content/read`
- `content/publish`

You can control what content items can be uploaded and where by using imitations on the `content/create` and `content/publish` policies.

A location limitation limits the uploading to a specific location in the tree.
A content type limitation controls the content types that are allowed.
For example, you can set the location limitation on a **Pictures** Folder, and add a content type limitation that only allows content items of type **Image**.
This ensures that only files of type `image` can be uploaded, and only to the **Pictures** Folder.

## Taxonomies

You can control which users or user groups can work with taxonomies.
To let users create and assign taxonomy entries, set the following permissions:

- `taxonomy/assign` to allow user to tag and untag content
- `taxonomy/read` to see the Taxonomy interface
- `taxonomy/manage` to create, edit and delete tags

With limitations, you can configure whether permissions apply to Tags, product categories, or both.

## Register users

To allow anonymous users to register through the `/register` route, grant the `user/register` policy to the Anonymous user group.

## Admin

To access the [administration panel](admin_panel.md) in the back office, the User must have the `setup/administrate` policy.
This allows the User to view the languages and content types.

Additional policies are needed for each section of the Admin.

### System Information

- `setup/system_info` to view the System Information tab

### Sections

- `section/view` to see and access the section list
- `section/edit` to add and edit sections
- `section/assign` to assign sections to content

### Languages

- `content/translations` to add and edit languages

### Content types/action

- `content type/create`, `content type/update`, `content type/delete` to add, modify and remove content types

### Object states

- `state/administrate` to view a list of object states, add and edit them
- `state/assign` to assign Objects states to content

### Roles

- `role/read` to view the list of roles in Admin
- `role/create`, `role/update`, `role/assign` and `role/delete` to manage roles

### Users

- `content/view` to view the list of users

Users are treated like other content, so to create and modify them, the user needs to have the same permissions as for managing other content items.

## Product catalog

You can control to what extend users can access the product catalog and all its related parts.

### Product type

To create or edit product types, a user needs to have access to attributes and attribute groups.
Set the following permissions to allow such access:

- `product_type/create`
- `product_type/view`
- `product_type/edit`

### Product item

When a product is created, a product item and a content item are also generated.
Permissions for the product catalog override permissions for content, therefore, users without permissions for content can still manage products.

- `product/create`
- `product/view`
- `product/edit`

## Commerce [[% include 'snippets/commerce_badge.md' %]]

To control which commerce functionalities are available to store users, you can grant or prevent them access to individual components.

Out of the box, [[= product_name_com =]] comes with the *Storefront User* role that is assigned to anonymous users and grants them the following permissions:

- `product/view`, `product_type/view` and `catalog/view`, to allow them to view a product list and product details
- `cart/view`, `cart/create` and `cart/edit` with the `CartOwner` limitation set to `self`, to allow them to add items to their own shopping cart, modify their cart, and delete it
- `checkout/view`, `checkout/create`, `checkout/update` and `checkout/delete`, to allow them to proceed to checkout and interact with the checkout process

You can modify the default roles by preventing anonymous users from being able to proceed with the checkout process, and creating the *Registered Buyer* role that enables logged-in users to purchase products.

You could do this by moving permissions that relate to checkout from the *Storefront User* role to the *Registered Buyer* role, and granting *Registered Buyer* with the `user/register` and `user/login` permissions which control access to registration and login.

See below for a detailed listing of permissions that apply to Commerce, together with their meaning.

!!! note "Owner limitation"

    For anonymous users, orders, shipments, and/or payments are saved with a 'null' user reference.
    Therefore, when you apply the `Owner/self` limitation to any of the permissions below, anonymous users aren't allowed to interact with any of these entities.

### Cart

Set the following permissions to decide what actions are available when users interact with carts:

- `cart/view` - to allow user to view their cart
- `cart/delete` - to delete cart, for example, after successful checkout
- `cart/create` - to create a new cart
- `cart/edit` - to allow user to add products to their cart

To further control access to a cart, you can use the `CartOwner` limitation and set its value to `self`
This way users can only interact with their own carts.

### Checkout

Set the following permissions to decide what actions are available when users interact with checkout:

- `checkout/view` - to control user access to checkout
- `checkout/create` - to allow starting the checkout process, by proceeding from cart
- `checkout/update` - to allow users to modify existing information, for example item quantity
- `checkout/delete` - to delete checkout

### Discount management

Set the following permissions to decide what actions are available when users interact with discounts:

- `discount/create` - to allow the user to create a new discount
- `discount/update` - to allow the user to change the parameters of an existing discount
- `discount/view` - to allow the user to view discounts
- `discount/delete` - to delete an existing discount
- `discount/enable` - to allow the user to enable an existing discount
- `discount/disable` - to allow the user to disable an existing discount

To further control access to a discount, you can use the `DiscountOwner` limitation and set its value to `self`.
This way users can only interact with their own discounts.

### Order management

Set the following permissions to decide what actions are available when users interact with orders:

- `order/create` - to allow the user to create a new order
- `order/view` - to allow the user to view orders
- `order/update` - to allow the user to change status of an existing order
- `order/cancel` - to allow the user to cancel an existing order

To further control access to an order, you can use the `OrderOwner` limitation and set its value to `self`.
This way users can only interact with their own orders.

### Shipping management

Set the following permissions to decide what actions are available when users interact with shipping methods and shipments.

#### Shipping methods

- `shipping_method/create` - to allow the user to create a new shipping method
- `shipping_method/view` - to allow the user to view shipping methods
- `shipping_method/edit` - to allow the user to modify an existing shipping method
- `shipping_method/delete` - to allow the user to delete an existing shipping method

#### Shipments

- `shipment/create` - to allow the user to create a new shipment
- `shipment/view` - to allow the user to view shipments
- `shipment/update` - to allow the user to change status of an existing shipment
- `shipment/delete` - to allow the user to cancel an existing shipment

To further control access to a shipment, you can use the `ShipmentOwner` limitation and set its value to `self`.
This way users can only interact with their own shipments.

### Payment management

Set the following permissions to decide what actions are available when users interact with payment methods and payments.

#### Payment methods

- `payment_method/create` - to allow the user to create a new payment method
- `payment_method/view` - to allow the user to view payment methods
- `payment_method/edit` - to allow the user to modify an existing payment method
- `payment_method/delete` - to allow the user to delete an existing payment method

#### Payments

- `payment/create` - to allow the user to create a new payment
- `payment/view` - to allow the user to view payments
- `payment/edit` - to allow the user to modify an existing payment
- `payment/delete` - to allow the user to delete an existing payment

To further control access to a payment, you can use the `PaymentOwner` limitation and set its value to `self`.
This way users can only interact with their own payments.
