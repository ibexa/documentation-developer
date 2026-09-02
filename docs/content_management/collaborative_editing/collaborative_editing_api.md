---
description: Use PHP API to manage invitations, sessions, and participants while using collaborative editing feature.
month_change: false
---

# Collaborative editing API

[[= product_name =]]'s Collaborative editing API provides two services for managing sessions and invitations, which differ in function:

- [`InvitationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html) is used to manage collaboration sessions invitations
- [`SessionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html) is used to manage collaboration sessions

## Managing sessions

### Create session

You can create new collaboration session with [`SessionService::createSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 48, 58, remove_indent=True) =]]
```

### Get session

You can get an existing collaboration session with [`SessionService::getSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession):

- using given id - with [`SessionService::getSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession)

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 61, 61, remove_indent=True) =]]
```

- using given token - with [`SessionService::getSessionByToken()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSessionByToken)

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 62, 62, remove_indent=True) =]]
```

### Find sessions

You can find an existing session with [`SessionService::findSessions()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_findSessions) by passing a SessionQuery object:

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 65, 66, remove_indent=True) =]]
```

To learn more about the available search options, see [Search Criteria](collaboration_criteria.md) and [Sort Clauses](collaboration_sort_clauses.md) for Collaborative editing.

### Update session

You can update existing invitation with [`SessionService::updateSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 69, 72, remove_indent=True) =]]
```

### Delete session

You can delete session with [`SessionService::deleteSession()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 148, 148, remove_indent=True) =]]
```

## Managing participants

### Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 81, 93, remove_indent=True) =]]
```

Participants can be internal (based on an existing user) or external (on an email address):

[`InternalParticipantCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-InternalParticipantCreateStruct.html#properties)
[`ExternalParticipantCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-ExternalParticipantCreateStruct.html#properties)

Two scopes are available:

- [`ContentSessionScope::EDIT`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Share-Collaboration-ContentSessionScope.html#constant_EDIT)
- [`ContentSessionScope::VIEW`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Share-Collaboration-ContentSessionScope.html#constant_VIEW)

### Get and update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 96, 102, remove_indent=True) =]]
```

The example below updates participant's permissions to allow for editing of shared content, not only previewing.

### Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 105, 105, remove_indent=True) =]]
```

### Check session owner

You can check whether a user belongs to a collaboration session with [`SessionService::isSessionOwner()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceDecorator.html#method_isSessionOwner):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 108, 111, remove_indent=True) =]]
```

If no user is provided, current user is used.

### Check session participant

You can check the participant of the collaboration session with [`SessionService::isSessionParticipant()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_isSessionParticipant):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 114, 117, remove_indent=True) =]]
```

## Managing invitations

### Manage invitation

You can get an invitation with [`InvitationService::getInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_getInvitation):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 127, 127, remove_indent=True) =]]
```

### Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation) method:

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 130, 135, remove_indent=True) =]]
```

You can use it when auto-inviting participants is not enabled.

### Update invitation

You can update existing invitation with [`InvitationService::updateInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 138, 141, remove_indent=True) =]]
```

### Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 144, 145, remove_indent=True) =]]
```

### Find invitations

You can find an invitation with [`InvitationService::findInvitations()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_findInvitations):

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 120, 125, remove_indent=True) =]]
```

To learn more about the available search options, see [Search Criteria](collaboration_criteria.md) and [Sort Clauses](collaboration_sort_clauses.md) for Collaborative editing.

## Example API usage

Below you can see an example of API usage for Collaborative editing:

``` php
[[= include_code('code_samples/collaboration/src/Command/ManageSessionsCommand.php') =]]
```
