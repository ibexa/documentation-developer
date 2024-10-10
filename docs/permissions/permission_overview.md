---
description: The permission system is based on policies that you assign to users or user groups in the form of roles.
---

# Permission overview

A new User does not have permissions for any part of the system, unless they're explicitly given access.
To get access they need to inherit roles, typically assigned to the user group they belong to.

Each role can contain one or more **Policies**. A policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` Policy allows the User to assign content to Sections.

When you add a policy to a role, you can also restrict it using one or more **Limitations**.
A policy with a limitation only applies when the condition in the limitation is fulfilled.
For example, a `content/publish` policy with a `ContentType` limitation on the "Blog Post" content type allows the User to publish only Blog Posts, and not other content.

A limitation, like a policy, specifies what a User *can* do, not what they *can't do*.
A `Section` limitation, for example, *gives* the User access to the selected Section, not *prohibits* it.

See [Limitation reference](limitation_reference.md) for further information
and [Permission use cases](permission_use_cases.md) for example permission setups.

## Assigning roles to users

Every user or user group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

it's best practice to avoid assigning roles to users directly.
Instead, try to organize your content so that it can be covered with general roles assigned to user groups.

Using Groups is easier to manage and more secure. It also improves system performance.
The more role assignments and complex policies you add for a given User, the more complex the search/load queries are, because they always take permissions into account.

## Permissions for custom controllers

You can control access to a custom controller by implementing the `performAccessCheck()` method.

In the following example the user does not have access to the controller unless they have the `section/view` policy:

``` php
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;

public function performAccessCheck(): void
{
    parent::performAccessCheck();
    $this->denyAccessUnlessGranted(new Attribute('section', 'view'));
}
```

`Attribute` accepts three arguments:

- `module` is the policy module (e.g. `content`)
- `function` is the function inside the module (e.g. `read`)
- `limitations` are optional limitations to check against. Here you can provide two keys:
    - `valueObject` is the object you want to check for, for example `ContentInfo`.
    - `targets` are a table of value objects that are the target of the operation.
    For example, to check if content can be assigned to a Section, provide the Section as `targets`.
    `targets` accept Location, Object state and Section objects.

### Checking user access

To check if a user has access to an operation, use the `isGranted()` method.
For example, to check if content can be assigned to a Section:

``` php
$hasAccess = $this->isGranted(
    new Attribute('section', 'assign', ['valueObject' => $contentInfo, 'targets' => [$section]])
);
```

You can also use the permission resolver (`Ibexa\Core\Repository\Permission\PermissionResolver`).
The `canUser()` method checks if the user can perform a given action with the selected object.

For example: `canUser('content', 'edit', $content, [$location] );`
checks the `content/edit` permission for the provided content item at the provided Location.

### Blocking access to controller action

To block access to a specific action of the controller, add the following to the action's definition:

``` php
$this->denyAccessUnlessGranted(new Attribute('state', 'administrate'));
```
