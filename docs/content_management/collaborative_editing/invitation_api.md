---
description: You can use the PHP API to create new invitation, update existing one, read or delete it.
---

# Invitation API

[`InvitationService`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html) enables you to read, add, update, and remove invitation for collaborative editing session.

## Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html#method_createInvitation) method:

``` php
{
    $session = self::getSessionService()->getSession(self::EXAMPLE_SESSION_ID);
    $participant = $session->getParticipants()->getById(self::EXAMPLE_PARTICIPANT_ID);

    $createStruct = new InvitationCreateStruct($session, $participant);
    $createStruct->setContext([
        'message' => 'Hello, would you like to join my session?',
    ]);

    $invitation = $this->getInvitationService()->createInvitation($createStruct);

    self::assertEquals(InvitationStatus::STATUS_PENDING, $invitation->getStatus());
    self::assertEquals([
        'message' => 'Hello, would you like to join my session?',
    ], $invitation->getContext());
}
```

## Read invitation

You can read an invitation with [`InvitationService::getInvitation`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html#method_deleteInvitation):

``` php
    $this->getInvitationService()->getInvitation(self::EXAMPLE_INVITATION_ID);
```

You can select the parameter that you can read from an invitaion:

- Invitation ID:

``` php
    self::assertEquals(self::EXAMPLE_INVITATION_ID, $invitation->getId());
```

- Session ID:

``` php
    self::assertEquals(self::EXAMPLE_SESSION_ID, $invitation->getSession()->getId());
```

- Participant ID:

``` php
    self::assertEquals(self::EXAMPLE_PARTICIPANT_ID, $invitation->getParticipant()->getId());
```
    
- Invitation status:

``` php
    self::assertEquals(InvitationStatus::STATUS_PENDING, $invitation->getStatus());
```

## Find invitation

You can find an invitation with [`InvitationService::findInvitation`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html#method_deleteInvitation) by:

- Invitation ID:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/(?).php', , ) =]]
```

- Session ID:

- Participant ID:

- Invitation status:

## Update invitation

You can update existing invitation with [`InvitationService::deleteInvitation`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html#method_deleteInvitation):

``` php
$invitation = $this->getInvitationService()->getInvitation(self::EXAMPLE_INVITATION_ID);
```

## Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-InvitationService.html#method_deleteInvitation):

``` php
    $this->getInvitationService()->deleteInvitation($invitation);
```