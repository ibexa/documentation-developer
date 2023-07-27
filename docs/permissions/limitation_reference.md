---
description: Limitations let you fine-tune the permission system by specifying limits to Roles granted to users.
page_type: reference
---

# Limitation reference

## Blocking Limitation

A generic Limitation type to use when no other Limitation has been implemented.
Without any Limitation assigned, a `LimitationNotFoundException` is thrown.

It is called "blocking" because it always informs the permissions system that 
the User does not have access to any Policy the Limitation is assigned to, making 
the permissions system move on to the next Policy.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic Limitation which does not validate the values provided to it. Make sure that you validate the values passed to this Limitation in your own logic.|

### Configuration

As this is a generic Limitation, you can configure your custom Limitations to use it.
Out of the box FunctionList uses it in the following way:

``` yaml
    # FunctionList is an ezjscore limitation, it only applies to ezjscore policies not used by
    # API/platform stack, so configure to use Blocking Limitation to avoid LimitationNotFoundException
    ibexa.api.role.limitation_type.function_list:
        class: Ibexa\Core\Limitation\BlockingLimitationType
        arguments: ['FunctionList']
        tags:
            - {name: ibexa.permissions.limitation_type, alias: FunctionList}
```

## CartOwner Limitation

The `CartOwner` Limitation specifies whether the user can modify a cart.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Only the User who is the owner of the cart gets access.|
|`null`| none |User can access all carts.|

## Change Owner Limitation

The Change Owner (`ChangeOwner`) Limitation specifies whether the user can change the owner of a Content item.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"Forbid"|The user cannot change owner of a Content item|

## Content Type Group Limitation

The Content Type Group (`UserGroup`) Limitation specifies that only Users with at least one common *direct* User 
Group with the owner of content get the selected access right.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with the owner gets access|

## Content Type Group of Parent Limitation

The Content Type Group of Parent (`ParentUserGroupLimitation`) Limitation specifies that only Users with at least one common *direct* User Group 
with the owner of the parent Location of a Content item get a certain access right, 
used by `content/create` permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a User who has at least one common *direct* User Group with owner of the parent Location gets access|

## Content Type Limitation

The Content Typ (`ContentType`) Limitation specifies whether the User has access to content with a specific 
Content Type.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

## Content Type of Parent Limitation

The Content Type of Parent (`ParentContentType`) Limitation specifies whether the User has access to content whose parent Location 
contains a specific Content Type, used by `content/create`.

This Limitation combined with `ContentType` Limitation allows you to define business 
rules like allowing Users to create "Blog Post" within a "Blog." 
If you also combine it with `Owner of Parent` Limitation, you effectively limit 
access to create Blog Posts in the Users' own Blogs.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

## Field Group Limitation [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

