# Permissions

## Permission overview

A User by default does not have access to anything. To get access they need to inherit Roles, typically assigned to the User Group they belong to.

Each Role can contain one or more **Policies**. A Policy is a rule that gives access to a single **function** in a **module**.
For example, a `section/assign` Policy allows the user to assign content to Sections.

When you add a Policy to a Role, you can also restrict it using one or more **Limitations**.
A Policy with a Limitation will only apply when the condition in the Limitation is fulfilled.
For example, a `content/publish` Policy with a ContentType Limitation on the "Blog Post" Content Type will allow the user to publish only Blog Posts, and not other Content.

Note that Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply. See [example below](#restrict-editing-to-part-of-the-tree).

Remember that a Limitation specifies what a user *can* do, not what they *can't do*.
A Section Limitation, for example, *gives* the user access to the selected Section, not *prohibits* it.

See [Role Policies Map](#role-policies-map) for further information.

To take effect, a Role must be assigned to a User or User Group. Every User or User Group can have many roles. A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning Roles to Users directly; instead, make sure you model your content (types, structure, sections, etc.) in a way that can be reflected in generic roles. Besides being much easier to manage and keep on top of security-wise, this also makes sure your system performs best. The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries powering the whole CMS will be, as they always take permissions into account.

### Use Cases

Here are a few examples of sets of Policies you can use to get some common permission configurations.

##### Enter back end interface

To allow the user to enter the back end interface (PlatformUI) and view all Content, you need to set the following Policies:

- `user/login`
- `content/read`

To let the user navigate through StudioUI, you also need to add:

- `content/versionread`

These Policies will be necessary for all other cases below that require access to the PlatformUI.

##### Create and publish content

To create and publish content, the user must have (besides `user/login` and `content/read`) the following Policies:

- `content/create`
- `content/edit`
- `content/publish`
- `content/versionread`

This also lets the user copy and move content, as well as add new Locations to a Content item (but not remove them!).

##### Create content without publishing

This option can be used together with eZ Enterprise's content review options. Using the following Policies, the user is able to create content, but can't publish it; instead, they must send it to review to another user with proper permissions (for example, senior editor, proofreader, etc.).

- `content/create`
- `content/edit`

Note that without eZ Enterprise this setup should not be used, as it will not allow the user to continue working with their content.

##### Restrict editing to part of the tree

If you want to let the user create or edit Content, but only in one part of the content tree, you need to use Limitations. Three Limitations that could be used here are Section Limitation, Node Limitation and Subtree Limitation.

Let's assume you have two Folders under your Home: Blog and Articles. You can let a user create Content for the blogs, but not in Articles by adding a Subtree Limitation on the Blog Content item. This will allow the user to publish content anywhere under this Location in the structure.

A Section Limitation can be used similarly, but a Section does not have to belong to the same subtree in the content structure, any Locations can be assigned to it.

If you add a Node Limitation and point to the same Location, the user will be able to publish content directly under the selected Location, but not anywhere deeper in its subtree.

Note that when a Policy has more than one Limitation, all of them have to apply, or the Policy will not work. For example, a Location Limitation on Location `1/2` and Subtree Limitation on `1/2/55` cannot work together, because no Location can satisfy both those requirements at the same time. If you want to combine more than one Limitation with the *or* relation, not *and*, you can split your Policy in two, each with one of these Limitations.

##### Manage Locations

To add a new Location to a Content item, the Policies required for publishing content are enough. To allow the user to remove a Location, you need to grant them the following Policies:

- `content/remove`
- `content/manage_locations`

Hiding and revealing Location requires one more Policy: `content/hide`.

##### Removing content

To send content to trash, the user needs to have the same two Policies that are required for removing Locations:

- `content/remove`
- `content/manage_locations`

To remove an archived version of content, the user must have the `content/versionremove` Policy.

Further manipulation of trash requires the `content/restore` Policy to restore items from trash, and `content/cleantrash` to completely delete all content from the trash.

##### Registering users

To allow anonymous users to register through the `/register` route, you need to grant the `user/register` Policy to the Anonymous User Group.

### Available Policies

| Module        | Function             | Effect                                                                                                                                  |
|---------------|----------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `all modules` | `all functions`      | grants all available permissions                                                                                                        |
| `content`     | `read`               | view the content both in front and back end                                                                                             |
|               | `diff`               | unused                                                                                                                                  |
|               | `view_embed`         | view content embedded in another Content item (even when not allowed to view it under normal circumstances)                             |
|               | `create`             | create new content. Note: even without this Policy the user is able to enter edit mode, but cannot finalize work with the Content item. |
|               | `edit`               | edit existing content                                                                                                                   |
|               | `publish`            | publish content. Without this Policy, the user can only save drafts or send them for review (in eZ Enterprise)                          |
|               | `manage_locations`   | required to remove Locations and send content to Trash                                                                                  |
|               | `hide`               | hide and reveal content Locations                                                                                                       |
|               | `reverserelatedlist` | see all content that a Content item relates to (even when not allowed to view it under normal circumstances)                            |
|               | `translate`          | unused                                                                                                                                  |
|               | `remove`             | required to remove Locations and send content to Trash                                                                                  |
|               | `versionread`        | required to view content after publishing, and to preview any content in the Page mode                                                  |
|               | `versionremove`      | remove archived content versions                                                                                                        |
|               | `translations`       | required to manage the language list in PlatformUI                                                                                      |
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

Certain limitations also serve as RoleLimitations, which means they can be used to limit the rights of a Role assignment. Currently this covers `Subtree` and `Section` limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see `eZ\Publish\SPI\Limitation\Type` interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluating if the user has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current user which `SearchService` by default applies to search criteria for filtering search based on permissions. |

### Available Limitations

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

A generic Limitation type to use when no other Limitation has been implemented. Without any limitation assigned, a LimitationNotFoundException is thrown.

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
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this limitation in your own logic.|

##### Configuration

As this is a generic Limitation, you can configure your custom Limitations to use it, out of the box FunctionList uses it in the following way:

``` yaml
    # FunctionList is a ezjscore limitations, it only applies to ezjscore policies not used by
    # API/platform stack so configuring to use "blocking" limitation to avoid LimitationNotFoundException
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
|`<ContentType_id>`|`<ContentType_name>`|All valid ContentType ids can be set as value(s)|

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
|`<Location_id>`|`<Location_name>`|All valid Location ids can be set as value(s)|

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
|`<State_id>`|`<State_name>`|All valid state ids can be set as value(s)|

#### NewSectionLimitation

A Limitation to specify if the User has access to (assigning) a given Section (to Content).

In the `section/assign` Policy you can combine this with `SectionLimitation` to limit both from and to values.

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
|`<Session_id>`|`<Session_name>`|All valid section ids can be set as value(s)|

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
|`<ObjectState_id>`|`<ObjectState_name>`|All valid ObjectState ids can be set as value(s)|

#### OwnerLimitation

A Limitation to specify that only the owner of the Content item gets a certain access right.

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
|`2`|"session"|Same as "self"|

##### Legacy compatibility notes:

1. "session" is deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions
1. A User is no longer automatically assumed to be the owner of themselves and gets access to edit themselves when the Owner limitation is used in Public API

!!! note "Workaround for the OwnerLimitation on Users"

    To make sure the User gets access to themselves when using OwnerLimitation across 4.x and 5.x, the solution is to change the User to be the owner of their own Content item.

    This is accomplished using a privileged user to do the following API calls:

    ``` php
    $user = $userService->loadUser( $userId );
    $contentMetadataUpdateStruct = $contentService->newContentMetadataUpdateStruct();
    $contentMetadataUpdateStruct->ownerId = $user->id;
    $contentService->updateContentMetadata( $user->getVersionInfo()->getContentInfo(), $contentMetadataUpdateStruct );
    ```

#### ParentContentTypeLimitation

A Limitation to specify if the User has access to Content whose parent Location contains a specific Content Type, used by `content/create`.

This limitation combined with `ContentTypeLimitation` allows you to define business rules like allowing users to create "Blog Post" within a "Blog." If you also combine it with `ParentOwnerLimitation`, you effectively limit access to create Blog Posts in the users' own Blogs.

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
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type ids can be set as value(s)|

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

A Limitation to specify that only the Users who owns all parent Locations of a Content item gets a certain access right, used for `content/create` permission.

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
|`2`|"session"|Same as "self"|

##### Legacy compatibility notes

1. "session" is deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions
1. User is no longer auto assumed to be owner of himself and get access create children of own user content object when `Owner` limitation is used in Public API

!!! note "Workaround for the ParentOwner Limitation on Users (when a User is the parent of the content being created)"

    To make sure the User gets access to themselves when using (Parent)OwnerLimitation across 4.x and 5.x, the solution is to change the User to be the owner of their own Content item.

    This is accomplished using a privileged user to do the following API calls:

    ``` php
    $user = $userService->loadUser( $userId );
    $contentMetadataUpdateStruct = $contentService->newContentMetadataUpdateStruct();
    $contentMetadataUpdateStruct->ownerId = $user->id;
    $contentService->updateContentMetadata( $user->getVersionInfo()->getContentInfo(), $contentMetadataUpdateStruct );
    ```

#### ParentUserGroupLimitation

A Limitation to specify that only Users with at least one common *direct* User group with the owner of the parent Location of a Content item get a certain access right, used by `content/create` permission.

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
|`1`|"self"|Only a User who has at least one common *direct* user group with owner of the parent Location gets access|

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
|`<Session_id>`|`<Session_name>`|All valid section ids can be set as value(s)|

#### SiteAccessLimitation

A Limitation to specify in which siteaccesses a certain permission applies, used by `user/login`.

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

A Limitation to specify that only Users with at least one common *direct* User group with the owner of content get a certain access right.

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
|`1`|"self"|Only a User who has at least one common *direct* User group with the owner gets access|

## Role Policies Map

### Retrieving the Role Policies

To retrieve the Roles Policies, on a working eZ Platform instance, in dev environment open the file `app/cache/dev/appDevDebugProjectContainer.xml`

If you can not find the file, please reload the homepage. The cache will be regenerated.

Then open it and look for `ezpublish.api.role.policy_map`, it will look like this:

``` xml
<!--ezpublish.api.role.policy\_map entry in the app/cache/dev/appDevDebugProjectContainer.xml file-->

    <parameter key="ezpublish.api.role.policy_map" type="collection">
        <parameter key="content" type="collection">           
        <parameter key="read" type="collection">
        <parameter key="Class">true</parameter>
```

- The 1st sublevel ("content") is a module.
- The 2nd sublevel ("read") is a function.
- The 3rd sublevel ("Class") is a limitation.

### Module, function and limitations

Each Module contains functions, and for each function, you have limitations. The default values are shown below.

There are 4 modules:

- content
- section
- state
- user

If a function is absent from the tables below, it means that no Limitations can be assigned to it.

#### Content

|Functions|Class|Section|Owner|Node|Subtree|Group|Language|Other Limitations|
|------|------|------|------|------|------|------|------|------|
|read|true|true|true|true|true|true|-|State|
|diff|true|true|true|true|true|-|-|-|
|view_embed|true|true|true|true|true|-|-|-|
|create|true|true|-|true|true|-|true|ParentOwner</br>ParentGroup</br>ParentClass</br>ParentDepth|
|edit|true|true|true|true|true|true|true|State|
|manage_locations|true|true|true|-|true|-|-|-|
|hide|true|true|true|true|true|true|true|State|
|translate|true|true|true|true|true|true|-|
|remove|true|true|true|true|true|-|-|State|
|versionread|true|true|true|true|true|-|-|Status|
|versionremove|true|true|true|true|true|-|-|Status|

#### Section

|Function|Limitations|
|------|------|
|assign|Class</br>Section</br>Owner</br>NewSection|

#### State

|Function|Limitations|
|------|------|
|assign|Class</br>Section</br>Owner</br>NewSection|

#### User

|Function|Limitations|
|------|------|
|assign|SiteAccess|

## Custom Policies

eZ content repository uses the concept of Roles and Policies in order to authorize a user to do something (e.g. read content).

- A Role is composed of Policies and can be assigned to a User or a User Group.
- A Policy is composed of a combination of **module** and **function** (e.g. `content/read`, `content` being the module and `read` being the function).
- Depending on **module** and **function** combination, a Policy can also be composed of Limitations.

It is possible for any bundle to expose available Policies via a `PolicyProvider` which can be added to EzPublishCoreBundle's DIC extension.

### PolicyProvider

A `PolicyProvider` is an object providing a hash containing declared modules, functions and limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (e.g. "content/read": "content" is the module, "read" is the function)
- Each function can provide a collection of Limitations.

Policies configuration hash contains declared these modules, functions and Limitations.
First level key is the module name, value is a hash of available functions, with function name as key.
Function value is an array of available Limitations, identified by the alias declared in LimitationType service tag.
If no Limitation is provided, value can be `null` or an empty array.

```
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

Limitations need to be implemented as *limitation types* and declared as services identified with `ezpublish.limitationType` tag. Name provided in the hash for each Limitation is the same value set in `alias` attribute in the service tag.

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

### YamlPolicyProvider

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

### Core policies

Policies used internally in repository services are defined in `EzPublishCoreBundle/Resources/config/policies.yml`.
