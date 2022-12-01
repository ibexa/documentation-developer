---
description: Set up permission sets for common use cases.
---

# Permission use cases

Here are a few examples of sets of Policies that you can use to get some common permission configurations.

## Enter Back Office

To allow the User to enter the Back Office interface and view all content, set the following Policies:

- `user/login`
- `content/read`
- `content/versionread`
- `section/view`
- `content/reverserelatedlist`

These Policies are necessary for all other cases below that require access to the content structure.

## Create content without publishing [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can use this option together with [[= product_name_exp =]]'s content review options.
Users assigned with these Policies can create content, but cannot publish it.
To publish, they must send the content for review to another User with proper permissions 
(for example, senior editor, proofreader, etc.).

- `content/create`
- `content/edit`

Use this setup with [[= product_name_exp =]] or [[= product_name_com =]] only,
as [[= product_name_content =]] does not allow the User to continue working with their content.

## Create and publish content

To create and publish content, users must additionally have the following Policies:

- `content/create`
- `content/edit`
- `content/publish`

This also lets the user copy and move content, as well as add new Locations to a Content item (but not remove them).

## Move content

To move a Content item or a Subtree to another Location, the user must have the following Policies:

- `content/read` - on the source Location
- `content/create` - on the target Location

## Remove content

To send content to Trash, the User needs to have the `content/remove` Policy.
If content has more than one language, the User must have access to all the languages.
That is, the `content/remove` Policy must have either no Limitation, or a Limitation for all languages of the Content item.

To remove an archived version of content, the User must have the `content/versionremove` Policy.

Further manipulation of Trash requires the `content/restore` Policy to restore items from Trash, and `content/cleantrash` to completely delete all content from the Trash.

!!! caution

    With the `content/cleantrash` Policy, the User can empty the Trash even if they do not have access to the trashed content,
    for example, because it belonged to a Section that the User does not have permissions for.

## Restrict editing to part of the tree

If you want to let the User create or edit content, but only in one part of the content tree, use Limitations.
Three Limitations that you could use here are `Section` Limitation, `Location` Limitation and `Subtree of Location` Limitation.

### Section Limitation

Let's assume you have two Folders under your Home: Blog and Articles.
You can let a User create content for the blogs, but not in Articles, by adding a `Section` Limitation to 
the Blog Content item.
This allows the User to publish content anywhere under this Location in the structure.
Section does not have to belong to the same Subtree of Location in the content structure, any Locations can be assigned to it.

### Location Limitation

If you add a `Location` Limitation and point to the same Location, the User is able to publish content directly 
under the selected Location, but not anywhere deeper in its Subtree of Location.

### Subtree of Location Limitation

To limit the User's access to a subtree, use the `Subtree of Location` Limitation.
You do it by creating two new Roles for a User Group:
 
 1. Role with a `Subtree` Limitation for the User
 1. Role with a `Location` Limitation for the Subtree

Follow the example below to learn how to do that.

**Cookbook**, **Dinner recipes** and **Dessert recipes** containers are not accessible in the frontend. 
Edit access to them in the **Admin Panel**. 

![Subtree file structure](subtree_usability_notes_1.png)

To give the vegetarian editors access only to the **Vegetarian** dinner recipes section,
 create a new Role, for example, *EditorVeg*.
Next, add to it a `content/read` Policy with the `Subtree` Limitation for `Cookbook/Dinner recipes/Vegetarian`.
Assign the Role to the vegetarian editors User Group.
It allows users from that group to access the **Vegetarian** container but not **Cookbook** and **Dinner recipes**.

To give users access to **Cookbook** and **Dinner recipes** containers, 
create a new Role, for example, *EditorVegAccess*.
Next, add to it a `content/read` Policy with the `Location` Limitations **Cookbook** and **Dinner recipes**.
Assign the new Role to the vegetarian editors User Group as well.
Only then the limitations are combined with `AND`, resulting in an empty set.

