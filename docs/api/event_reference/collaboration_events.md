---
description: Events that are triggered when working with collaborative editing feature.
page_type: reference
month_change: false
---

# Collaboration events

## Invitation events

| Event | Dispatched by |
|---|---|
|[BeforeCreateInvitationEvent](../php_api/php_api_reference/classes/)|[InvitationServicenterface](../php_api/php_api_reference/classes/.html)|
|[BeforeDeleteInvitationEvent](../php_api/php_api_reference/classes/)|[InvitationServicenterface](../php_api/php_api_reference/classes/.html)|
|[BeforeUpdateInvitationEvent](../php_api/php_api_reference/classes/)|[[InvitationServicenterface](../php_api/php_api_reference/classes/.html)|
|[CreateInvitationEvent](../php_api/php_api_reference/classes/)|[InvitationServiceInterface](../php_api/php_api_reference/classes/.html)|
|[DeleteInvitationEvent](../php_api/php_api_reference/classes/)|[InvitationServiceInterface](../php_api/php_api_reference/classes/.html)|
|[UpdateInvitationEvent](../php_api/php_api_reference/classes/)|[InvitationServiceInterface](../php_api/php_api_reference/classes/.html)|

## Participant events

| Event | Dispatched by |
|---|---|
|[AddParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[BeforeAddParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[BeforeRemoveParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[BeforeUpdateParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[RemoveParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[UpdateParticipantEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|

## Session events

| Event | Dispatched by |
|---|---|---|
|[BeforeCreateSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[BeforeDeleteSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[BeforeUpdateSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[CreateSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[DeleteSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|
|[UpdateSessionEvent](../php_api/php_api_reference/classes/)|[SessionServiceInterface](../php_api/php_api_reference/classes/.html)|