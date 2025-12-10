---
description: Use PHP API to manage invitations, sessions, and participants while using collaborative editing feature.
editions:
    - lts-update
month_change: false
---

# Collaborative editing API

[[= product_name =]]'s Collaborative editing API provides two services for managing sessions and invitations, which differ in function:

- [`InvitationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html) is used to manage collaboration sessions invitations

- [`SessionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html) is used to manage collaboration sessions

## Managing sessions

### Create session

You can create new content collaboration session with [`SessionService::createSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 69, 81) =]]
```

### Get session

You can get an existing collaboration session by using:

- Session id - with [`SessionService::getSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession)

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 82, 83) =]]
```

- Token - with [`SessionService::getSessionByToken()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSessionByToken)

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 83, 84) =]]
```

### Find sessions

You can find an existing session with [`SessionService::findSessions()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_findSessions) by passing a SessionQuery object:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 86, 89) =]]
```

To learn more about the available search options, see [Search Criteria](collaboration_criteria.md) and [Sort Clauses](collaboration_sort_clauses.md) for Collaborative editing.

### Update session

You can update existing invitation with [`SessionService::updateSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 90, 95) =]]
```

### Delete session

You can delete session with [`SessionService::deleteSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 169, 170) =]]
```

## Managing participants

### Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 102, 116) =]]
```

You can add internal participants - users who already have an account in the [[= product_name =]], or external ones.
External participant can only be invited using their email address.

The `ContentSessionScope::VIEW` constant defines the type of access granted to a participant.
Available scopes are:

- `VIEW` - read-only access, used for preview purposes
- `EDIT` - grants editing capabilities

### Get and update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant).
The example below updates participant's permissions to allow for editing of shared content, not only previewing.

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 117, 125) =]]
```
### Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 126, 127) =]]
```

### Check session owner

You can check the owner of the collaboration session with [`SessionService::isSessionOwner()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceDecorator.html#method_isSessionOwner):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 129, 134) =]]
```

If no user is provided, current user is used.

### Check session participant

You can check whether a user belongs to a collaboration session with [`SessionService::isSessionParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_isSessionParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 135, 140) =]]
```

## Managing invitations

### Manage invitation

You can get an invitation with [`InvitationService::getInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_getInvitation):


``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 141, 150) =]]
```

### Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation) method:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 151, 158) =]]
```

You can use it when [auto-inviting participants](install_collaborative_editing.md#configuration) is not enabled.

### Update invitation

You can update existing invitation with [`InvitationService::updateInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 159, 164) =]]
```

### Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 165, 168) =]]
```

### Find invitations

You can find an invitation with [`InvitationService::findInvitations()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_findInvitations).

To learn more about the available search options, see [Search Criteria](collaboration_criteria.md) and [Sort Clauses](collaboration_sort_clauses.md) for Collaborative editing.

## Example API usage

Below you can see an example of API usage for Collaborative editing:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php') =]]
```
