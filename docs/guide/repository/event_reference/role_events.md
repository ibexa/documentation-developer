---
description: Events that are triggered when working with Roles.
---

# Role events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateRoleDraftEvent`|`RoleService::createRoleDraft`|`Role $role`</br>`RoleDraft|null $roleDraft`|
|`CreateRoleDraftEvent`|`RoleService::createRoleDraft`|`Role $role`</br>`RoleDraft $roleDraft`|
|`BeforeCreateRoleEvent`|`RoleService::createRole`|`RoleCreateStruct $roleCreateStruct`</br>`RoleDraft|null $roleDraft`|
|`CreateRoleEvent`|`RoleService::createRole`|`RoleCreateStruct $roleCreateStruct`</br>`RoleDraft $roleDraft`|
|`BeforeUpdateRoleDraftEvent`|`RoleService::updateRoleDraft`|`RoleDraft $roleDraft`</br>`RoleUpdateStruct $roleUpdateStruct`</br>`RoleDraft|null $updatedRoleDraft`|
|`UpdateRoleDraftEvent`|`RoleService::updateRoleDraft`|`RoleDraft $roleDraft`</br>`RoleUpdateStruct $roleUpdateStruct`</br>`RoleDraft $updatedRoleDraft`|
|`BeforeCopyRoleEvent`|`RoleService::copyRole`|`Role $role`</br>`RoleCopyStruct $roleCopyStruct`</br>`Role|null $copiedRole`|
|`CopyRoleEvent`|`RoleService::copyRole`|`Role $copiedRole`</br>`Role $role`</br>`RoleCopyStruct $roleCopyStruct`|
|`BeforePublishRoleDraftEvent`|`RoleService::publishRoleDraft`|`RoleDraft $roleDraft`|
|`PublishRoleDraftEvent`|`RoleService::publishRoleDraft`|`RoleDraft $roleDraft`|
|`BeforeDeleteRoleDraftEvent`|`RoleService::deleteRoleDraft`|`RoleDraft $roleDraft`|
|`DeleteRoleDraftEvent`|`RoleService::deleteRoleDraft`|`RoleDraft $roleDraft`|
|`BeforeDeleteRoleEvent`|`RoleService::deleteRole`|`Role $role`|
|`DeleteRoleEvent`|`RoleService::deleteRole`|`Role $role`|

## Adding Policies

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAddPolicyByRoleDraftEvent`|`RoleService::addPolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyCreateStruct $policyCreateStruct`</br>`RoleDraft|null $updatedRoleDraft`|
|`AddPolicyByRoleDraftEvent`|`RoleService::addPolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyCreateStruct $policyCreateStruct`</br>`private $updatedRoleDraft`|
|`BeforeUpdatePolicyByRoleDraftEvent`|`RoleService::updatePolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyDraft $policy`</br>`PolicyUpdateStruct $policyUpdateStruct`</br>`PolicyDraft|null $updatedPolicyDraft`|
|`UpdatePolicyByRoleDraftEvent`|`RoleService::updatePolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyDraft $policy`</br>`PolicyUpdateStruct $policyUpdateStruct`</br>`PolicyDraft $updatedPolicyDraft`|
|`BeforeRemovePolicyByRoleDraftEvent`|`RoleService::removePolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyDraft $policyDraft`</br>`RoleDraft|null $updatedRoleDraft`|
|`RemovePolicyByRoleDraftEvent`|`RoleService::removePolicyByRoleDraft`|`RoleDraft $roleDraft`</br>`PolicyDraft $policyDraft`</br>`RoleDraft $updatedRoleDraft`|

## Assigning Roles

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignRoleToUserEvent`|`RoleService::assignRoleToUser`|`Role $role`</br>`User $user`</br>`Limitation\RoleLimitation $roleLimitation`|
|`AssignRoleToUserEvent`|`RoleService::assignRoleToUser`|`Role $role`</br>`User $user`</br>`Limitation\RoleLimitation $roleLimitation`|
|`BeforeAssignRoleToUserGroupEvent`|`RoleService::assignRoleToUserGroup`|`Role $role`</br>`UserGroup $userGroup`</br>`Limitation\RoleLimitation $roleLimitation`|
|`AssignRoleToUserGroupEvent`|`RoleService::assignRoleToUserGroup`|`Role $role`</br>`UserGroup $userGroup`</br>`Limitation\RoleLimitation $roleLimitation`|
|`BeforeRemoveRoleAssignmentEvent`|`RoleService::removeRoleAssignment`|`RoleAssignment $roleAssignment`|
|`RemoveRoleAssignmentEvent`|`RoleService::removeRoleAssignment`|`RoleAssignment $roleAssignment`|
