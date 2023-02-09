---
description: The permission system is based on Policies that you assign to users or user groups in the form of Roles.
---

# Permission overview

A new User does not have permissions for any part of the system, unless they are explicitly given access.
To get access they need to inherit Roles, typically assigned to the User Group they belong to.

Each Role can contain one or more **Policies**. A Policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` Policy allows the User to assign content to Sections.

When you add a Policy to a Role, you can also restrict it using one or more **Limitations**.
A Policy with a Limitation will only apply when the condition in the Limitation is fulfilled.
For example, a `content/publish` Policy with a `ContentType` Limitation on the "Blog Post" Content Type will allow the User to publish only Blog Posts, and not other content.

A Limitation, like a Policy, specifies what a User *can* do, not what they *can't do*.
A `Section` Limitation, for example, *gives* the User access to the selected Section, not *prohibits* it.

See [Available Limitations](limitations.md#available-limitations) for further information
and [Permission use cases](permission_use_cases.md) for example permission setups.

## Assigning Roles to Users

Every User or User Group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

It is best practice to avoid assigning Roles to users directly.
Instead, try to organize your content so that it can be covered with general Roles assigned to User Groups.

Using Groups is easier to manage and more secure. It also improves system performance.
The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries will be, because they always take permissions into account.

## Permissions for routes

You can limit access to specific routes per Policy:

``` yaml
ibexa_commerce_quick_order:
    path: /quickorder
    defaults:
        _controller: Ibexa\Bundle\Commerce\QuickOrder\Controller\QuickOrderController::quickOrderAction
        policy: siso_policy/quickorder
```

This configuration can be used to check whether a user has a single Policy.
If you need more complex rules, e.g. to check the Section or check multiple Policies at once,
implement a permission check in the controller.

## Permissions for custom controllers

You can control access to a custom controller by implementing the `performAccessCheck()` method.

In the following example the user does not have access to the controller unless they have the `section/view` Policy:

``` php
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;

public function performAccessCheck(): void
{
    parent:performAccessCheck();
    $this->denyAccessUnlessGranted(new Attribute('section', 'view'));
}
```

`Attribute` accepts three arguments:

- `module` is the Policy module (e.g. `content`)
- `function` is the function inside the module (e.g. `read`)
- `limitations` are optional Limitations to check against. Here you can provide two keys:
    - `valueObject` is the object you want to check for, for example `ContentInfo`.
    - `targets` are a table of value objects that are the target of the operation.
    For example, to check if content can be assigned to a Section, provide the Section as `targets`.
    `targets` accept Location, Object state and Section objects.

### Checking user access

To check if a user has access to an operation, use the `isGranted()` method.
For example, to check if content can be assigned to a Section:

``` php
$hasAccess = $this->isGranted(
    new Attribute( 'section', 'assign', array( 'valueObject' => $contentInfo, 'targets' => $section ) )
);
```

You can also use the permission resolver (`Ibexa\Core\Repository\Permission\PermissionResolver`).
The `canUser()` method checks if the user can perform a given action with the selected object.

For example: `canUser('content', 'edit', $content, $location );`
checks the `content/edit` permission for the provided Content item at the provided Location.

### Blocking access to controller action

To block access to a specific action of the controller, add the following to the action's definition:

``` php
$this->denyAccessUnlessGranted(new Attribute('state', 'administrate'));
```
