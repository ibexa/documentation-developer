---
description: Events that are triggered when working with collaborative editing feature.
page_type: reference
month_change: false
---

# Collaboration events

You can use the following events to extend the [Collaborative editing LTS Update](collaborative_editing.md):

## Invitation events

| Event | Dispatched by |
|---|---|
|[BeforeCreateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeCreateInvitationEvent.html)|[InvitationService::createInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation)|
|[BeforeDeleteInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeDeleteInvitationEvent.html)|[InvitationService::deleteInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation)|
|[BeforeUpdateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-BeforeUpdateInvitationEvent.html)|[InvitationService::updateInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation)|
|[CreateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-CreateInvitationEvent.html)|[InvitationService::createInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_createInvitation)|
|[DeleteInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-DeleteInvitationEvent.html)|[InvitationService::deleteInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_deleteInvitation)|
|[UpdateInvitationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-UpdateInvitationEvent.html)|[InvitationService::updateInvitation()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-InvitationServiceInterface.html#method_updateInvitation)|

## Participant events

| Event | Dispatched by |
|---|---|
|[AddParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-AddParticipantEvent.html)|[SessionService::addParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant)|
|[BeforeAddParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeAddParticipantEvent.html)|[SessionService::addParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_addParticipant)|
|[BeforeRemoveParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeRemoveParticipantEvent.html)|[SessionService::removeParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant)|
|[BeforeUpdateParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-BeforeUpdateParticipantEvent.html)|[SessionService::updateParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant)|
|[RemoveParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-RemoveParticipantEvent.html)|[SessionService::removeParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_removeParticipant)|
|[UpdateParticipantEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-Event-UpdateParticipantEvent.html)|[SessionService::updateParticipant()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateParticipant)|

## Session events

| Event | Dispatched by |
|---|---|
|[BeforeCreateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeCreateSessionEvent.html)|[SessionService::createSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession)|
|[BeforeDeleteSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeDeleteSessionEvent.html)|[SessionService::deleteSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession)|
|[BeforeUpdateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-BeforeUpdateSessionEvent.html)|[SessionService::updateSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession)|
|[CreateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-CreateSessionEvent.html)|[SessionService::createSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_createSession)|
|[DeleteSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-DeleteSessionEvent.html)|[SessionService::deleteSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_deleteSession)|
|[JoinSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-JoinSessionEvent.html)|`SessionJoinController::joinAction()`|
|[LeaveSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-LeaveSessionEvent.html)|`SessionLeaveController::leaveAction()`|
|[UpdateSessionEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-UpdateSessionEvent.html)|[SessionService::updateSession()](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html#method_updateSession)|
|[SessionPublicPreviewEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-SessionPublicPreviewEvent.html)|`SessionPublicPreviewController::previewAction()`|

## User filtering events

| Event | Dispatched by | Description |
|---|---|---|
|<nobr>[`UsersWithPermissionInfoMappedEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Share-Event-UsersWithPermissionInfoMappedEvent.html)</nobr>|`Ibexa\Share\Permission\Mapper\`<br>`UsersWithPermissionInfoMapper` | Allows further filtering of users with permissions for Collaborative editing |
