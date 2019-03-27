# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permissions.md#permission-overview).
While a Policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment.
Currently this covers [Subtree](#subtreelimitation) and [Section](#sectionlimitation) Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see [`eZ\Publish\SPI\Limitation\Type`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/SPI/Limitation/Type.php) interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

## Available Limitations

!!! tip

    Core Policies with Limitations are defined in [`EzPublishCoreBundle/Resources/config/policies.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/policies.yml).

Each function in one of the four modules (content, section, state and user) can be assigned different Limitations.

!!! tip "Functions without Limitations"

    If a function is not mentioned below, it can have no Limitations.

#### Content

All Content Policies can be assigned the [Content Type](#contenttypelimitation) and [Section](#sectionlimitation) Limitation.
Beyond that the following Limitations are available:

`content/read`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/diff`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)

`content/view_embed`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)

`content/create`:

- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Parent Owner](#parentownerlimitation)
- [Parent User Group](#parentusergrouplimitation)
- [Parent Content Type](#parentcontenttypelimitation)
- [Parent Depth](#parentdepthlimitation)

`content/edit`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Object State](#objectstatelimitation)
- [Workflow Stage](#workflowstagelimitation)

`content/publish`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Object State](#objectstatelimitation)
- [Workflow Stage](#workflowstagelimitation)

`content/manage_locations`:

- [Owner](#ownerlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/hide`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)

`content/translate`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)

`content/remove`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/versionread`:

- [Owner](#ownerlimitation)
- [Status](#statuslimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/versionremove`:

- [Owner](#ownerlimitation)
- [Status](#statuslimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

#### Section

`section/assign`:

- [Content Type](#contenttypelimitation)
- [Section](#sectionlimitation)
- [Owner](#ownerlimitation)
- [New Section](#newsectionlimitation)

#### State

`state/assign`:

- [Content Type](#contenttypelimitation)
- [Section](#sectionlimitation)
- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)
- [New Object State](#newobjectstatelimitation)

#### User

`user/assign`:

- [SiteAccess](#siteaccesslimitation)

#### Workflow

`workflow/change_stage`:

- [Workflow Transition](#workflowtransitionlimitation)

## Limitation details

### BlockingLimitation

A generic Limitation type to use when no other Limitation has been implemented.
Without any Limitation assigned, a `LimitationNotFoundException` is thrown.

It is called "blocking" because it will always tell the permissions system that the User does not have access to any Policy it is assigned to, making the permissions system move on to the next Policy.

|                 |                                                                                       |
|-----------------|---------------------------------------------------------------------------------------|
| Identifier      | `n/a`           |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\BlockingLimitation`                 |
| Type Class      | `eZ\Publish\Core\Limitation\BlockingLimitationType`                                   |
| Criterion used  | MatchNone                                                                             |
| Role Limitation | no                                                                                    |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this Limitation in your own logic.|

### ContentTypeLimitation

Controls the User's access to Content based on its Content Type.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Content Type`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ContentTypeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId` |
| Role Limitation | no                                                                       |

This Limitation is available for all content-related Policies, as well as `section/assign`, and `state/assign`.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid ContentType IDs can be set as value(s)|

### LanguageLimitation

Allows the User to work only on the specified translation.

A user with this Limitation is allowed to:

- Create new content with the given translation(s) only.
This only applies to creating the first version of a Content item.
- Edit content by adding a new translation or modifying an existing translation.
- Publish content only when it results in adding or modifying an allowed translation.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `Language`                                                              |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LanguageLimitation`   |
| Type Class      | `eZ\Publish\Core\Limitation\LanguageLimitationType`                     |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LanguageCode` |
| Role Limitation | no                                                                      |

This Limitation is available for `content/create`, `content/edit`, and `content/hide` Policies

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

### LocationLimitation

Controls the User's access to Content based on its Location.
If the Limitation is used with `content/create`, the parent Location is taken into account.

|                 |                                                                       |
|-----------------|-----------------------------------------------------------------------|
| Identifier      | `Location`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LocationLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\LocationLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId` |
| Role Limitation | no                                                                    |

This Limitation is available for all content-related Policies except `content/manage_locations`.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid Location IDs can be set as value(s)|

### NewObjectStateLimitation

Controls the User's access to assigning a given `ObjectState` to content.

You can use it together with [`ObjectStateLimitation`](#objectstatelimitation) with the `state/assign` Policy.
`ObjectStateLimitation` defines content with which Object states the User can work with,
and `NewObjectStateLimitation` controls which Object state you can assign.

|                 |                                                                             |
|-----------------|-----------------------------------------------------------------------------|
| Identifier      | `NewState`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewObjectStateLimitationType`                   |
| Criterion used  | n/a                                                                         |
| Role Limitation | no                                                                          |

This Limitation is available for the `state/assign` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

### NewSectionLimitation

Controls the User's access to assigning a given Section to content.

You can use it together with [`SectionLimitation`](#sectionlimitation) with the `section/assign` Policy.
`SectionLimitation` defines content in which Section the User can work with,
and `NewSectionLimitation` controls which Section you can assign.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `NewSection`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewSectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewSectionLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

This Limitation is available for the `section/assign` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

### ObjectStateLimitation

Controls the User's access to Content based on its Object state.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `State`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ObjectStateLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateId` |
| Role Limitation | no                                                                       |

This Limitation is available for `content/read`, `content/edit`, `content/manage_locations`,
`content/hide`, and `content_remove` Policies.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid ObjectState IDs can be set as value(s)|

### OwnerLimitation

Specifies that only the owner of the Content item gets the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Owner`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\OwnerLimitation`                             |
| Type Class      | `eZ\Publish\Core\Limitation\OwnerLimitationType`                                               |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::OWNER )` |
| Role Limitation | no                                                                                             |

This Limitation is available for all content-related Policies except `content/create`, as well as `section/assign`, and `state/assign`.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

### ParentContentTypeLimitation

Controls the User's access to Content based on the Content Type of its parent.

This Limitation combined with `ContentType` Limitation enables you to define business rules like allowing Users to create "Blog Post" within a "Blog." If you also combine it with `Owner of Parent` Limitation, you only allow creating Blog Posts in the Users' own Blogs.

|                 |                                                                                |
|-----------------|--------------------------------------------------------------------------------|
| Identifier      | `Content Type of Parent`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentContentTypeLimitationType`                   |
| Criterion used  | n/a                                                                            |
| Role Limitation | no                                                                             |

This Limitation is available for the `content/create` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

### ParentDepthLimitation

Controls the User's access to Content based on its parent's depth in the Location tree.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Parent Depth`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentDepthLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentDepthLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

This Limitation is available for the `content/create` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

### ParentOwnerLimitation

Grants access only to Users who own all parent Locations of a Content item.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Owner of Parent`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentOwnerLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentOwnerLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

This Limitation is available for the `content/create` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner of all parent Locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

### ParentUserGroupLimitation

Grants access only to Users who have at least one *direct* User Group in common with the owner of the parent Location.

|                 |                                                                              |
|-----------------|------------------------------------------------------------------------------|
| Identifier      | `Parent User Group`                                                          |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentUserGroupLimitationType`                   |
| Criterion used  | n/a                                                                          |
| Role Limitation | no                                                                           |

This Limitation is available for the `content/create` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with owner of the parent Location gets access|

### SectionLimitation

Limits the User's access to Content within a specific Section.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Section`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SectionLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\SectionId` |
| Role Limitation | yes                                                                  |

This Limitation is available for all content-related Policies, as well as `section/assign`, and `state/assign`.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

### SiteAccessLimitation

Specifies to which SiteAccesses a certain permission applies.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `SiteAccess`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SiteAccessLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SiteAccessLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

This Limitation is available for the `user/login` Policy.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

#### Legacy compatibility notes

`SiteAccess` Limitation is deprecated and is not used actively in Public API, but is allowed for being able to read / create Limitations for legacy.

### StatusLimitation

Controls the User's access to Content based on the Content item's version status.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Status`                                                             |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\StatusLimitation`  |
| Type Class      | `eZ\Publish\Core\Limitation\StatusLimitationType`                    |
| Criterion used  | n/a                                                                  |
| Role Limitation | no                                                                   |

!!! caution

    This Limitation is not implemented for any existing Policy.
    However, you can use it in your own [custom Policy](../custom_policies.md#policyprovider).

#### Possible values

The Limitation takes as values Content item status constants from VersionInfo.

### SubtreeLimitation

Controls the User's access to Content based on a Subtree of Location.
If the Limitation is used with `content/create`, the parent Subtree of Location is taken into account.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Subtree of Location`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SubtreeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Subtree`   |
| Role Limitation | yes                                                                  |

This Limitation is available for all content-related Policies.

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

### UserGroupLimitation

Grants access only to Users who have at least one *direct* User Group in common with the owner.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Group`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\UserGroupLimitation`                         |
| Type Class      | `eZ\Publish\Core\Limitation\UserGroupLimitationType`                                           |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::GROUP )` |
| Role Limitation | no                                                                                             |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with the owner gets access|

### WorkflowStageLimitation

Limits the User's access to Content in a specific workflow stage.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `WorkflowStage`                                                                                |
| Value Class     | `API\Repository\Value\Limitation\WorkflowStageLimitation.php`                                  |
| Type Class      | `Core\Security\Limitation\WorkflowStageLimitationType.php`                                     |
| Role Limitation | no |

This Limitation is available for the `content/edit` Policy.

#### Possible values

The Limitation takes as values stages configured for the workflow.

### WorkflowTransitionLimitation

Grants the User permission to move content in a workflow through a specific transition.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `WorkflowTransition`                                                                           |
| Value Class     | `API\Repository\Value\Limitation\WorkflowTransitionLimitation.php`                             |
| Type Class      | `Core\Security\Limitation\WorkflowTransitionLimitationType.php`                                |
| Role Limitation | no |

This Limitation is available for the `workflow/change_stage` Policy.

#### Possible values

The Limitation takes as values transitions between stages configured for the workflow.