A Field Group (`FieldGroup`) Limitation specifies whether the User can work with content Fields belonging 
to a specific group.
A user with this Limitation is allowed to edit Fields belonging to the indicated group.
Otherwise, the Fields are inactive and filled with the default value (if set).

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<FieldGroup_identifier>`|`<FieldGroup_identifier>`|All valid Field group identifiers can be set as value(s)|

## Language Limitation

A Language (`Language`) Limitation specifies whether the User has access to work on the specified translation.

A user with this Limitation is allowed to:

 - Create new content with the given translation(s) only.
This only applies to creating the first version of a Content item.
- Edit content by adding a new translation or modifying an existing translation.
- Publish content only when it results in adding or modifying an allowed translation.
- Delete content only when it contains a translation into the specified language.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

## Location Limitation

A Location (`Location`) Limitation specifies whether the User has access to content with a specific 
Location, in case of `content/create` the parent Location is evaluated.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid Location IDs can be set as value(s)|

## New Section Limitation

A New Section (`NewSection`) Limitation specifies whether the User has access to assigning content to a given Section.

In the `section/assign` Policy you can combine this with Section Limitation to 
limit both from and to values.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## New State Limitation

A New State (`NewObjectState`) Limitation specifies whether the User has access to (assigning) a given Object 
state to content.

In the `state/assign` Policy you can combine this with State Limitation to limit 
both from and to values.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

## Object State Limitation

The Object State (`ObjectState`) Limitation specifies whether the User has access to content with a specific 
Object state.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid Object state IDs can be set as value(s)|

## Order Owner Limitation

The Order Owner (`OrderOwner`) Limitation specifies whether the user can modify an order.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own orders. |

## Owner Limitation

The Owner (`Owner`) Limitation specifies that only the owner of the Content item gets the selected 
access right.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

## Owner of Parent Limitation

The Owner of Parent (`ParentOwner`) Limitation specifies that only the Users who own all parent Locations of 
a Content item get a certain access right, used for `content/create` permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the User who is the owner of all parent Locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in Public API since it has no knowledge of user Sessions|

## Parent Depth Limitation

The Parent Depth (`ParentDepth`) Limitation specifies whether the User has access to creating content under 
a parent Location within a specific depth of the tree, used for `content/create` 
permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

## PaymentOwner Limitation

The Payment Owner (`PaymentOwner`) Limitation specifies whether the user can modify a payment.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own payments. |
|"all"| none |Users can access all payments.|

## Personalization access Limitation

The Personalization Limitation specifies the SiteAccesses for which the User can view or modify 
the scenario configuration.

## Product Type Limitation

The Product Type (`ProductType`) Limitation specifies whether the User has access to products belonging to a specific Product Type.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid Content Type IDs can be set as value(s)|

## Section Limitation

The Section (`Section`) Limitation specifies whether the User has access to content within a specific 
Section.

This Limitation can be used as a Role Limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## Segment Group Limitation [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

The Segment Group (`SegmentGroup`) Limitation specifies whether the User has access Segments within a specific 
Segment Group.

This Limitation can be used as a Role Limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Segment_group_id>`|`<Segment_group_name>`|All valid Segment Group IDs can be set as value(s).|

## SiteAccess Limitation

The SiteAccess (`SiteAccess`) Limitation specifies to which SiteAccesses a certain permission applies, used 
by `user/login`.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

### Legacy compatibility notes

`SiteAccess` Limitation is deprecated and is not used actively in Public API, 
but is allowed for being able to read / create Limitations for legacy.

## Shipment Owner Limitation

The Shipment Owner (`ShipmentOwner`) Limitation specifies whether the user can modify a shipment.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own shipments. |

## Subtree Limitation

The Subtree (`Subtree`) Limitation specifies whether the User has access to content within a specific 
Subtree of Location, in case of `content/create` the parent Subtree of Location 
is evaluated.

This Limitation can be used as a Role Limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

### Usage notes

For more information on how to restrict User's access to part of the Subtree 
follow [the example in the Admin management section](permission_use_cases.md#restrict-editing-to-part-of-the-tree).

## Version Lock Limitation

The Version Lock (`VersionLock`) Limitation specifies whether the User can perform actions, for example, edit 
or unlock, on Content items that are in a workflow.

This Limitation can be used as a Role Limitation.

### Possible values

| Value | UI value | Description |
|------|------|------|
| `userId` | "Assigned only" | Users can perform actions only on Content items that are assigned to them or not assigned to anybody. |
| `null` | none | Users can perform actions on all drafts, regardless of the assignments or whether drafts are locked or not. |

## Workflow Stage Limitation

The Workflow Stage (`WorkflowStage`) Limitation specifies whether the User can edit content in a specific workflow 
stage.

### Possible values

The Limitation takes as values stages configured for the workflow.

## Workflow Transition Limitation

The Workflow Transition (`WorkflowTransition`) Limitation specifies whether the User can move the content in a workflow through 
a specific transition.

### Possible values

The Limitation takes as values transitions between stages configured for the workflow.
