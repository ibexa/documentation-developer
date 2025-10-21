---
description: Events that are triggered when working with collaborative editing feature.
page_type: reference
month_change: false
---

# Collaboration events

## Invitation events

| Event | Dispatched by | Properties |
|---|---|---|
|[BeforeCreateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeCreateInvitationEvent.html)|[InvitationService::createInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation)|`InvitationCreateStruct $createStruct`|
|[BeforeDeleteInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeDeleteInvitationEvent.html)|[InvitationService::deleteInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation)|`InvitationInterface $invitation`|
|[BeforeUpdateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeUpdateInvitationEvent.html)|[InvitationService::updateInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation)|`InvitationInterface $invitation`<br>`InvitationUpdateStruct $updateStruct`|
|[CreateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-CreateInvitationEvent.html)|[InvitationService::createInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation)|`InvitationCreateStruct $createStruct`<br>`InvitationInterface $invitation`|
|[DeleteInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-DeleteInvitationEvent.html)|[InvitationService::deleteInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation)|`InvitationInterface $invitation`|
|[UpdateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-UpdateInvitationEvent.html)|[InvitationService::updateInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation)|`InvitationInterface $invitation`<br>`InvitationUpdateStruct $updateStruct`|

## Participant events

| Event | Dispatched by | Properties |
|---|---|---|
|[AddParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-AddParticipantEvent.html)|[SessionService::addParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant)|`SessionInterface $session`<br>`ParticipantCreateStruct $createStruct`<br>`ParticipantInterface $parcicipant`|
|[BeforeAddParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeAddParticipantEvent.html)|[SessionService::addParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant)|`SessionInterface $session`<br>`ParticipantCreateStruct $createStruct`|
|[BeforeRemoveParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeRemoveParticipantEvent.html)|[SessionService::removeParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant)|`SessionInterface $session`<br>`ParticipantInterface $participant`|
|[BeforeUpdateParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeUpdateParticipantEvent.html)|[SessionService::updateParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant)|`SessionInterface $session`<br>`ParticipantInterface $participant`<br>`ParticipantUpdateStruct $updateStruct`|
|[RemoveParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-RemoveParticipantEvent.html)|[SessionService::removeParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant)|`SessionInterface $session`<br>`ParticipantInterface $participant`|
|[UpdateParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-UpdateParticipantEvent.html)|[SessionService::updateParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant)|`SessionInterface $session`<br>`ParticipantInterface $participant`<br>`ParticipantUpdateStruct $updateStruct`|

## Session events

| Event | Dispatched by | Properties |
|---|---|---|
|[BeforeCreateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeCreateSessionEvent.html)|[SessionService::createSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession)|`AbstractSessionCreateStruct $createStruct`<br>`?SessionInterface $sessionResult`|
|[BeforeDeleteSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeDeleteSessionEvent.html)|[SessionService::deleteSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession)|`SessionInterface $session`|
|[BeforeUpdateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeUpdateSessionEvent.html)|[SessionService::updateSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession)|`SessionInterface $session`<br>`AbstractSessionUpdateStruct $updateStruct`<br>`?SessionInterface $sessionResult`|
|[CreateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-CreateSessionEvent.html)|[SessionService::createSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession)|`AbstractSessionCreateStruct $createStruct`<br>`SessionInterface $sessionResult`|
|[DeleteSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-DeleteSessionEvent.html)|[SessionService::deleteSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession)|`SessionInterface $session`|
|[JoinSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-JoinSessionEvent.html)|`SessionJoinController::joinAction()`|`SessionInterface $session`|
|[LeaveSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-LeaveSessionEvent.html)|`SessionLeaveController::leaveSession()`|`SessionInterface $session`|
|[UpdateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-UpdateSessionEvent.html)|[SessionService::updateSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession)|`SessionInterface $session`<br>`AbstractSessionUpdateStruct $updateStruct`<br>`SessionInterface $sessionResult`|
|[SessionPublicPreviewEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-SessionPublicPreviewEvent.html)|`SessionPublicPreviewController::previewAction()`|`SessionInterface $session`|