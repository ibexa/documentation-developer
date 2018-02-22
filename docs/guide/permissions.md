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

See [Available Limitations](#available-limitations) for further information.

To take effect, a Role must be assigned to a User or User Group. Every User or User Group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning Roles to Users directly; instead, make sure you model your content (types, structure, sections, etc.) in a way that can be reflected in generic roles. Besides being much easier to manage and keep on top of security-wise, this also makes sure your system performs best. The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries powering the whole CMS will be, as they always take permissions into account.

### Use Cases

Here are a few examples of sets of Policies you can use to get some common permission configurations.

##### Enter back end interface

To allow the User to enter the back end interface (PlatformUI) and view all Content, you need to set the following Policies:

- `user/login`
- `content/read`

To let the User navigate through StudioUI, you also need to add:

- `content/versionread`
- `section/view`
- `content/reverserelatedlist`

These Policies will be necessary for all other cases below that require access to the PlatformUI.

##### Create and publish content

To create and publish content, the User must additionally have the following Policies:

- `content/create`
- `content/edit`
- `content/publish`
- `content/versionread`

This also lets the User copy and move content, as well as add new Locations to a Content item (but not remove them!).

##### Create content without publishing

This option can be used together with eZ Enterprise's content review options. Using the following Policies, the User is able to create content, but can't publish it; instead, they must send it for review to another User with proper permissions (for example, senior editor, proofreader, etc.).

- `content/create`
- `content/edit`

Note that without eZ Enterprise this setup should not be used, as it will not allow the User to continue working with their content.

##### Restrict editing to part of the tree

If you want to let the User create or edit Content, but only in one part of the content tree, you need to use Limitations. Three Limitations that could be used here are `Section` Limitation, `Node` Limitation and `Subtree` Limitation.

Let's assume you have two Folders under your Home: Blog and Articles. You can let a User create Content for the blogs, but not in Articles by adding a `Subtree` Limitation on the Blog Content item. This will allow the User to publish content anywhere under this Location in the structure.

A `Section` Limitation can be used similarly, but a Section does not have to belong to the same subtree in the content structure, any Locations can be assigned to it.

If you add a `Node` Limitation and point to the same Location, the User will be able to publish content directly under the selected Location, but not anywhere deeper in its subtree.

Note that when a Policy has more than one Limitation, all of them have to apply, or the Policy will not work. For example, a `Location` Limitation on Location `1/2` and `Subtree` Limitation on `1/2/55` cannot work together, because no Location can satisfy both those requirements at the same time. If you want to combine more than one Limitation with the *or* relation, not *and*, you can split your Policy in two, each with one of these Limitations.

###### Multi-file upload

Creating content through multi-file upload is treated in the same way as regular creation.
To enable upload, you need you set the following permissions:

- `content/create`
- `content/read`
- `content/publish`

You can control what Content items can be uploaded and where using Limitations on the `content/create` and `content/publish` Policies.

A Node Limitation limits uploading to a specific Location in the tree. A Class Limitation controls the Content Types that are allowed.
For example, you can set the Node Limitation on a "Pictures" Folder, and add a Class Limitation
which only allows Content items of type "Image". This ensures that only files of type "image" can be uploaded,
and only to the "Pictures" Folder.

##### Manage Locations

To add a new Location to a Content item, the Policies required for publishing content are enough. To allow the User to remove a Location, you need to grant them the following Policies:

- `content/remove`
- `content/manage_locations`

Hiding and revealing Location requires one more Policy: `content/hide`.

##### Removing content

To send content to trash, the User needs to have the same two Policies that are required for removing Locations:

- `content/remove`
- `content/manage_locations`

To remove an archived version of content, the User must have the `content/versionremove` Policy.

Further manipulation of trash requires the `content/restore` Policy to restore items from trash, and `content/cleantrash` to completely delete all content from the trash.

##### Registering Users

To allow anonymous users to register through the `/register` route, you need to grant the `user/register` Policy to the Anonymous User Group.

### Available Policies

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
|               | `translations`       | manage the language list in PlatformUI                                                                                                  |
|               | `urltranslator`      | unused                                                                                                                                  |
|               | `pendinglist`        | unused                                                                                                                                  |
|               | `restore`            | restore content from Trash                                                                                                              |
|               | `cleantrash`         | empty the trash                                                                                                                         |
| `class`       | `update`             | modify existing Content Types. Also required to create new Content Types                                                                |
|               | `create`             | create new Content Types. Also required to edit exiting Content Types                                                                   |
|               | `delete`             | delete Content Types                                                                                                                    |
| `state`       | `assign`             | unused                                                                                                                                  |
|               | `administrate`       | unused                                                                                                                                  |
| `role`        | `assign`             | assign roles to Users and User Groups                                                                                                   |
|               | `update`             | modify existing Roles                                                                                                                   |
|               | `create`             | create new Roles                                                                                                                        |
|               | `delete`             | delete Roles                                                                                                                            |
|               | `read`               | view the Roles list in Admin Panel. Required for all other role-related Policies                                                        |
| `section`     | `assign`             | assign Sections to content                                                                                                              |
|               | `edit`               | edit existing Sections and create new ones                                                                                              |
|               | `view`               | view the Sections list in Admin Panel. Required for all other section-related Policies                                                  |
| `setup`       | `administrate`       | unused                                                                                                                                  |
|               | `install`            | unused                                                                                                                                  |
|               | `setup`              | unused                                                                                                                                  |
|               | `system_info`        | view the System information tab in the Admin Panel                                                                                      |
| `user`        | `login`              | log in to the application                                                                                                               |
|               | `password`           | unused                                                                                                                                  |
|               | `preferences`        | unused                                                                                                                                  |
|               | `register`           | register using the `/register` route                                                                                                    |
|               | `selfedit`           | unused                                                                                                                                  |
|               | `activation`         | unused                                                                                                                                  |

## Limitations

Limitations are crucial building blocks of the permissions system in eZ Platform. They provide the restrictions you can apply to a given access right to limit the right according to certain conditions.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment. Currently this covers `Subtree` and `Section` Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see `eZ\Publish\SPI\Limitation\Type` interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

### Available Limitations

!!! tip

    Core Policies with Limitations are defined in [`EzPublishCoreBundle/Resources/config/policies.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/policies.yml).

#### Module, function and limitations

Each Module contains functions, and for each function, you have Limitations. The default values are shown below.

There are 4 modules:

- content
- section
- state
- user

If a function is absent from the tables below, it means that no Limitations can be assigned to it.

##### Content

|Functions|Class|Section|Owner|Node|Subtree|Group|Language|Other Limitations|
|------|------|------|------|------|------|------|------|------|
|read|true|true|true|true|true|true|-|State|
|diff|true|true|true|true|true|-|-|-|
|view_embed|true|true|true|true|true|-|-|-|
|create|true|true|-|true|true|-|true|ParentOwner</br>ParentGroup</br>ParentClass</br>ParentDepth|
|edit|true|true|true|true|true|true|true|State|
|manage_locations|true|true|true|-|true|-|-|State|
|hide|true|true|true|true|true|true|true|State|
|translate|true|true|true|true|true|true|-|
|remove|true|true|true|true|true|-|-|State|
|versionread|true|true|true|true|true|-|-|Status|
|versionremove|true|true|true|true|true|-|-|Status|

##### Section

|Function|Limitations|
|------|------|
|assign|Class</br>Section</br>Owner</br>NewSection|

##### State

|Function|Limitations|
|------|------|
|assign|Class</br>Section</br>Owner</br>NewSection|

##### User

|Function|Limitations|
|------|------|
|assign|SiteAccess|

### Limitation details

- [BlockingLimitation](#blockinglimitation)
- [ContentTypeLimitation](#contenttypelimitation)
- [LanguageLimitation](#languagelimitation)
- [LocationLimitation](#locationlimitation)
- [NewObjectStateLimitation](#newobjectstatelimitation)
- [NewSectionLimitation](#newsectionlimitation)
- [ObjectStateLimitation](#objectstatelimitation)
- [OwnerLimitation](#ownerlimitation)
- [ParentContentTypeLimitation](#parentcontenttypelimitation)
- [ParentDepthLimitation](#parentdepthlimitation)
- [ParentOwnerLimitation](#parentownerlimitation)
- [ParentUserGroupLimitation](#parentusergrouplimitation)
- [SectionLimitation](#sectionlimitation)
- [SiteAccessLimitation](#siteaccesslimitation)
- [SubtreeLimitation](#subtreelimitation)
- [UserGroupLimitation](#usergrouplimitation)

#### BlockingLimitation

A generic Limitation type to use when no other Limitation has been implemented. Without any Limitation assigned, a LimitationNotFoundException is thrown.

It is called "blocking" because it will always tell the permissions system that the User does not have access to any Policy it is assigned to, making the permissions system move on to the next Policy.

|                 |                                                                                       |
|-----------------|---------------------------------------------------------------------------------------|
| Identifier      | `n/a` (configured for `ezjscore` limitation `FunctionList` out of the box)            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\BlockingLimitation`                 |
| Type Class      | `eZ\Publish\Core\Limitation\BlockingLimitationType`                                   |
| Criterion used  | MatchNone                                                                             |
| Role Limitation | no                                                                                    |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this Limitation in your own logic.|

##### Configuration

As this is a generic Limitation, you can configure your custom Limitations to use it.
Out of the box FunctionList uses it in the following way:

``` yaml
    # FunctionList is an ezjscore limitation, it only applies to ezjscore policies not used by
    # API/platform stack, so configure to use Blocking Limitation to avoid LimitationNotFoundException
    ezpublish.api.role.limitation_type.function_list:
        class: %ezpublish.api.role.limitation_type.blocking.class%
        arguments: ['FunctionList']
        tags:
            - {name: ezpublish.limitationType, alias: FunctionList}
```

#### ContentTypeLimitation

A Limitation to specify if the User has access to Content with a specific Content Type.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Class`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ContentTypeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId` |
| Role Limitation | no                                                                       |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid ContentType IDs can be set as value(s)|

#### LanguageLimitation

A Limitation to specify if the User has access to Content in a specific language.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `Language`                                                              |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LanguageLimitation`   |
| Type Class      | `eZ\Publish\Core\Limitation\LanguageLimitationType`                     |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LanguageCode` |
| Role Limitation | no                                                                      |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

#### LocationLimitation

A Limitation to specify if the User has access to Content with a specific Location, in case of `content/create` the parent Location is evaluated.

|                 |                                                                       |
|-----------------|-----------------------------------------------------------------------|
| Identifier      | `Node`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LocationLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\LocationLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId` |
| Role Limitation | no                                                                    |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid Location IDs can be set as value(s)|

#### NewObjectStateLimitation

A Limitation to specify if the User has access to (assigning) a given `ObjectState` (to Content).

In the `state/assign` Policy you can combine this with `ObjectStateLimitation` to limit both from and to values.

|                 |                                                                             |
|-----------------|-----------------------------------------------------------------------------|
| Identifier      | `NewState`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewObjectStateLimitationType`                   |
| Criterion used  | n/a                                                                         |
| Role Limitation | no                                                                          |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

#### NewSectionLimitation

A Limitation to specify if the User has access to (assigning) a given Section (to Content).

In the `section/assign` Policy you can combine this with `Section` Limitation to limit both from and to values.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `NewSection`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewSectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewSectionLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

#### ObjectStateLimitation

A Limitation to specify if the User has access to Content with a specific ObjectState.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `State`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ObjectStateLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateId` |
| Role Limitation | no                                                                       |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid ObjectState IDs can be set as value(s)|

#### OwnerLimitation

A Limitation to specify that only the owner of the Content item gets the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Owner`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\OwnerLimitation`                             |
| Type Class      | `eZ\Publish\Core\Limitation\OwnerLimitationType`                                               |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::OWNER )` |
| Role Limitation | no                                                                                             |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

#### ParentContentTypeLimitation

A Limitation to specify if the User has access to Content whose parent Location contains a specific Content Type, used by `content/create`.

This Limitation combined with `ContentType` Limitation allows you to define business rules like allowing Users to create "Blog Post" within a "Blog." If you also combine it with `ParentOwner` Limitation, you effectively limit access to create Blog Posts in the Users' own Blogs.

|                 |                                                                                |
|-----------------|--------------------------------------------------------------------------------|
| Identifier      | `ParentClass`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentContentTypeLimitationType`                   |
| Criterion used  | n/a                                                                            |
| Role Limitation | no                                                                             |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

#### ParentDepthLimitation

A Limitation to specify if the User has access to creating Content under a parent Location within a specific depth of the tree, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `ParentDepth`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentDepthLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentDepthLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

#### ParentOwnerLimitation

A Limitation to specify that only the Users who own all parent Locations of a Content item get a certain access right, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `ParentOwner`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentOwnerLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentOwnerLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner of all parent Locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

#### ParentUserGroupLimitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of the parent Location of a Content item get a certain access right, used by `content/create` permission.

|                 |                                                                              |
|-----------------|------------------------------------------------------------------------------|
| Identifier      | `ParentGroup`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentUserGroupLimitationType`                   |
| Criterion used  | n/a                                                                          |
| Role Limitation | no                                                                           |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with owner of the parent Location gets access|

#### SectionLimitation

A Limitation to specify if the User has access to Content within a specific Section.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Section`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SectionLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\SectionId` |
| Role Limitation | yes                                                                  |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

#### SiteAccessLimitation

A Limitation to specify to which SiteAccesses a certain permission applies, used by `user/login`.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `SiteAccess`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SiteAccessLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SiteAccessLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

##### Legacy compatibility notes

`SiteAccess` Limitation is deprecated and is not used actively in Public API, but is allowed for being able to read / create Limitations for legacy.

#### SubtreeLimitation

A Limitation to specify if the User has access to Content within a specific subtree, in case of `content/create` the parent subtree is evaluated.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Subtree`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SubtreeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Subtree`   |
| Role Limitation | yes                                                                  |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

#### UserGroupLimitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of content get the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Group`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\UserGroupLimitation`                         |
| Type Class      | `eZ\Publish\Core\Limitation\UserGroupLimitationType`                                           |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::GROUP )` |
| Role Limitation | no                                                                                             |

##### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with the owner gets access|

## Custom Policies

eZ Platform's content Repository uses the concept of Roles and Policies in order to authorize a User to do something (e.g. read content).

- A Role is composed of Policies and can be assigned to a User or a User Group.
- A Policy is composed of a combination of **module** and **function** (e.g. `content/read`, `content` being the module and `read` being the function).
- Depending on **module** and **function** combination, a Policy can also contain Limitations.

It is possible for any bundle to expose available Policies via a `PolicyProvider` which can be added to EzPublishCoreBundle's DIC extension.

### PolicyProvider

A `PolicyProvider` is an object providing a hash containing declared modules, functions and Limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (e.g. in `content/read` "content" is the module, "read" is the function)
- Each function can provide a collection of Limitations.

A Policy configuration hash contains these modules, functions and Limitations.
First level key is the module name, value is a hash of available functions, with function name as key.
Function value is an array of available Limitations, identified by the alias declared in `LimitationType` service tag.
If no Limitation is provided, value can be `null` or an empty array.

``` php
[
    "content" => [
        "read" => ["Class", "ParentClass", "Node", "Language"],
        "edit" => ["Class", "ParentClass", "Language"]
    ],
    "custom_module" => [
        "custom_function_1" => null,
        "custom_function_2" => ["CustomLimitation"]
    ],
]
```

Limitations need to be implemented as *Limitation types* and declared as services identified with `ezpublish.limitationType` tag. Name provided in the hash for each Limitation is the same value set in the `alias` attribute in the service tag.

### Example

``` php
namespace Acme\FooBundle\AcmeFooBundle\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigBuilderInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

class MyPolicyProvider implements PolicyProviderInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder)
    {
        $configBuilder->addConfig([
             "custom_module" => [
                 "custom_function_1" => null,
                 "custom_function_2" => ["CustomLimitation"],
             ],
         ]);
    }
}
```

### REVIEW YamlPolicyProvider

An abstract class based on YAML is provided: `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider`.
It defines an abstract `getFiles()` method.

Extend `YamlPolicyProvider` and implement `getFiles()` to return absolute paths to your YAML files.

``` php
namespace Acme\FooBundle\AcmeFooBundle\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    protected function getFiles()
    {
        return [
             __DIR__ . '/../Resources/config/policies.yml',
         ];
    }
}
```

``` yaml
# AcmeFooBundle/Resources/config/policies.yml
custom_module:
    custom_function_1: ~
    custom_function_2: [CustomLimitation]
