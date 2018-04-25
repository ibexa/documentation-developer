# Limitations

Limitations are crucial building blocks of the permissions system in eZ Platform. They provide the restrictions you can apply to a given access right to limit the right according to certain conditions.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment. Currently this covers `Subtree` and `Section` Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see `eZ\Publish\SPI\Limitation\Type` interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

## Available Limitations

!!! tip

    Core Policies with Limitations are defined in [`EzPublishCoreBundle/Resources/config/policies.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/policies.yml).

### Module, function and limitations

Each Module contains functions, and for each function, you have Limitations. The default values are shown below.

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

## Limitation details

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

### BlockingLimitation

A generic Limitation type to use when no other Limitation has been implemented. Without any Limitation assigned, a LimitationNotFoundException is thrown.

It is called "blocking" because it will always tell the permissions system that the User does not have access to any Policy it is assigned to, making the permissions system move on to the next Policy.

|                 |                                                                                       |
|-----------------|---------------------------------------------------------------------------------------|
| Identifier      | `n/a` (configured for `ezjscore` limitation `FunctionList` out of the box)            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\BlockingLimitation`                 |
| Type Class      | `eZ\Publish\Core\Limitation\BlockingLimitationType`                                   |
| Criterion used  | MatchNone                                                                             |
| Role Limitation | no                                                                                    |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this Limitation in your own logic.|

#### Configuration

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

### ContentTypeLimitation

A Limitation to specify if the User has access to Content with a specific Content Type.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Class`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ContentTypeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId` |
| Role Limitation | no                                                                       |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid ContentType IDs can be set as value(s)|

### LanguageLimitation

A Limitation to specify if the User has access to Content in a specific language.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `Language`                                                              |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LanguageLimitation`   |
| Type Class      | `eZ\Publish\Core\Limitation\LanguageLimitationType`                     |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LanguageCode` |
| Role Limitation | no                                                                      |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

### LocationLimitation

A Limitation to specify if the User has access to Content with a specific Location, in case of `content/create` the parent Location is evaluated.

|                 |                                                                       |
|-----------------|-----------------------------------------------------------------------|
| Identifier      | `Node`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LocationLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\LocationLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId` |
| Role Limitation | no                                                                    |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid Location IDs can be set as value(s)|

### NewObjectStateLimitation

A Limitation to specify if the User has access to (assigning) a given `ObjectState` (to Content).

In the `state/assign` Policy you can combine this with `ObjectStateLimitation` to limit both from and to values.

|                 |                                                                             |
|-----------------|-----------------------------------------------------------------------------|
| Identifier      | `NewState`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewObjectStateLimitationType`                   |
| Criterion used  | n/a                                                                         |
| Role Limitation | no                                                                          |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

### NewSectionLimitation

A Limitation to specify if the User has access to (assigning) a given Section (to Content).

In the `section/assign` Policy you can combine this with `Section` Limitation to limit both from and to values.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `NewSection`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewSectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewSectionLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

### ObjectStateLimitation

A Limitation to specify if the User has access to Content with a specific ObjectState.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `State`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ObjectStateLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateId` |
| Role Limitation | no                                                                       |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid ObjectState IDs can be set as value(s)|

### OwnerLimitation

A Limitation to specify that only the owner of the Content item gets the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Owner`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\OwnerLimitation`                             |
| Type Class      | `eZ\Publish\Core\Limitation\OwnerLimitationType`                                               |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::OWNER )` |
| Role Limitation | no                                                                                             |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

### ParentContentTypeLimitation

A Limitation to specify if the User has access to Content whose parent Location contains a specific Content Type, used by `content/create`.

This Limitation combined with `ContentType` Limitation allows you to define business rules like allowing Users to create "Blog Post" within a "Blog." If you also combine it with `ParentOwner` Limitation, you effectively limit access to create Blog Posts in the Users' own Blogs.

|                 |                                                                                |
|-----------------|--------------------------------------------------------------------------------|
| Identifier      | `ParentClass`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentContentTypeLimitationType`                   |
| Criterion used  | n/a                                                                            |
| Role Limitation | no                                                                             |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

### ParentDepthLimitation

A Limitation to specify if the User has access to creating Content under a parent Location within a specific depth of the tree, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `ParentDepth`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentDepthLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentDepthLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

### ParentOwnerLimitation

A Limitation to specify that only the Users who own all parent Locations of a Content item get a certain access right, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `ParentOwner`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentOwnerLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentOwnerLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner of all parent Locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

### ParentUserGroupLimitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of the parent Location of a Content item get a certain access right, used by `content/create` permission.

|                 |                                                                              |
|-----------------|------------------------------------------------------------------------------|
| Identifier      | `ParentGroup`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentUserGroupLimitationType`                   |
| Criterion used  | n/a                                                                          |
| Role Limitation | no                                                                           |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with owner of the parent Location gets access|

### SectionLimitation

A Limitation to specify if the User has access to Content within a specific Section.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Section`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SectionLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\SectionId` |
| Role Limitation | yes                                                                  |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

### SiteAccessLimitation

A Limitation to specify to which SiteAccesses a certain permission applies, used by `user/login`.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `SiteAccess`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SiteAccessLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SiteAccessLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

#### Legacy compatibility notes

`SiteAccess` Limitation is deprecated and is not used actively in Public API, but is allowed for being able to read / create Limitations for legacy.

### SubtreeLimitation

A Limitation to specify if the User has access to Content within a specific subtree, in case of `content/create` the parent subtree is evaluated.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Subtree`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SubtreeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Subtree`   |
| Role Limitation | yes                                                                  |

#### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

### UserGroupLimitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of content get the selected access right.

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
