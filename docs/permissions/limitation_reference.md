---
description: Limitations let you fine-tune the permission system by specifying limits to roles granted to users.
page_type: reference
---

# Limitation reference

## Blocking limitation

A generic limitation type to use when no other limitation has been implemented.
Without any limitation assigned, a `LimitationNotFoundException` is thrown.

It's called "blocking" because it always informs the permissions system that the user doesn't have access to any policy the limitation is assigned to, making the permissions system move on to the next policy.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<mixed>`|`<mixed>`|This is a generic limitation which doesn't validate the values provided to it. Make sure that you validate the values passed to this limitation in your own logic.|

### Configuration

As this is a generic limitation, you can configure your custom limitations to use it.
Out of the box FunctionList uses it in the following way:

``` yaml
    # FunctionList is an ezjscore limitation, it only applies to ezjscore policies not used by
    # API/platform stack, so configure to use Blocking limitation to avoid LimitationNotFoundException
    ibexa.api.role.limitation_type.function_list:
        class: Ibexa\Core\Limitation\BlockingLimitationType
        arguments: ['FunctionList']
        tags:
            - {name: ibexa.permissions.limitation_type, alias: FunctionList}
```

## ActivityLogOwner limitation

The `ActivityLogOwner` limitation specifies if a user can see only their own [recent activity](recent_activity.md) log entries, and not entries from other users.

| Value | UI value        | Description                                                  |
|-------|-----------------|--------------------------------------------------------------|
| `1`   | "Only own logs" | Current user can only access their own activity log entries. |

## Cart Owner limitation

The Cart Owner `CartOwner` limitation specifies whether the user can modify a cart.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Only the user who is the owner of the cart gets access.|
|`null`| none |User can access all carts.|

## Change Owner limitation

The Change Owner (`ChangeOwner`) limitation specifies whether the user can change the owner of a content item.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"Forbid"|The user cannot change owner of a content item|

## Discount Owner limitation

The Discount Owner `DiscountOwner` limitation specifies whether the user can interact with a discount.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Only the user who is the owner of the discount gets access.|

## Content type Group limitation

The Content Type Group (`UserGroup`) limitation specifies that only users with at least one common *direct* user group with the owner of content get the selected access right.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a user who has at least one common *direct* user group with the owner gets access|

## Content type Group of Parent limitation

The Content Type Group of Parent (`ParentUserGroupLimitation`) limitation specifies that only Users with at least one common *direct* user group with the owner of the parent location of a content item get a certain access right, used by `content/create` permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only a user who has at least one common *direct* user group with owner of the parent location gets access|

## Content type limitation

The Content Type (`ContentType`) limitation specifies whether the user has access to content with a specific content type.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid content type IDs can be set as value(s)|

## Content type of Parent limitation

The Content Type of Parent (`ParentContentType`) limitation specifies whether the user has access to content whose parent location contains a specific content type, used by `content/create`.

This limitation combined with `ContentType` limitation allows you to define business rules like allowing users to create "Blog Post" within a "Blog."
If you also combine it with `Owner of Parent` limitation, you effectively limit access to create Blog Posts in the users' own Blogs.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid content type IDs can be set as value(s)|

## Field Group limitation [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

A Field Group (`FieldGroup`) limitation specifies whether the user can work with content fields belonging to a specific group.
A user with this limitation is allowed to edit fields belonging to the indicated group.
Otherwise, the fields are inactive and filled with the default value (if set).

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<FieldGroup_identifier>`|`<FieldGroup_identifier>`|All valid field group identifiers can be set as value(s)|

## Language limitation

A Language (`Language`) limitation specifies whether the user has access to work on the specified translation.

A user with this limitation is allowed to:

- Create new content with the given translation(s) only. This only applies to creating the first version of a content item.
- Edit content by adding a new translation or modifying an existing translation.
- Publish content only when it results in adding or modifying an allowed translation.
- Delete content only when it contains a translation into the specified language.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Language_code>`|`<LanguageCode_name>`|All valid language codes can be set as value(s)|

## Location limitation

A location (`Location`) limitation specifies whether the user has access to content with a specific location, in case of `content/create` the parent location is evaluated.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_id>`|`<Location_name>`|All valid location IDs can be set as value(s)|

## New Section limitation

A New Section (`NewSection`) limitation specifies whether the user has access to assigning content to a given section.

In the `section/assign` policy you can combine this with section limitation to limit both from and to values.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## New State limitation

A New State (`NewObjectState`) limitation specifies whether the user has access to (assigning) a given object state to content.

