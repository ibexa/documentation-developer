# Permissions

## Permission overview

A new User does not have permissions for any part of the system, unless they are explicitly given access.
To get access they need to inherit Roles, typically assigned to the User Group they belong to.

Each Role can contain one or more **Policies**. A Policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` Policy allows the User to assign content to Sections.

When you add a Policy to a Role, you can also restrict it using one or more **Limitations**.
A Policy with a Limitation will only apply when the condition in the Limitation is fulfilled.
For example, a `content/publish` Policy with a `ContentType` Limitation on the "Blog Post" Content Type will allow the User to publish only Blog Posts, and not other Content.

A Limitation, like a Policy, specifies what a User *can* do, not what they *can't do*.
A `Section` Limitation, for example, *gives* the User access to the selected Section, not *prohibits* it.

See [Available Limitations](limitations.md#available-limitations) for further information
and [Permission use cases](permission_use_cases.md) for example permission setups.

### Combining Policies

Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply.

If you want to combine more than one Limitation with the *or* relation, not *and*,
you can split your Policy in two, each with one of these Limitations.

### Assigning Roles to Users

Every User or User Group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

It is best practice to avoid assigning Roles to users directly.
Instead, try to organize your content so that it can be covered with general roles assigned to User Groups.

Using Groups is easier to manage and more secure. It also improves system performance.
The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries will be, because they always take permissions into account.

## Available Policies

| Module        | Function             | Effect                                                                                                                                  |
|---------------|----------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `all modules` | `all functions`      | grant all available permissions                                                                                                         |
| `content`     | `read`               | view the content both in front and back end                                                                                             |
|               | `diff`               | unused                                                                                                                                  |
|               | `view_embed`         | view content embedded in another Content item (even when the User is not allowed to view it as an individual Content item)              |
|               | `create`             | create new content. Note: even without this Policy the User is able to enter edit mode, but cannot finalize work with the Content item. |
|               | `edit`               | edit existing content                                                                                                                   |
|               | `publish`            | publish content. Without this Policy, the User can only save drafts or send them for review (in eZ Enterprise)                          |
|               | `manage_locations`   | remove Locations and send content to Trash                                                                                              |
|               | `hide`               | hide and reveal content Locations                                                                                                       |
|               | `reverserelatedlist` | see all content that a Content item relates to (even when the User is not allowed to view it as an individual Content items)            |
|               | `translate`          | unused                                                                                                                                  |
|               | `remove`             | remove Locations and send content to Trash                                                                                              |
|               | `versionread`        | view content after publishing, and to preview any content in the Page mode                                                              |
|               | `versionremove`      | remove archived content versions                                                                                                        |
|               | `translations`       | manage the language list in Admin                                                                                                  |
|               | `urltranslator`      | manage URL aliases of a Content item|
|               | `pendinglist`        | unused                                                                                                                                  |
|               | `restore`            | restore content from Trash                                                                                                              |
|               | `cleantrash`         | empty the trash (even when the User does not have access to individual Content items) |
| `Content Type`       | `update`             | modify existing Content Types. Also required to create new Content Types                                                                |
|               | `create`             | create new Content Types. Also required to edit exiting Content Types                                                                   |
|               | `delete`             | delete Content Types                                                                                                                    |
| `state`       | `assign`             | assign Object States to Content items                                                                                                   |
|               | `administrate`       | view, add and edit Object States                                                                                                        |
| `role`        | `assign`             | assign roles to Users and User Groups                                                                                                   |
|               | `update`             | modify existing Roles                                                                                                                   |
|               | `create`             | create new Roles                                                                                                                        |
|               | `delete`             | delete Roles                                                                                                                            |
|               | `read`               | view the Roles list in Admin. Required for all other role-related Policies                                                              |
| `section`     | `assign`             | assign Sections to content                                                                                                              |
|               | `edit`               | edit existing Sections and create new ones                                                                                              |
|               | `view`               | view the Sections list in Admin. Required for all other section-related Policies                                                        |
| `setup`       | `administrate`       | access Admin                                                                                                                            |
|               | `install`            | unused                                                                                                                                  |
|               | `setup`              | unused                                                                                                                                  |
|               | `system_info`        | view the System information tab in Admin                                                                                      |
| `user`        | `login`              | log in to the application                                                                                                               |
|               | `password`           | unused                                                                                                                                  |
|               | `preferences`        | access and set user preferences                                                                                                                                  |
|               | `register`           | register using the `/register` route                                                                                                    |
|               | `selfedit`           | unused                                                                                                                                  |
|               | `activation`         | unused                                                                                                                                  |
| `workflow`    | `change_stage`       | change stage in the specified workflow                                                                                                  |

## Permissions for custom controllers

You can control access to a custom controller by implementing the `performAccessCheck()` method.

In the following example the user does not have access to the controller unless they have the `section/view` Policy:

``` php
use eZ\Publish\Core\MVC\Symfony\Security\Authorization\Attribute;

public function performAccessCheck(): void
{
    parent:performAccessCheck();
    $this->denyAccessUnlessGranted(new Attribute('section', 'view'));
}
```

`Attribute` accepts three arguments:

- `module` is the Policy module (e.g. `content`)
- `function` is the function inside the module (e.g. `read`)
- `limitations` are optional limitations to check against. Here you can provide two keys:
    - `valueObject` is the object you want to check for, for example `ContentInfo`.
    - `targets` are a table of value objects that are the target of the operation.
    For example, to check if Content can be assigned to a Section, provide the Section as `targets`.
    `targets` accept Location, Object State and Section objects.

### Checking user access

To check if a user has access to an operation, use the `isGranted()` method.
For example, to check if Content can be assigned to a section:

``` php
$hasAccess = $this->isGranted(
    new Attribute( 'section', 'assign', [ 'valueObject' => $contentInfo, 'targets' => [$section] ] )
);
```

You can also use the permission resolver (`eZ\Publish\API\Repository\PermissionResolver`).
The `canUser()` method checks if the user can perform a given action with the selected object.

For example: `canUser('content', 'edit', $content, [$location] );`
checks the `content/edit` permission for the provided Content item at the provided Location.

### Blocking access to controller action

To block access to a specific action of the controller, add the following to the action's definition:

``` php
$this->denyAccessUnlessGranted(new Attribute('state', 'administrate'));
```
