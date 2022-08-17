---
description: Data migration actions enable you to run special operations while executing data migrations, such as assigning Roles, Sections, Objects states, and so on.
---

# Data migration actions

Some migration steps can contain a special `actions` property.
You can find which migration steps support actions in the table below:

||`create`|`update`|`delete`|
|---|:---:|:---:|:---:|
|`content`|&#10004;|&#10004;|&#10004;|
|`content_type`|&#10004;|&#10004;|&#10004;|
|`role`|&#10004;|&#10004;||
|`user`|&#10004;|&#10004;||
|`user_group`|&#10004;|&#10004;||

Actions are optional operations that can be run after the main "body" of a migration has been executed
(that is, content has been created / updated, Object state has been added, and so on).
Their purpose is to allow additional operations to be performed as part of this particular migration.
They are executed inside the same transaction, so in the event of failure they cause database rollback to occur.

For example, when updating a Content Type object, some fields might be removed:
``` yaml
-
    type: content_type
    mode: update
    match:
        field: content_type_identifier
        value: article
    actions:
        - { action: assign_content_type_group, value: 'Media' }
        - { action: unassign_content_type_group, value: 'Content' }
        - { action: remove_field_by_identifier, value: 'short_title' }
        - { action: remove_drafts, value: null }
```

When executed, this migration:

- Finds Content Type using its identifier (`article`)
- Assigns Content Type Group "Media"
- Removes it from Content Type Group "Content"
- Removes the `short_title` Field
- Removes its existing drafts, if any.

## Available migration actions

The following migration actions are available out of the box:

- `assign_object_state` (Content Create)
- `assign_parent_location` (Content Create / Update)
- `assign_section` (Content Update)
- `hide` (Content Create / Update)
- `reveal` (Content Create / Update)
- `assign_content_type_group` (Content Type Create / Update)
- `remove_drafts` (Content Type Update)
- `remove_field_by_identifier` (Content Type Update)
- `unassign_content_type_group` (Content Type Update)
- `assign_role_to_user` (Role Create / Update)
- `assign_role_to_user_group` (Role Create / Update)
- `assign_user_to_role` (User Create / Update)
- `assign_user_group_to_role` (User Group Create / Update)
- `unassign_role_user_group` (User Group Update)

In contrast with Kaliop migrations, actions provide you with ability to perform additional operations and extend
the migration functionality. 
See [creating your own Actions](create_data_migration_action.md).

## Action usage examples

### Content

mode: Create
``` yaml
    actions:
        - { action: assign_object_state, identifier: locked, groupIdentifier: ez_lock }
        - { action: assign_parent_location, value: 2 }
        - { action: hide }
```

mode: Update
``` yaml
    actions:
        - { action: assign_parent_location, value: 2 }
        - { action: assign_section, id: 4 }
        - { action: assign_section, identifier: 'media' }
```

### Content Types

mode: Create
``` yaml
    actions:
        - { action: assign_content_type_group, value: 'Media' }
```

mode: Update
``` yaml
    actions:
        - { action: assign_content_type_group, value: 'Media' }
        - { action: unassign_content_type_group, value: 'Content' }
        - { action: remove_field_by_identifier, value: 'short_title' }
        - { action: remove_drafts, value: null }
```

### Roles

mode: Create and Update
``` yaml
    actions:
        -
            action: assign_role_to_user_group
            remote_id: 'remote_id_152454854'
        -
            action: assign_role_to_user_group
            id: 42
        -
            action: assign_role_to_user
            id: 42
        -
            action: assign_role_to_user
            email: 'mail@invalid.c'
        -
            action: assign_role_to_user
            login: foo
```

### Users

mode: Create and Update
``` yaml
    actions: 
        -   
            action: assign_user_to_role
            identifier: foo
        -   
            action: assign_user_to_role
            id: 2
        -   
            action: assign_user_to_role
            id: 2
            limitation:
                type: Section
                values:
                    - 1
```

### User Groups

mode: Create and Update
``` yaml
    actions:
        -
            action: assign_user_group_to_role
            identifier: Editor
        -
            action: assign_user_group_to_role
            id: 2
        -   
            action: assign_user_group_to_role
            id: 1
            limitation:
                type: Section
                values:
                    - 1
```
!!! note

    In the `assign_user_group_to_role` action, Limitation type Section can only use Section ID:

mode: Update
``` yaml
    actions:
        -
            action: unassign_role_user_group
            id: 1
```

!!! note

    In the `unassign_role_user_group` action, the ID is Role assignment ID from the `ezuser_role` table.
