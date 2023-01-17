---
description: Events that are triggered when working with users and User Groups.
---

# User events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateUserEvent`|`UserService::createUser`|`UserCreateStruct $userCreateStruct`</br>`array $parentGroups`</br>`User|null $user`|
|`CreateUserEvent`|`UserService::createUser`|`UserCreateStruct $userCreateStruct`</br>`array $parentGroups`</br>`User $user`|
|`BeforeUpdateUserEvent`|`UserService::updateUser`|`User $user`</br>`UserUpdateStruct $userUpdateStruct`</br>`User|null $updatedUser`|
|`UpdateUserEvent`|`UserService::updateUser`|`User $user`</br>`UserUpdateStruct $userUpdateStruct`</br>`User $updatedUser`|
|`BeforeDeleteUserEvent`|`UserService::deleteUser`|`User $user`</br>`array|null $locations`|
|`DeleteUserEvent`|`UserService::deleteUser`|`User $user`</br>`array $locations`|

## User Groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateUserGroupEvent`|`UserService::createUserGroup`|`UserGroupCreateStruct $userGroupCreateStruct`</br>`UserGroup $parentGroup`</br>`UserGroup|null $userGroup`|
|`CreateUserGroupEvent`|`UserService::createUserGroup`|`UserGroupCreateStruct $userGroupCreateStruct`</br>`UserGroup $parentGroup`</br>`UserGroup $userGroup`|
|`BeforeUpdateUserGroupEvent`|`UserService::updateUserGroup`|`UserGroup $userGroup`</br>`UserGroupUpdateStruct $userGroupUpdateStruct`</br>`UserGroup|null $updatedUserGroup`|
|`UpdateUserGroupEvent`|`UserService::updateUserGroup`|`UserGroup $userGroup`</br>`UserGroupUpdateStruct $userGroupUpdateStruct`|
|`BeforeDeleteUserGroupEvent`|`UserService::deleteUserGroup`|`UserGroup $userGroup`</br>`array|null $locations`|
|`DeleteUserGroupEvent`|`UserService::deleteUserGroup`|`UserGroup $userGroup`</br>`array $locations`|
|`BeforeMoveUserGroupEvent`|`UserService::moveUserGroup`|`UserGroup $userGroup`</br>`UserGroup $newParent`|
|`MoveUserGroupEvent`|`UserService::moveUserGroup`|`UserGroup $userGroup`</br>`UserGroup $newParent`|

## Assigning to User Groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignUserToUserGroupEvent`|`UserService::assignUserToUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`AssignUserToUserGroupEvent`|`UserService::assignUserToUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`BeforeUnAssignUserFromUserGroupEvent`|`UserService::unAssignUserFromUserGroup`|`User $user`</br>`UserGroup $userGroup`|
|`UnAssignUserFromUserGroupEvent`|`UserService::unAssignUserFromUserGroup`|`User $user`</br>`UserGroup $userGroup`|

## Updating User data

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeUpdateUserPasswordEvent`|`UserService::updateUserPassword`|`User $user`</br>`string $newPassword`</br>`User|null $updatedUser`|
|`UpdateUserPasswordEvent`|`UserService::updateUserPassword`|`User $user`</br>`string $newPassword`</br>`User $updatedUser`|
|`BeforeUpdateUserTokenEvent`|`UserService::updateUserToken`|`User $user`</br>`UserTokenUpdateStruct $userTokenUpdateStruct`</br>`User|null $updatedUser`|
|`UpdateUserTokenEvent`|`UserService::updateUserToken`|`User $user`</br>`UserTokenUpdateStruct $userTokenUpdateStruct`</br>`User $updatedUser`|
