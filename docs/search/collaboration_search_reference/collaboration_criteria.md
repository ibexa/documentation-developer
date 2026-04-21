---
month_change: false
description: Search Criteria available for Collaboration search
---

# Collaboration Search Criterion reference

Search Criteria are found in the `Ibexa\Contracts\Collaboration\Invitation\Query\Criterion` namespace.
Use them to work with objects related to [Collaborative editing API](collaborative_editing_api.md).

## Invitation Search Criteria

Invitation Search Criteria are implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [CreatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-CreatedAt.html) | Find invitations based on the date they were created |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Id.html) | Find invitations with given invitation ID |
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple criteria using the AND condition |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple criteria using the OR condition |
| [ParticipantScope](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-ParticipantScope.html) | Find invitations based on participant's scope, see [`ContentSessionScope`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Share-Collaboration-ContentSessionScope.html) for content-sharing sessions |
| [ParticipantType](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-ParticipantType.html) | Find invitations based on participant type, see [`ParticipantDiscriminator`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Participant-ParticipantDiscriminator.html) |
| [Sender](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Sender.html) | Find invitations by invitation sender |
| [Session](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Session.html) | Find invitations by collaboration session |
| [Status](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Status.html) | Find invitations with given status|
| [UpdatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-UpdatedAt.html) | Find invitations based on the date they were updated |

## Session Search Criteria

Session Search Criteria are implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [CreatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-CreatedAt.html) | Find sessions based on the date they were created |
| [Email](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Email.html) | Find sessions based on external participant email |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Id.html) | Find sessions with the session ID |
| [IsActive](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-IsActive.html) | Find sessions based on active status |
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple criteria using the AND condition |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple criteria using the OR condition |
| [Owner](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Owner.html) | Find sessions by their owner |
| [ParticipantToken](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-ParticipantToken.html) | Find sessions by participant token |
| [Token](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Token.html) | Find sessions with given token|
| [Type](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Type.html) | Find sessions by type |
| [UpdatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-UpdatedAt.html) | Find sessions based on the date they were updated |
| [UserId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-UserId.html) | Find sessions with given user ID |

### Example

The following example shows how you can use the criteria to find all the currently active sessions:

```php hl_lines="11-15"
[[= include_file('code_samples/collaboration/src/Query/Search.php') =]]
```

The criteria limit the result set to sessions matching all of the conditions listed below:

- session has an active status
- session has a `content` type
- session creation date is within the last week
