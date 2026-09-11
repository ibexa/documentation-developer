# Role events

Events that are triggered when working with roles.

| Event                         | Dispatched by                   | Properties                                                                                 |
| ----------------------------- | ------------------------------- | ------------------------------------------------------------------------------------------ |
| `BeforeCreateRoleDraftEvent`  | `RoleService::createRoleDraft`  | `Role $role` `?RoleDraft $roleDraft`                                                       |
| `CreateRoleDraftEvent`        | `RoleService::createRoleDraft`  | `Role $role` `RoleDraft $roleDraft`                                                        |
| `BeforeCreateRoleEvent`       | `RoleService::createRole`       | `RoleCreateStruct $roleCreateStruct` `?RoleDraft $roleDraft`                               |
| `CreateRoleEvent`             | `RoleService::createRole`       | `RoleCreateStruct $roleCreateStruct` `RoleDraft $roleDraft`                                |
| `BeforeUpdateRoleDraftEvent`  | `RoleService::updateRoleDraft`  | `RoleDraft $roleDraft` `RoleUpdateStruct $roleUpdateStruct` `?RoleDraft $updatedRoleDraft` |
| `UpdateRoleDraftEvent`        | `RoleService::updateRoleDraft`  | `RoleDraft $roleDraft` `RoleUpdateStruct $roleUpdateStruct` `RoleDraft $updatedRoleDraft`  |
| `BeforeCopyRoleEvent`         | `RoleService::copyRole`         | `Role $role` `RoleCopyStruct $roleCopyStruct` `?Role $copiedRole`                          |
| `CopyRoleEvent`               | `RoleService::copyRole`         | `Role $copiedRole` `Role $role` `RoleCopyStruct $roleCopyStruct`                           |
| `BeforePublishRoleDraftEvent` | `RoleService::publishRoleDraft` | `RoleDraft $roleDraft`                                                                     |
| `PublishRoleDraftEvent`       | `RoleService::publishRoleDraft` | `RoleDraft $roleDraft`                                                                     |
| `BeforeDeleteRoleDraftEvent`  | `RoleService::deleteRoleDraft`  | `RoleDraft $roleDraft`                                                                     |
| `DeleteRoleDraftEvent`        | `RoleService::deleteRoleDraft`  | `RoleDraft $roleDraft`                                                                     |
| `BeforeDeleteRoleEvent`       | `RoleService::deleteRole`       | `Role $role`                                                                               |
| `DeleteRoleEvent`             | `RoleService::deleteRole`       | `Role $role`                                                                               |

## Adding policies

| Event                                | Dispatched by                          | Properties                                                                                                               |
| ------------------------------------ | -------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `BeforeAddPolicyByRoleDraftEvent`    | `RoleService::addPolicyByRoleDraft`    | `RoleDraft $roleDraft` `PolicyCreateStruct $policyCreateStruct` `?RoleDraft $updatedRoleDraft`                           |
| `AddPolicyByRoleDraftEvent`          | `RoleService::addPolicyByRoleDraft`    | `RoleDraft $roleDraft` `PolicyCreateStruct $policyCreateStruct` `private $updatedRoleDraft`                              |
| `BeforeUpdatePolicyByRoleDraftEvent` | `RoleService::updatePolicyByRoleDraft` | `RoleDraft $roleDraft` `PolicyDraft $policy` `PolicyUpdateStruct $policyUpdateStruct` `?PolicyDraft $updatedPolicyDraft` |
| `UpdatePolicyByRoleDraftEvent`       | `RoleService::updatePolicyByRoleDraft` | `RoleDraft $roleDraft` `PolicyDraft $policy` `PolicyUpdateStruct $policyUpdateStruct` `PolicyDraft $updatedPolicyDraft`  |
| `BeforeRemovePolicyByRoleDraftEvent` | `RoleService::removePolicyByRoleDraft` | `RoleDraft $roleDraft` `PolicyDraft $policyDraft` `?RoleDraft $updatedRoleDraft`                                         |
| `RemovePolicyByRoleDraftEvent`       | `RoleService::removePolicyByRoleDraft` | `RoleDraft $roleDraft` `PolicyDraft $policyDraft` `RoleDraft $updatedRoleDraft`                                          |

## Assigning roles

| Event                              | Dispatched by                        | Properties                                                                      |
| ---------------------------------- | ------------------------------------ | ------------------------------------------------------------------------------- |
| `BeforeAssignRoleToUserEvent`      | `RoleService::assignRoleToUser`      | `Role $role` `User $user` `Limitation\RoleLimitation $roleLimitation`           |
| `AssignRoleToUserEvent`            | `RoleService::assignRoleToUser`      | `Role $role` `User $user` `Limitation\RoleLimitation $roleLimitation`           |
| `BeforeAssignRoleToUserGroupEvent` | `RoleService::assignRoleToUserGroup` | `Role $role` `UserGroup $userGroup` `Limitation\RoleLimitation $roleLimitation` |
| `AssignRoleToUserGroupEvent`       | `RoleService::assignRoleToUserGroup` | `Role $role` `UserGroup $userGroup` `Limitation\RoleLimitation $roleLimitation` |
| `BeforeRemoveRoleAssignmentEvent`  | `RoleService::removeRoleAssignment`  | `RoleAssignment $roleAssignment`                                                |
| `RemoveRoleAssignmentEvent`        | `RoleService::removeRoleAssignment`  | `RoleAssignment $roleAssignment`                                                |