In the `state/assign` policy you can combine this with State limitation to limit both from and to values.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<State_id>`|`<State_name>`|All valid state IDs can be set as value(s)|

## Object State limitation

The Object State (`ObjectState`) limitation specifies whether the user has access to content with a specific object state.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ObjectState_id>`|`<ObjectState_name>`|All valid Object state IDs can be set as value(s)|

## Order Owner limitation

The Order Owner (`OrderOwner`) limitation specifies whether the user can modify an order.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own orders. |

## Owner limitation

The Owner (`Owner`) limitation specifies that only the owner of the content item gets the selected access right.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the user who is the owner gets access|
|`2`|"session"|Deprecated and works exactly like "self" in public PHP API since it has no knowledge of user Sessions|

## Owner of Parent limitation

The Owner of Parent (`ParentOwner`) limitation specifies that only the users who own all parent locations of a content item get a certain access right, used for `content/create` permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`1`|"self"|Only the user who is the owner of all parent locations gets access|
|`2`|"session"|Deprecated and works exactly like "self" in public PHP API since it has no knowledge of user Sessions|

## Parent Depth limitation

The Parent Depth (`ParentDepth`) limitation specifies whether the user has access to creating content under a parent location within a specific depth of the tree, used for `content/create` permission.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<int>`|`<int>`|All valid integers can be set as value(s)|

## PaymentOwner limitation

The Payment Owner (`PaymentOwner`) limitation specifies whether the user can modify a payment.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own payments. |
|"all"| none |Users can access all payments.|

## Personalization access limitation

The Personalization limitation specifies the SiteAccesses for which the user can view or modify the scenario configuration.

## Product Type limitation

The Product Type (`ProductType`) limitation specifies whether the user has access to products belonging to a specific product type.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<ContentType_id>`|`<ContentType_name>`|All valid content type IDs can be set as value(s)|

## Section limitation

The Section (`Section`) limitation specifies whether the user has access to content within a specific section.

This limitation can be used as a role limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Session_id>`|`<Session_name>`|All valid session IDs can be set as value(s)|

## Segment group limitation [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

The segment group (`SegmentGroup`) limitation specifies whether the user has access segments within a specific segment group.

This limitation can be used as a role limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Segment_group_id>`|`<Segment_group_name>`|All valid segment group IDs can be set as value(s).|

## SiteAccess limitation

The SiteAccess (`SiteAccess`) limitation specifies to which SiteAccesses a certain permission applies, used by `user/login`.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<siteaccess_hash>`|`<siteaccess_name>`|Hash is calculated in the following way in legacy in default 64bit mode: `sprintf( '%u', crc32( $siteAccessName ) )`|

### Legacy compatibility notes

`SiteAccess` limitation is deprecated and isn't used actively in public PHP API, but is allowed for being able to read / create limitations for legacy.

## Shipment Owner limitation

The Shipment Owner (`ShipmentOwner`) limitation specifies whether the user can modify a shipment.

### Possible values

|Value|UI value|Description|
|------|------|------|
|"self"|"self"|Users can access only their own shipments. |

## Subtree limitation

The subtree (`Subtree`) limitation specifies whether the user has access to content within a specific subtree of location, in case of `content/create` the parent subtree of location is evaluated.

This limitation can be used as a role limitation.

### Possible values

|Value|UI value|Description|
|------|------|------|
|`<Location_pathString>`|`<Location_name>`|All valid location `pathStrings` can be set as value(s)|

### Usage notes

For more information on how to restrict user's access to part of the subtree, see [the example in the Admin management section](permission_use_cases.md#restrict-editing-to-part-of-the-tree).

## Version Lock limitation

The Version Lock (`VersionLock`) limitation specifies whether the user can perform actions, for example, edit or unlock, on content items that are in a workflow.

This limitation can be used as a role limitation.

### Possible values

| Value | UI value | Description |
|------|------|------|
| `userId` | "Assigned only" | Users can perform actions only on content items that are assigned to them or not assigned to anybody. |
| `null` | none | Users can perform actions on all drafts, regardless of the assignments or whether drafts are locked or not. |

## Workflow Stage limitation

The Workflow Stage (`WorkflowStage`) limitation specifies whether the user can edit content in a specific workflow stage.

### Possible values

The limitation takes as values stages configured for the workflow.

## Workflow Transition limitation

The Workflow Transition (`WorkflowTransition`) limitation specifies whether the user can move the content in a workflow through a specific transition.

### Possible values

The limitation takes as values transitions between stages configured for the workflow.