The vegetarian editors should now see the following Content Tree:

![Limited subtree file structure](subtree_usability_notes_2.png)

When a Policy has more than one Limitation, all of them have to apply, or the Policy does not work.
For example, a `Location` Limitation on Location `1/2` and `Subtree of Location` Limitation on `1/2/55` cannot work together,
because no Location can satisfy both those requirements at the same time.
To combine more than one Limitation with the *or* relation, not *and*,
you can split your Policy in two, each with one of these Limitations.

## Manage Locations

To add a new Location to a Content item, the Policies required for publishing content are enough.
To allow the User to remove a Location, grant them the following Policies:

- `content/remove`
- `content/manage_locations`

Hiding and revealing Location requires one more Policy: `content/hide`.

## Editorial workflows

You can control which stages in an editorial workflow the user can work with.

Do this by adding the `WorkflowStageLimitation` to `content` Policies such as `content/edit` or `content/publish`.

You can also control which transitions the user can pass content through.
Do this by using the `workflow/change_stage` Policy together with the `WorkflowTransitionLimitation`.

For example, to enable the user to edit only content in the "Design" stage
and to pass it after creating design to the "Proofread stage", use following permissions:

- `content/edit` with `WorkflowStageLimitation` set to "Design".
- `workflow/change_stage` with `WorkflowTransitionLimitation` set to `to_proofreading`

## Multi-file upload

Creating content through multi-file upload is treated in the same way as regular creation.
To enable upload, you need you set the following permissions:

- `content/create`
- `content/read`
- `content/publish`

You can control what Content items can be uploaded and where by using Limitations
on the `content/create` and `content/publish` Policies.

A Location Limitation limits the uploading to a specific Location in the tree. 
A Content Type Limitation controls the Content Types that are allowed.
For example, you can set the Location Limitation on a **Pictures** Folder, and add a Content Type Limitation
that only allows Content items of type **Image**. 
This ensures that only files of type `image` can be uploaded,
and only to the **Pictures** Folder.

## Taxonomies

You can control which users or user groups can work with taxonomies. 
To let users create and assign taxonomy entries, set the following permissions:

- `assign` - to allow user to tag and untag content
- `read` -  to see the Taxonomy interface
- `manage` - to create, edit and delete tags

With Limitations you can configure whether permissions apply to Tags, Product categories or both.

## Register Users

To allow anonymous users to register through the `/register` route, grant the `user/register` Policy to the Anonymous User Group.

## Admin

To access the [administration panel](admin_panel.md) in the Back Office, the User must have the `setup/administrate` Policy.
This allows the User to view the languages and Content Types.

Additional Policies are needed for each section of the Admin.

### System Information

- `setup/system_info` to view the System Information tab

### Sections

- `section/view` to see and access the Section list
- `section/edit` to add and edit Sections
- `section/assign` to assign Sections to content

### Languages

- `content/translations` to add and edit languages

### Content Types/action

- `Content Type/create`, `Content Type/update`, `Content Type/delete` to add, modify and remove Content Types

### Object states

- `state/administrate` to view a list of Object states, add and edit them
- `state/assign` to assign Objects states to Content

### Roles

- `role/read` to view the list of Roles in Admin
- `role/create`, `role/update`, `role/assign` and `role/delete` to manage Roles

### Users

- `content/view` to view the list of Users

Users are treated like other content, so to create and modify them, the User needs to have the same permissions as for managing other Content items.

## Product catalog

You can control to what extend users can access the Product catalog and all its related parts.

### Product type

To create or edit product types, a user needs to have access to attributes and attribute groups. 
Set the following permissions to allow such access:

- `product_type/create`
- `product_type/view`
- `product_type/edit`

### Product item

When a product is created, a product item and a Content item are also generated. 
Permissions for the product catalog override permissions for content, therefore, 
users without permissions for content can still manage products.

- `product/create`
- `product/view`
- `product/edit`