# Limitation reference

## Blocking Limitation

A generic Limitation type to use when no other Limitation has been implemented.
Without any Limitation assigned, a `LimitationNotFoundException` is thrown.

It is called "blocking" because it will always tell the permissions system that the User does not have access to any Policy the Limitation is assigned to, making the permissions system move on to the next Policy.

|                 |                                                                                       |
|-----------------|---------------------------------------------------------------------------------------|
| Identifier      | `n/a` (configured for `ezjscore` limitation `FunctionList` out of the box)            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\BlockingLimitation`                 |
| Type Class      | `eZ\Publish\Core\Limitation\BlockingLimitationType`                                   |
| Criterion used  | MatchNone                                                                             |
| Role Limitation | no                                                                                    |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this Limitation in your own logic.|

### Configuration

As this is a generic Limitation, you can configure your custom Limitations to use it.
Out of the box FunctionList uses it in the following way:

``` yaml
    # FunctionList is an ezjscore limitation, it only applies to ezjscore policies not used by
    # API/platform stack, so configure to use Blocking Limitation to avoid LimitationNotFoundException
    ezpublish.api.role.limitation_type.function_list:
        class: '%ezpublish.api.role.limitation_type.blocking.class%'
        arguments: ['FunctionList']
        tags:
            - {name: ezpublish.limitationType, alias: FunctionList}
```

## Content Type Group Limitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of content get the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Group`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\UserGroupLimitation`                         |
| Type Class      | `eZ\Publish\Core\Limitation\UserGroupLimitationType`                                           |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::GROUP )` |
| Role Limitation | no                                                                                             |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with the owner gets access|


## Content Type Group of Parent Limitation

A Limitation to specify that only Users with at least one common *direct* User Group with the owner of the parent Location of a Content item get a certain access right, used by `content/create` permission.

|                 |                                                                              |
|-----------------|------------------------------------------------------------------------------|
| Identifier      | `Content Type Group of Parent`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentUserGroupLimitationType`                   |
| Criterion used  | n/a                                                                          |
| Role Limitation | no                                                                           |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with owner of the parent Location gets access|

## Content Type Limitation

A Limitation to specify if the User has access to content with a specific Content Type.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Content Type`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ContentTypeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId` |
| Role Limitation | no                                                                       |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|


## Content Type of Parent Limitation

A Limitation to specify if the User has access to content whose parent Location contains a specific Content Type, used by `content/create`.

This Limitation combined with `ContentType` Limitation allows you to define business rules like allowing Users to create "Blog Post" within a "Blog." If you also combine it with `Owner of Parent` Limitation, you effectively limit access to create Blog Posts in the Users' own Blogs.

|                 |                                                                                |
|-----------------|--------------------------------------------------------------------------------|
| Identifier      | `Content Type of Parent`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentContentTypeLimitationType`                   |
| Criterion used  | n/a                                                                            |
| Role Limitation | no                                                                             |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

## Field Group Limitation [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

A Limitation to specify if the User can work with content Fields belonging to a specific group.
A user with this Limitation is allowed to edit Fields belonging to the indicated group.
Otherwise, the Fields are inactive and filled with the default value (if set).

|                 |                                                                                |
|-----------------|--------------------------------------------------------------------------------|
| Identifier      | `Field Group`                                                                  |
| Value Class     | `Ibexa\Platform\Contracts\Permissions\Repository\Values\User\Limitation\FieldGroupLimitation` |
| Type Class      | `Ibexa\Platform\Permissions\Security\Limitation\FieldGroupLimitationType ` |
| Criterion used  | n/a                                                                            |
| Role Limitation | no                                                                             |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<FieldGroup_identifier>`|`<FieldGroup_identifier>`|All valid Field group identifiers can be set as value(s)|

## Language Limitation

A Limitation to specify if the User has access to work on the specified translation.

A user with this Limitation is allowed to:

 - Create new content with the given translation(s) only.
This only applies to creating the first version of a Content item.
- Edit content by adding a new translation or modifying an existing translation.
- Publish content only when it results in adding or modifying an allowed translation.
- Delete content only when it contains a translation into the specified language.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `Language`                                                              |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LanguageLimitation`   |
| Type Class      | `eZ\Publish\Core\Limitation\LanguageLimitationType`                     |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LanguageCode` |
| Role Limitation | no                                                                      |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

## Location Limitation

A Limitation to specify if the User has access to content with a specific Location, in case of `content/create` the parent Location is evaluated.

|                 |                                                                       |
|-----------------|-----------------------------------------------------------------------|
| Identifier      | `Location`                                                                |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\LocationLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\LocationLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId` |
| Role Limitation | no                                                                    |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid Location IDs can be set as value(s)|