```

#### Extending existing policies

A `PolicyProvider` may provide new functions to a module, and additional Limitations to an existing function. 
**It is however strongly encouraged to add functions to your own Policy modules.**

It is not possible to remove an existing module, function or limitation from a Policy.

### Integrating the PolicyProvider into EzPublishCoreBundle

For a PolicyProvider to be active, it must be properly declared in EzPublishCoreBundle.
A bundle just has to retrieve CoreBundle's DIC extension and call `addPolicyProvider()`. This must be done in the bundle's `build()` method.

``` php
namespace Acme\FooBundle\AcmeFooBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeFooBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // ...
 
        // Retrieve "ezpublish" container extension.
        $eZExtension = $container->getExtension('ezpublish');
        // Add the policy provider.
        $eZExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
```

### Integrating custom Limitation types with the UI

To provide support for editing custom policies in Platform UI you need to implement [`EzSystems\RepositoryForms\Limitation\LimitationFormMapperInterface`](https://github.com/ezsystems/repository-forms/blob/master/lib/Limitation/LimitationFormMapperInterface.php):

```php
<?php

/**
 * Interface for LimitationType form mappers.
 *
 * It maps a LimitationType's supported values to editing form.
 */
interface LimitationFormMapperInterface
{
    /**
     * Maps Limitation form to current LimitationType, in order to display one or several fields
     * representing limitation values supported by the LimitationType.
     *
     * Implementors MUST either:
     * - Add a "limitationValues" form field
     * - OR add field(s) that map to "limitationValues" property from $data.
     *
     * @param FormInterface $form Form for current Limitation.
     * @param Limitation $data Underlying data for current Limitation form.
     */
    public function mapLimitationForm(FormInterface $form, Limitation $data);
    /**
     * Returns the Twig template to use for rendering the Limitation form.
     *
     * @return string
     */
    public function getFormTemplate();
    /**
     * This method will be called when FormEvents::SUBMIT is called.
     * It gives the opportunity to filter/manipulate Limitation values.
     *
     * @param Limitation $limitation
     */
    public function filterLimitationValues(Limitation $limitation);
}
```

Next, register the service in DIC (Dependency Injection Container) with the `ez.limitation.formMapper` tag and set the `limitationType` attribute to the Limitation type's identifier:

```yml
acme.security.limitation.custom_limitation.mapper:
    class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationFormMapper'
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.formMapper', limitationType: 'Custom' }
```

If you want to provide human-readable names of the custom Limitation values, you need to implement [`\EzSystems\RepositoryForms\Limitation\LimitationValueMapperInterface`](https://github.com/ezsystems/repository-forms/blob/master/lib/Limitation/LimitationValueMapperInterface.php):

```php
<?php

