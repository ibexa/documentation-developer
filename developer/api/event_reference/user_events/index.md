# User events

Events that are triggered when working with users and user groups.

| Event                   | Dispatched by             | Properties                                                               |
| ----------------------- | ------------------------- | ------------------------------------------------------------------------ |
| `BeforeCreateUserEvent` | `UserService::createUser` | `UserCreateStruct $userCreateStruct` `array $parentGroups` `?User $user` |
| `CreateUserEvent`       | `UserService::createUser` | `UserCreateStruct $userCreateStruct` `array $parentGroups` `User $user`  |
| `BeforeUpdateUserEvent` | `UserService::updateUser` | `User $user` `UserUpdateStruct $userUpdateStruct` `?User $updatedUser`   |
| `UpdateUserEvent`       | `UserService::updateUser` | `User $user` `UserUpdateStruct $userUpdateStruct` `User $updatedUser`    |
| `BeforeDeleteUserEvent` | `UserService::deleteUser` | `User $user` `array or null $locations`                                  |
| `DeleteUserEvent`       | `UserService::deleteUser` | `User $user` `array $locations`                                          |

## User groups

| Event                        | Dispatched by                  | Properties                                                                                           |
| ---------------------------- | ------------------------------ | ---------------------------------------------------------------------------------------------------- |
| `BeforeCreateUserGroupEvent` | `UserService::createUserGroup` | `UserGroupCreateStruct $userGroupCreateStruct` `UserGroup $parentGroup` `?UserGroup $userGroup`      |
| `CreateUserGroupEvent`       | `UserService::createUserGroup` | `UserGroupCreateStruct $userGroupCreateStruct` `UserGroup $parentGroup` `UserGroup $userGroup`       |
| `BeforeUpdateUserGroupEvent` | `UserService::updateUserGroup` | `UserGroup $userGroup` `UserGroupUpdateStruct $userGroupUpdateStruct` `?UserGroup $updatedUserGroup` |
| `UpdateUserGroupEvent`       | `UserService::updateUserGroup` | `UserGroup $userGroup` `UserGroupUpdateStruct $userGroupUpdateStruct`                                |
| `BeforeDeleteUserGroupEvent` | `UserService::deleteUserGroup` | `UserGroup $userGroup` `array or null $locations`                                                    |
| `DeleteUserGroupEvent`       | `UserService::deleteUserGroup` | `UserGroup $userGroup` `array $locations`                                                            |
| `BeforeMoveUserGroupEvent`   | `UserService::moveUserGroup`   | `UserGroup $userGroup` `UserGroup $newParent`                                                        |
| `MoveUserGroupEvent`         | `UserService::moveUserGroup`   | `UserGroup $userGroup` `UserGroup $newParent`                                                        |

## Assigning to user groups

| Event                                  | Dispatched by                            | Properties                          |
| -------------------------------------- | ---------------------------------------- | ----------------------------------- |
| `BeforeAssignUserToUserGroupEvent`     | `UserService::assignUserToUserGroup`     | `User $user` `UserGroup $userGroup` |
| `AssignUserToUserGroupEvent`           | `UserService::assignUserToUserGroup`     | `User $user` `UserGroup $userGroup` |
| `BeforeUnAssignUserFromUserGroupEvent` | `UserService::unAssignUserFromUserGroup` | `User $user` `UserGroup $userGroup` |
| `UnAssignUserFromUserGroupEvent`       | `UserService::unAssignUserFromUserGroup` | `User $user` `UserGroup $userGroup` |

## Updating User data

| Event                           | Dispatched by                     | Properties                                                                       |
| ------------------------------- | --------------------------------- | -------------------------------------------------------------------------------- |
| `BeforeUpdateUserPasswordEvent` | `UserService::updateUserPassword` | `User $user` `string $newPassword` `?User $updatedUser`                          |
| `UpdateUserPasswordEvent`       | `UserService::updateUserPassword` | `User $user` `string $newPassword` `User $updatedUser`                           |
| `BeforeUpdateUserTokenEvent`    | `UserService::updateUserToken`    | `User $user` `UserTokenUpdateStruct $userTokenUpdateStruct` `?User $updatedUser` |
| `UpdateUserTokenEvent`          | `UserService::updateUserToken`    | `User $user` `UserTokenUpdateStruct $userTokenUpdateStruct` `User $updatedUser`  |
