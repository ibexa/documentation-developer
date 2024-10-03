---
description: To give users an access to your website you need to assign them roles in the Admin Panel.
---

# Roles

To give users an access to your website you need to assign them roles in the Admin Panel.

![Roles](admin_panel_roles.png "Roles")

Each role consists of:

**Policies**

![Policies](admin_panel_policies.png "Policies")

Rules that give users access to different function in a module.
You can restrict what user can do with limitations.
The available limitations depend on the chosen policy.
When policy has more than one limitation, all of them have to apply.
See [example use case](permission_use_cases.md#restrict-editing-to-part-of-the-tree).

!!! note

    Limitation specifies what a user can do, not what they can't do.
    A `Location` limitation, for example, gives the user access to content with a specific Location, 
    not prohibits it. See [Limitation reference](limitation_reference.md) for further information.

**Assignments**

![Assignments](admin_panel_assignments.png "Assignments")

After you created all policies, you can assign the role to users and/or user groups with possible additional limitations.
Every user or user group can have multiple roles.
A user can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning roles to users directly.
Model your content (content types, Sections, Locations etc.) in a way that can be accessed by generic roles.
That way system will be more secure and easier to manage.
This approach also improves performance. Role assignments and policies are taken into account during search/load queries.

See [Permissions overview](permissions.md) for further information
and [Permission use cases](permission_use_cases.md) for details on how to customize access to different parts of the back office.