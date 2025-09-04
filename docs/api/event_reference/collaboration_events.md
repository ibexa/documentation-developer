---
description: Events that are triggered when working with collaborative editing feature.
page_type: reference
month_change: false
---

# Collaboration events

## Invitation events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateInvitationEvent`|`InvitationService::createInvitation`|`InvitationCreateStruct $createStruct`<br/>`?InvitationInterface $invitation`|
|`BeforeDeleteInvitationEvent`|`InvitationService::deleteInvitation`|`InvitationInterface $invitation`|
|`BeforeUpdateInvitationEvent`|`InvitationService::updateInvitation`|`InvitationUpdateStruct $createStruct`<br/>`?InvitationInterface $invitation`|
|`CreateInvitationEvent`|`InvitationService::createInvitation`|`InvitationCreateStruct $createStruct`<br/>`?InvitationInterface $invitation`|
|`DeleteInvitationEvent`|`InvitationService::deleteInvitation`|`InvitationInterface $invitation`|
|`UpdateInvitationEvent`|`InvitationService::updateInvitation`|`InvitationUpdateStruct $createStruct`<br/>`?InvitationInterface $invitation`|

## Participant events

| Event | Dispatched by |
|---|---|
|`AddParticipantEvent`|`SessionService::addParticipant`|`SessionInterface $participant`</br>`EntryAddStruct $entryAddStruct`</br>`SessionInterface $parcicipanttResult`|
|`BeforeAddParticipantEvent`|`SessionService::addParticipant`|`SessionInterface $participant`</br>`EntryAddStruct $entryAddStruct`</br>`SessionInterface $parcicipanttResult`|
|`BeforeRemoveParticipantEvent`|`SessionService::removeParticipant`|`SessionInterface $participant`</br>`EntryInterface $entry`</br>`?SessionInterface $participantResult = null`|
|`BeforeUpdateParticipantEvent`|`SessionService::updateParticipant`|`SessionInterface $participant`</br>`ParticipantUpdateStruct $updateStruct`|
|`RemoveParticipantEvent`|`SessionService::removeParticipant`|`SessionInterface $participant`</br>`EntryInterface $entry`</br>`?SessionInterface $participantResult = null`|
|`UpdateParticipantEvent`|`SessionService::updateParticipant`|`SessionInterface $participant`</br>`ParticipantUpdateStruct $updateStruct`|

## Session events

| Event | Dispatched by |
|---|---|---|
|`BeforeCreateSessionEvent`|`SessionService::createSession`|`SessionCreateStruct $createStruct`<br/>`?SessionInterface $session`|
|`BeforeDeleteSessionEvent`|`SessionService::deleteSession`|`SessionInterface $session`|
|`BeforeUpdateSessionEvent`|`SessionService::updateSession`|`SessionUpdateStruct $updateStruct`<br/>`?SessionInterface $session`|
|`CreateSessionEvent`|`SessionService::createSession`|`SessionCreateStruct $createStruct`<br/>`?SessionInterface $session`|
|`DeleteSessionEvent`|`SessionService::deleteSession`|`SessionInterface $session`|
|`JoinSessionEvent`|`SessionService::joinSession`|`SessionInterface $session`|
|`LeaveSessionEvent`|`SessionService::leaveSession`|`SessionInterface $session`|
|`UpdateSessionEvent`|`SessionService::updateSession`|`SessionUpdateStruct $updateStruct`<br/>`?SessionInterface $session`|