---
description: Ibexa DXP Back Office contains managements options for permissions, users, languages, Content Types, as well as system information.
---

# Admin panel

Once you set up your environment you can start your work as an administrator.
Your most useful tools can be found in **Admin Panel**.

![Admin Panel](admin_panel.png "Admin Panel")

## System Information

The System Information panel in the Back Office is sourced in a [ibexa/support-tools repository](https://github.com/ibexa/support-tools).
There you will also find basic system information such as versions of all installed packages.

![System Information](admin_panel_system_info.png "System Information")

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

## Users

Users in [[= product_name =]] are treated the same way as Content items.
They are organized in groups such as *Guests*, *Editors*, *Anonymous*, which makes it easier to manage them and their permissions.
All User Groups and Users can be accessed in the Admin panel by selecting Users.

![Users and User Groups](admin_panel_users.png "Users and User Groups")

!!! caution

    Be careful not to delete an existing User account. If you do this, content created by this User will be broken and the application can face malfunction.

### Registering users

Registration form for your website is placed under this address: <yourdomain>/register.
By default, new Users created in this way are placed in the Guest accounts group.
To give your users a possibility to register themselves, follow the instructions 
on [enabling account registration](8_enable_account_registration.md).

## Roles

To give users an access to your website you need to assign them Roles in the Admin Panel.

![Roles](admin_panel_roles.png "Roles")

Each Role consists of:

**Policies**

![Policies](admin_panel_policies.png "Policies")

Rules that give users access to different function in a module.
You can restrict what user can do with Limitations.
The available Limitations depend on the chosen Policy.
When Policy has more than one Limitation, all of them have to apply.
See [example use case](permission_use_cases.md#restrict-editing-to-part-of-the-tree).

!!! note

    Limitation specifies what a User can do, not what they can't do.
    A `Location` Limitation, for example, gives the User access to content with a specific Location, not prohibits it. See [Available Limitations](limitations.md#available-limitations) for further information.

**Assignments**

![Assignments](admin_panel_assignments.png "Assignments")

After you created all Policies, you can assign the Role to Users and/or User Groups with possible additional Limitations.
Every User or User Group can have multiple Roles.
A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning Roles to Users directly.
Model your content (Content Types, Sections, Locations etc.) in a way that can be accessed by generic Roles.
That way system will be more secure and easier to manage.
This approach also improves performance. Role assignments and Policies are taken into account during search/load queries.

See [Permissions overview](permissions.md) for further information
and [Permission use cases](permission_use_cases.md) for details on how to customize access to different parts of the Back Office.

## Languages

[[= product_name =]] offers the ability to create multiple translations of your website.
Which version is shown to a visitor depends on the way your installation is set up.
A new language version for the website can be added in the Admin Panel in the Languages tab.
Every new language must have a name and a language code, written in the `xxx-XX` format, for example `eng-GB` etc.

![Languages](admin_panel_languages.png "Languages")

The multilanguage system operates based on a global translation list that contains all languages available in the installation.
After adding a language you may have to reload the application to be able to use it.
Depending on your set up, additional configuration may be necessary for the new language to work properly, especially with SiteAccesses.

See [Languages](languages.md) for further information.

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

## Segments [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can use Segments to display specific content to specific Users.
They are used out of the box in the Targeting and Dynamic targeting blocks in the Page.

Segments are collected in Segment Groups:

![](admin_panel_segment_groups.png)

Each Segment Group can contain Segments that you can target content for.

![](admin_panel_segment.png)

You can assign Users to Segments [through the API](segment_api.md#assigning-users).
