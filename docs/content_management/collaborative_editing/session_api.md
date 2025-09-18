---
description: You can use the PHP API to create a new session, update an existing one, find or delete it, and add or remove participants.
editions:
    - lts-update
month_change: true
---

# Session API

[`SessionService`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html) enables you work with the collaborative session. You can, for example, create a new one, update or delete an existing one, and add or remove participants taking part in the session.

## Create session

You can create new collaboration session with [`SessionService::createSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession):

``` php
    $this->innerService->createSession($createStruct);
```
## Get session

You can get an existing collaboration session with [`SessionService::getSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession):

- using given id - with [`SessionService::getSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSession)

- using given token - with [`SessionService::getSessionByToken`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_getSessionByToken)

## Find sessions

You can find an existing session with [`SessionService::findSessions`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_findSessions) by:

``` php
    $this->innerService->findSessions($query);
```

## Update session

You can update existing invitation with [`SessionService::updateSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession):

``` php
    $this->innerService->updateSession($session, $updateStruct);
```

## Delete session

You can delete session with [`SessionService::deleteSession`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession):

``` php
    $this->innerService->deleteSession($session);
```

# Participant API

## Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant):

``` php
{
    $session = $this->sessionService->getSession(1);
    $participant = $sessionService->addParticipant($session, $createStruct);
    $createStruct = new ParticipantCreateStruct($user);
}
```

## Update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant):

``` php
    $this->innerService->updateParticipant($session, $participant, $updateStruct);
```
## Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant):

``` php
    $this->innerService->removeParticipant($session, $participant);
```

## Check session owner

You can check the owner of the collaboration session with [`SessionService::isSessionOwner`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceDecorator.html#method_isSessionOwner):

``` php
    $this->innerService->isSessionOwner($session, $user);
```

## Check session participant

You can check the participant of the collaboration session with [`SessionService::isSessionParticipant`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_isSessionParticipant):

``` php
    $this->innerService->isSessionOwner($session, $user);
```