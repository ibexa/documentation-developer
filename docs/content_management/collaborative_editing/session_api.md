---
description: You can use the PHP API to create new session, update existing one, find or delete it, and add or remove participants.
---

# Session API

[`SessionService`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html) enables you work with the collaborative session, for example, create a new one, update or delete existing one, and add or remove new participants to join collaborative session.

## Create session

You can create new collaboration session with given id with [`SessionService::createSession`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_createSession):

``` php
    $this->innerService->createSession($createStruct);
```
## Get session

You can return existing collaboration session with [`SessionService::getSession`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_getSession):

- using given id:

``` php
    $this->innerService->getSession($id);
```

- using given token:

``` php
    $this->innerService->getSessionByToken($token);
```

- matching the given query:

``` php
    $this->innerService->findSessions($query);
```

## Find session

You can find an existing session with [`SessionService::findSession`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_findSession) by:

``` php
    $this->innerService->findSessions($query);
```

## Update session

You can update existing invitation with [`SessionService::updateSession`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_updateSession):

``` php
    $this->innerService->updateSession($session, $updateStruct);
```

## Delete session

You can delete session with [`SessionService::deleteSession`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_deleteSession):

``` php
    $this->innerService->deleteSession($session);
```

# Participant API

## Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_addParticipant):

``` php
    $this->innerService->addParticipant($session, $createStruct);
```

## Update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_updateParticipant):

``` php
    $this->innerService->updateParticipant($session, $participant, $updateStruct);
```
## Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_removeParticipant):

``` php
    $this->innerService->removeParticipant($session, $participant);
```

## Check session Owner

You can check the Owner of the collaboration session with [`SessionService::removeParticipant`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SessionService.html#method_removeParticipant):

``` php
    $this->innerService->isSessionOwner($session, $user);
```