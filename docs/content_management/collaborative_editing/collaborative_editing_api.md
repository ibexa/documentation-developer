---
description: Use PHP API to manage invitations, sessions, and participants while using collaborative editing feature.
month_change: true
---

# Collaborative editing API

[[= product_name =]]'s Collaborative editing API provides two services for managing sessions and invitations, which differ in function:

- [`InvitationServiceInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html) is used to manage collaboration sessions invitations
- [`SessionServiceInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html) is used to manage collaboration sessions

## Managing sessions

### Create session

You can create new collaboration session with [`SessionService::createSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 53, 65) =]]
```

### Get session

You can get an existing collaboration session with [`SessionService::getSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession):

- using given id - with [`SessionService::getSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession)

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 66, 67) =]]
```

- using given token - with [`SessionService::getSessionByToken`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSessionByToken)

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 67, 68) =]]
```

### Find sessions

You can find an existing session with [`SessionService::findSessions`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_findSessions) by:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 70, 73) =]]
```

### Update session

You can update existing invitation with [`SessionService::updateSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 74, 79) =]]
```

### Delete session

You can delete session with [`SessionService::deleteSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 153, 154) =]]
```

## Managing participants

### Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 86, 100) =]]
```

### Get and update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 101, 109) =]]
```
### Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 110, 111) =]]
```

### Check session owner

You can check the owner of the collaboration session with [`SessionService::isSessionOwner`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceDecorator.html#method_isSessionOwner):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 113, 118) =]]
```

If no user is provided, current user is used.

### Check session participant

You can check the participant of the collaboration session with [`SessionService::isSessionParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_isSessionParticipant):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 119, 124) =]]
```

## Managing invitations

### Manage invitation

You can get an invitation with [`InvitationService::getInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_getInvitation):


``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 125, 134) =]]
```

You can select the parameter that you can read from an invitation:

- Invitation ID:

``` php
    $invitation->getId();
```

- Session ID:

``` php
    $invitation->getSession()->getId();
```

- Participant ID:

``` php
    $invitation->getParticipant()->getId();
```
    
- Invitation status:

``` php
    $invitation->getStatus();
```

### Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation) method:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 135, 142) =]]
```

You can use it when auto-inviting participants is not enabled.

### Update invitation

You can update existing invitation with [`InvitationService::updateInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 143, 148) =]]
```

### Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation):

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php', 149, 152) =]]
```

### Find invitations

You can find an invitation with [`InvitationService::findInvitations`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_findInvitations).

To learn more about the available search options, see Search Criteria and Sort Clauses for Collaborative editing.

## Example API usage

Below you can see an example of API usage for Collaborative editing:

``` php
[[= include_file('code_samples/collaboration/src/Command/ManageSessionsCommand.php') =]]
```