/**
 * Interface for Limitation Value mappers.
 */
interface LimitationValueMapperInterface
{
    /**
     * Map the limitation values, in order to pass them as context of limitation value rendering.
     *
     * @param Limitation $limitation
     * @return mixed[]
     */
    public function mapLimitationValue(Limitation $limitation);
}
```

Then register the service in DIC with the `ez.limitation.valueMapper` tag and set the `limitationType` attribute to Limitation type's identifier:

```yml
acme.security.limitation.custom_limitation.mapper:
    class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationValueMapper'
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.valueMapper', limitationType: 'Custom' }
```

If you want to completely override the way of rendering custom Limitation values in the role view, you need to create a Twig template containing block definition which follows the naming convention: `ez_limitation_<LIMITATION TYPE>_value`. For example:

```twig
{# This file contains block definition which is used to render custom Limitation values #}
{% block ez_limitation_custom_value %}
    <span style="color: red">{{ values }}</span>
{% endblock %}
```

Add it to the configuration under `ezpublish.system.<SCOPE>.limitation_value_templates`:

```yml
ezpublish:
    system:
        default:
            limitation_value_templates:
                - { template: 'AppBundle:Limitation:custom_limitation_value.html.twig', priority: 0 }

```

!!! note

    If you skip this part, Limitation values will be rendered using [ez_limitation_value_fallback](https://github.com/ezsystems/repository-forms/blob/master/bundle/Resources/views/limitation_values.html.twig#L1-L6) block as comma-separated list.

You can also provide translation of the Limitation type identifier by adding an entry to the translation file under `ezrepoforms_policies` domain. The key must follow the naming convention: `policy.limitation.identifier.<LIMITATION TYPE>`. For example:

```xml
<trans-unit id="76adf2a27f1ae0ab14b623729cd3f281a6e2c285" resname="policy.limitation.identifier.group">
  <source>Content Type Group</source>
  <target>Content Type Group</target>
  <note>key: policy.limitation.identifier.group</note>
</trans-unit>
```
