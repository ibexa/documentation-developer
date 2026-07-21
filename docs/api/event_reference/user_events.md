---
description: Events that are triggered when working with users and user groups.
page_type: reference
---

# User events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateUserEvent`|`UserService::createUser`|`UserCreateStruct $userCreateStruct`</br>`array $parentGroups`</br>`?User $user`|
|`CreateUserEvent`|`UserService::createUser`|`UserCreateStruct $userCreateStruct`</br>`array $parentGroups`</br>`User $user`|
|`BeforeUpdateUserEvent`|`UserService::updateUser`|`User $user`</br>`UserUpdateStruct $userUpdateStruct`</br>`?User $updatedUser`|
|`UpdateUserEvent`|`UserService::updateUser`|`User $user`</br>`UserUpdateStruct $userUpdateStruct`</br>`User $updatedUser`|
|`BeforeDeleteUserEvent`|`UserService::deleteUser`|`User $user`</br>`array or null $locations`|
|`DeleteUserEvent`|`UserService::deleteUser`|`User $user`</br>`array $locations`|

## User groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateUserGroupEvent`|`UserService::createUserGroup`|`UserGroupCreateStruct $userGroupCreateStruct`</br>`UserGroup $parentGroup`</br>`?UserGroup $userGroup`|
|`CreateUserGroupEvent`|`UserService::createUserGroup`|`UserGroupCreateStruct $userGroupCreateStruct`</br>`UserGroup $parentGroup`</br>`UserGroup $userGroup`|
|`BeforeUpdateUserGroupEvent`|`UserService::updateUserGroup`|`UserGroup $userGroup`</br>`UserGroupUpdateStruct $userGroupUpdateStruct`</br>`?UserGroup $updatedUserGroup`|
|`UpdateUserGroupEvent`|`UserService::updateUserGroup`|`UserGroup $userGroup`</br>`UserGroupUpdateStruct $userGroupUpdateStruct`|
|`BeforeDeleteUserGroupEvent`|`UserService::deleteUserGroup`|`UserGroup $userGroup`</br>`array or null $locations`|
|`DeleteUserGroupEvent`|`UserService::deleteUserGroup`|`UserGroup $userGroup`</br>`array $locations`|
|`BeforeMoveUserGroupEvent`|`UserService::moveUserGroup`|`UserGroup $userGroup`</br>`UserGroup $newParent`|
|`MoveUserGroupEvent`|`UserService::moveUserGroup`|`UserGroup $userGroup`</br>`UserGroup $newParent`|

## Assigning to user groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignUserToUserGroupEvent`|`UserService::assignUserToUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`AssignUserToUserGroupEvent`|`UserService::assignUserToUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`BeforeUnAssignUserFromUserGroupEvent`|`UserService::unAssignUserFromUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`UnAssignUserFromUserGroupEvent`|`UserService::unAssignUserFromUserGroup`|`User $user`</br>`UserGroup $userGroup`|

## Updating User data

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeUpdateUserPasswordEvent`|`UserService::updateUserPassword`|`User $user`</br>`string $newPassword`</br>`?User $updatedUser`|
|`UpdateUserPasswordEvent`|`UserService::updateUserPassword`|`User $user`</br>`string $newPassword`</br>`User $updatedUser`|
|`BeforeUpdateUserTokenEvent`|`UserService::updateUserToken`|`User $user`</br>`UserTokenUpdateStruct $userTokenUpdateStruct`</br>`?User $updatedUser`|
|`UpdateUserTokenEvent`|`UserService::updateUserToken`|`User $user`</br>`UserTokenUpdateStruct $userTokenUpdateStruct`</br>`User $updatedUser`|
