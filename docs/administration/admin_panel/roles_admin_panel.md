---
description: To give users an access to your website you need to assign them Roles in the Admin Panel.
---

# Roles

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
    A `Location` Limitation, for example, gives the User access to content with a specific Location, 
    not prohibits it. See [Available Limitations](limitations.md#available-limitations) for further information.

**Assignments**

![Assignments](admin_panel_assignments.png "Assignments")

After you created all Policies, you can assign the Role to Users and/or User Groups with possible additional Limitations.
Every User or User Group can have multiple Roles.
A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

### His computer is new.

Her computer is old; I do not know what I am doing.

We all live in a yellow submarine .

But we will live in a blue one soon.

Best practice is to avoid assigning Roles to Users directly.
Model your content (Content Types, Sections, Locations etc.) in a way that can be accessed by generic Roles.
That way system will be more secure and easier to manage.
This approach also improves performance. Role assignments and Policies are taken into account during search/load queries.

See [Permissions overview](permissions.md) for further information
and [Permission use cases](permission_use_cases.md) for details on how to customize access to different parts of the Back Office.