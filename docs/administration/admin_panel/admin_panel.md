---
description: Ibexa DXP Back Office contains managements options for permissions, users, languages, Content Types, as well as system information.
---

# Admin panel

Once you set up your environment you can start your work as an administrator.
Your most useful tools can be found in **Admin Panel**.

[[= cards([
    "administration/admin_panel/users_admin_panel",
    "administration/admin_panel/roles_admin_panel",
    "administration/admin_panel/url_management_admin_panel",
    "administration/admin_panel/languages_admin_panel",
    "administration/admin_panel/segments_admin_panel",
    "administration/admin_panel/corporate_admin_panel",
    "administration/admin_panel/workflow_admin_panel",
    "administration/admin_panel/system_information_admin_panel",                
], columns=4) =]]

![Admin Panel](admin_panel.png "Admin Panel")

## Sections

Sections are used to divide Content items in the tree into groups that are more easily manageable by content editors.
Division into Sections allows you, among others, to set permissions for only a part of the tree.

![Sections screen](admin_panel_sections.png "Sections screen")

Technically, a Section is a number, a name and an identifier.
Content items are placed in Sections by being assigned the Section ID. One item can be in only one Section.

When a new Content item is created, its Section ID is set to the default Section (which is usually Standard).
When the item is published it is assigned to the same Section as its parent. Because content must always be in a Section, unassigning happens by choosing a different Section to move it into.
If a Content item has multiple Location assignments then it is always the Section ID of the item referenced by the parent of the main Location that will be used.
In addition, if the main Location of a Content item with multiple Location assignments is changed then the Section ID of that item will be updated.

When content is moved to a different Location, the item itself and all of its subtree will be assigned to the Section of the new Location.
Note that it works only for copy and move; assigning a new Section to a parent Content item does not affect the subtree, meaning that subtree cannot currently be updated this way.

Sections can only be removed if no Content items are assigned to them. Even then, it should be done carefully.
When a Section is deleted, it is only its definition itself that will be removed.
Other references to the Section will remain and thus the system will most likely lose consistency.

!!! caution

    Removing Sections may corrupt permission settings, template output and other things in the system.

Section ID numbers are not recycled. If a Section is removed, its ID number will not be reused when a new Section is created.

### Registering users

Registration form for your website is placed under this address: <yourdomain>/register.
By default, new Users created in this way are placed in the Guest accounts group.
To give your users a possibility to register themselves, follow the instructions 
on [enabling account registration](8_enable_account_registration.md).

## Content Types

A Content Type is a base for new Content items.
It defines what Fields will be available in the Content item.

![Content Types](admin_panel_content_types.png "Content Types")

For example, a new Content Type called *Article* can have Fields such as title, author, body, image, etc.
Based on this Content Type, you can create any number of Content items.
Content Types are organized into groups.

![Content Type groups](admin_panel_content_type_groups.png "Content Type groups")

You can add your own groups here to keep your Content Types in better order.

For a full tutorial, see [Create a Content Type](first_steps.md#create-a-content-type) or follow [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/organizing_the_site/#content-types).
For a detailed overview of the content model, see [Content model overview](content_model.md).

## Object States

Object states are user-defined states that can be assigned to Content items.
They are contained in groups.

![Object State group](admin_panel_object_state_groups.png "Object State group")

If a state group contains any states, each Content item is automatically assigned a state from this group.

You can assign states to content in the Back Office in the Content item's Details tab.

![Assigning an Object state to a Content item](assigning_an_object_state.png "Assigning an Object state to a Content item")

By default, [[= product_name =]] contains one Object state group: **Lock**, with states **Locked** and **Not locked**.

![**Lock** Object state](object_state_lock.png "Lock Object state")

Object states can be used in conjunction with permissions, in particular with the [State Limitation](limitation_reference.md#state-limitation).
Their specific use cases depend on your needs and the setup of your permission system.