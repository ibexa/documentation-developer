---
description: You can use the PHP API to create new invitation, update existing one, read or delete it.
editions:
    - lts-update
month_change: true
---

# Invitation API

[`InvitationService`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html) enables you to read, add, update, and remove invitation for collaborative editing session.

## Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation) method:

``` php
{
    $session = $this->sessionService->getSession(1);
    $participant = $session->getParticipants()->getByEmail('foo@link.invalid');
    $createStruct = new InvitationCreateStruct($session, $participant);
    $createStruct->setContext([
        'message' => 'Hello, would you like to join my session?',
    ]);
    $invitation = $this->invitationService->createInvitation($createStruct);
}
```

## Get invitation by ID

You can get an invitation by ID with [`InvitationService::getInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_getInvitation):

``` php
    $this->invitationService->getInvitation(1);
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

## Get invitation by participant

You can get an invitation by participant with [`InvitationService::getInvitationByParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_getInvitationByParticipant):

``` php
    $this->innerService->getInvitationByParticipant($participant);
```

## Find invitations

You can find an invitation with [`InvitationService::findInvitations`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_findInvitations).

To learn more about the available search options, see Search Criteria and Sort Clauses for Collaborative editing.

## Update invitation

You can update existing invitation with [`InvitationService::updateInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation):

``` php
    $invitation = $this->invitationService->getInvitation(1);
    $updateStruct = new InvitationUpdateStruct();
    $updateStruct->setStatus(InvitationStatus::STATUS_ACCEPTED);
    $invitation = $this->invitationService->updateInvitation($invitation, $updateStruct);
```

## Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation):

``` php
    $invitation = $this->invitationService->getInvitation(1);
    $this->invitationService->deleteInvitation($invitation);
```