---
month_change: true
---

# Collaboration Search Criterion reference

Search Criteria are found in the `Ibexa\Contracts\Collaboration\Invitation\Query\Criterion` namespace.

## Invitation Search Criteria

Invitation Search Criteria are implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [CreatedAtCriterion](api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-CreatedAt.html) | Find invitations based on the date they were created |
| [IdCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Id.html) | Find invitations with given invitation ID |
| [LogicalAndCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple invitations using the AND condition |
| [LogicalOrCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple invitations using the OR condition |
| [SenderCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Sender.html) | Find invitations by invitation sender |
| [SessionCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Session.html) | Find invitations by collaboration session |
| [StatusCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-Status.html) | Find invitations with given status|
| [UpdatedAtCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-Criterion-UpdatedAt.html) | Find invitations based on the date they were updated |

## Session Search Criteria

Session Search Criteria are implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [CreatedAtCriterion](api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-CreatedAt.html) | Find sessions based on the date they were created |
| [EmailCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Email.html) | Find sessions based on external participant email |
| [IdCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Id.html) | Find sessions with the session ID |
| [IsActiveCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-IsActive.html) | Find sessions based on active status |
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple sessions using the AND condition |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple sessions using the OR condition |
| [OwnerCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Owner.html) | Find sessions by their owner |
| [ParticipantTokenCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-ParticipantToken.html) | Find sessions by participant token |
| [TokenCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Token.html) | Find sessions with given token|
| [TypeCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-Type.html) | Find sessions by type |
| [UpdatedAtCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-UpdatedAt.html) | Find sessions based on the date they were updated |
| [UserIdCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-UserId.html) | Find sessions with given user ID |

### Example

The following example shows how you can use the criteria to find all the currently active sessions:

```php hl_lines="13-20"
[[= include_file('code_samples/collaboration/src/Query/Search.php') =]]
```

The criteria limit the result set to sessions matching all of the conditions listed below:

- session has an active status
- session has a `content` type
- session creation date is not after the current date