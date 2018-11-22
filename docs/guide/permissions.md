# Permissions

## Permission overview

A User by default does not have access to anything. To get access they need to inherit Roles, typically assigned to the User Group they belong to.

Each Role can contain one or more **Policies**. A Policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` Policy allows the User to assign content to Sections.

When you add a Policy to a Role, you can also restrict it using one or more **Limitations**.
A Policy with a Limitation will only apply when the condition in the Limitation is fulfilled.
For example, a `content/publish` Policy with a `ContentType` Limitation on the "Blog Post" Content Type will allow the User to publish only Blog Posts, and not other Content.

Note that Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply. See [example below](#restrict-editing-to-part-of-the-tree).

Remember that a Limitation specifies what a User *can* do, not what they *can't do*.
A `Section` Limitation, for example, *gives* the User access to the selected Section, not *prohibits* it.

See [Available Limitations](limitations.md#available-limitations) for further information.

To take effect, a Role must be assigned to a User or User Group. Every User or User Group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning Roles to Users directly; instead, make sure you model your content (types, structure, sections, etc.) in a way that can be reflected in generic roles. Besides being much easier to manage and keep on top of security-wise, this also makes sure your system performs best. The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries powering the whole CMS will be, as they always take permissions into account.

## Use Cases

Here are a few examples of sets of Policies you can use to get some common permission configurations.

#### Enter back end interface

To allow the User to enter the back end interface and view all Content, you need to set the following Policies:

- `user/login`
- `content/read`
- `content/versionread`
- `section/view`
- `content/reverserelatedlist`

These Policies will be necessary for all other cases below that require access to the Content structure.

#### Create and publish content

To create and publish content, the user must additionally have the following Policies:

- `content/create`
- `content/edit`
- `content/publish`

This also lets the user copy and move content, as well as add new Locations to a Content item (but not remove them!).

#### Create content without publishing

This option can be used together with eZ Enterprise's content review options. Using the following Policies, the User is able to create content, but can't publish it; instead, they must send it for review to another User with proper permissions (for example, senior editor, proofreader, etc.).

- `content/create`
- `content/edit`

Note that without eZ Enterprise this setup should not be used, as it will not allow the User to continue working with their content.

#### Restrict editing to part of the tree

If you want to let the User create or edit Content, but only in one part of the content tree, you need to use Limitations. Three Limitations that could be used here are `Section` Limitation, `Location` Limitation and `Subtree` Limitation.

Let's assume you have two Folders under your Home: Blog and Articles. You can let a User create Content for the blogs, but not in Articles by adding a `Subtree` Limitation on the Blog Content item. This will allow the User to publish content anywhere under this Location in the structure.

A `Section` Limitation can be used similarly, but a Section does not have to belong to the same subtree in the content structure, any Locations can be assigned to it.

If you add a `Location` Limitation and point to the same Location, the User will be able to publish content directly under the selected Location, but not anywhere deeper in its subtree.

Note that when a Policy has more than one Limitation, all of them have to apply, or the Policy will not work. For example, a `Location` Limitation on Location `1/2` and `Subtree` Limitation on `1/2/55` cannot work together, because no Location can satisfy both those requirements at the same time. If you want to combine more than one Limitation with the *or* relation, not *and*, you can split your Policy in two, each with one of these Limitations.

#### Multi-file upload

Creating content through multi-file upload is treated in the same way as regular creation.
To enable upload, you need you set the following permissions:

- `content/create`
- `content/read`
- `content/publish`

You can control what Content items can be uploaded and where using Limitations on the `content/create` and `content/publish` Policies.

A Location Limitation limits uploading to a specific Location in the tree. A Content Type Limitation controls the Content Types that are allowed.
For example, you can set the Location Limitation on a "Pictures" Folder, and add a Content Type Limitation
which only allows Content items of type "Image". This ensures that only files of type "image" can be uploaded,
and only to the "Pictures" Folder.

#### Manage Locations

To add a new Location to a Content item, the Policies required for publishing content are enough. To allow the User to remove a Location, you need to grant them the following Policies:

- `content/remove`
- `content/manage_locations`

Hiding and revealing Location requires one more Policy: `content/hide`.

#### Removing content

To send content to trash, the User needs to have the `content/remove` Policy.

To remove an archived version of content, the User must have the `content/versionremove` Policy.

Further manipulation of trash requires the `content/restore` Policy to restore items from trash, and `content/cleantrash` to completely delete all content from the trash.

#### Registering Users

To allow anonymous users to register through the `/register` route, you need to grant the `user/register` Policy to the Anonymous User Group.

#### Admin

To access the Admin in the Back Office the User must have the `setup/administrate` Policy.
This will allow the User to view the Languages and Content Types.

Additional Policies are needed for each section of the Admin.

##### System Information

- `setup/system_info` to view the System Information tab

##### Sections

- `section/view` to see and access the Section list
- `section/edit` to add and edit Sections
- `section/assign` to assign Sections to Content

##### Languages

- `content/translations` to add and edit languages

##### Content Types

- `Content Type/create`, `Content Type/update`, `Content Type/delete` to add, modify and remove Content Types

##### Object States

- `state/administrate` to view a list of Object States, add and edit them
- `state/assign` to assign Objects States to Content

##### Roles

- `role/read` to view the list of Roles in Admin
- `role/create`, `role/update`, `role/assign` and `role/delete` to manage Roles

##### Users

- `content/view` to view the list of Users

Users are treated like other Content, so to create and modify them the User needs to have the same permissions as for managing other Content items.

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
|               | `cleantrash`         | empty the trash                                                                                                                         |
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
    new Attribute( 'section', 'assign', array( 'valueObject' => $contentInfo, 'targets' => $section ) )
);
```

You can also use the permission resolver (`eZ\Publish\API\Repository\PermissionResolver`).
The `canUser()` method checks if the user can perform a given action with the selected object.

For example: `canUser('content', 'edit', $content, $location );`
checks the `content/edit` permission for the provided Content item at the provided Location.

### Blocking access to controller action

To block access to a specific action of the controller, add the following to the action's definition:

``` php
$this->denyAccessUnlessGranted(new Attribute('state', 'administrate'));
```
