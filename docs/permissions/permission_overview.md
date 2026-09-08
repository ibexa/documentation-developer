---
description: The permission system is based on policies that you assign to users or user groups in the form of roles.
---

# Permission overview

A new user doesn't have permissions for any part of the system, unless they're explicitly given access.
To get access they need to inherit roles, typically assigned to the user group they belong to.

Each role can contain one or more **Policies**.
A policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` policy allows the user to assign content to sections.

When you add a policy to a role, you can also restrict it using one or more **Limitations**.
A policy with a limitation only applies when the condition in the limitation is fulfilled.
For example, a `content/publish` policy with a `ContentType` limitation on the "Blog Post" content type allows the user to publish only Blog Posts, and not other content.

A limitation, like a policy, specifies what a user *can* do, not what they *can't do*.
A `Section` limitation, for example, *gives* the user access to the selected section, not *prohibits* it.

For more information, see [Limitation reference](limitation_reference.md) and [Permission use cases](permission_use_cases.md).

## Assigning roles to users

Every user or user group can have many roles.
A user can also belong to many groups, for example, Administrators, Editors, Subscribers.

It's best practice to avoid assigning roles to users directly.
Instead, try to organize your content so that it can be covered with general roles assigned to user groups.

Using groups is easier to manage and more secure.
It also improves system performance.
The more role assignments and complex policies you add for a given user, the more complex the search/load queries are, because they always take permissions into account.