## New Section Limitation

A Limitation to specify if the User has access to assigning content to a given Section.

In the `section/assign` Policy you can combine this with Section Limitation to limit both from and to values.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `NewSection`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewSectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewSectionLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## New State Limitation

A Limitation to specify if the User has access to (assigning) a given Object state to content.

In the `state/assign` Policy you can combine this with State Limitation to limit both from and to values.

|                 |                                                                             |
|-----------------|-----------------------------------------------------------------------------|
| Identifier      | `NewState`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\NewObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\NewObjectStateLimitationType`                   |
| Criterion used  | n/a                                                                         |
| Role Limitation | no                                                                          |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

## State Limitation

A Limitation to specify if the User has access to content with a specific Object state.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `State`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ObjectStateLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ObjectStateLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateId` |
| Role Limitation | no                                                                       |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid Object state IDs can be set as value(s)|

## Owner Limitation

A Limitation to specify that only the owner of the Content item gets the selected access right.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `Owner`                                                                                        |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\OwnerLimitation`                             |
| Type Class      | `eZ\Publish\Core\Limitation\OwnerLimitationType`                                               |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::OWNER )` |
| Role Limitation | no                                                                                             |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

## Owner of Parent Limitation

A Limitation to specify that only the Users who own all parent Locations of a Content item get a certain access right, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Owner of Parent`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentOwnerLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentOwnerLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner of all parent Locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

## Parent Depth Limitation

A Limitation to specify if the User has access to creating content under a parent Location within a specific depth of the tree, used for `content/create` permission.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Parent Depth`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ParentDepthLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ParentDepthLimitationType`                   |
| Criterion used  | n/a                                                                      |
| Role Limitation | no                                                                       |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

## Section Limitation

A Limitation to specify if the User has access to content within a specific Section.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Section`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SectionLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\SectionId` |
| Role Limitation | yes                                                                  |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## Segment Group Limitation

A Limitation to specify whether the User has access Segments within a specific Segment Group.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `SegmentGroup`                                                       |
| Value Class     | `Ibexa\Platform\Segmentation\Permission\Limitation\Value\SegmentGroupLimitation` |
| Type Class      | `Ibexa\Platform\Segmentation\Permission\Limitation\SegmentGroupLimitationType ` |
| Criterion used  | n/a |
| Role Limitation | yes                                                                  |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Segment_group_id>`|`<Segment_group_name>`|All valid Segment Group IDs can be set as value(s).|

## SiteAccess Limitation

A Limitation to specify to which SiteAccesses a certain permission applies, used by `user/login`.

|                 |                                                                         |
|-----------------|-------------------------------------------------------------------------|
| Identifier      | `SiteAccess`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SiteAccessLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SiteAccessLimitationType`                   |
| Criterion used  | n/a                                                                     |
| Role Limitation | no                                                                      |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

### Legacy compatibility notes

`SiteAccess` Limitation is deprecated and is not used actively in Public API, but is allowed for being able to read / create Limitations for legacy.

## Subtree of Location Limitation

A Limitation to specify if the User has access to content within a specific Subtree of Location, in case of `content/create` the parent Subtree of Location is evaluated.

|                 |                                                                      |
|-----------------|----------------------------------------------------------------------|
| Identifier      | `Subtree of Location`                                                            |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\SubtreeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Subtree`   |
| Role Limitation | yes                                                                  |

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

### Usage notes

For more information on how to restrict User's access to part of the Subtree follow [the example in the Admin management section](admin_panel.md#restrict-editing-to-part-of-the-tree).

## Workflow Stage Limitation

A Limitation to specify if the User can edit content in a specific workflow stage.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `WorkflowStage`                                                                                |
| Value Class     | `API\Repository\Value\Limitation\WorkflowStageLimitation.php`                                  |
| Type Class      | `Core\Security\Limitation\WorkflowStageLimitationType.php`                                     |
| Role Limitation | no |

### Possible values

The Limitation takes as values stages configured for the workflow.

## Workflow Transition Limitation

A Limitation to specify if the User can move the content in a workflow through a specific transition.

|                 |                                                                                                |
|-----------------|------------------------------------------------------------------------------------------------|
| Identifier      | `WorkflowTransition`                                                                           |
| Value Class     | `API\Repository\Value\Limitation\WorkflowTransitionLimitation.php`                             |
| Type Class      | `Core\Security\Limitation\WorkflowTransitionLimitationType.php`                                |
| Role Limitation | no |

### Possible values

The Limitation takes as values transitions between stages configured for the workflow.
