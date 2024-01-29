---
description: Activity Log Search Criteria
page_type: reference
---

# Activity Log Search Criteria reference

Activity Log Search Criteria are found in the `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion\` namespace.

Those Criteria `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query` for `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface::find`.

They are applied to log entry groups. For example, with the criteria `ActionCriterion`, you will obtain log entry groups having an entry with this action, containing all their entries with eventually various actions.

## Value Criterion

| Search Criterion                                  | Search based on                                             |
|---------------------------------------------------|-------------------------------------------------------------|
| [`ActionCriterion`](action_criterion.md)          | Performed action name(s)                                    |
| [`LoggedAtCriterion`](logged_at_criterion.md)     | Before, after or at a given date and time                   |
| [`ObjectCriterion`](object_criterion.md)          | Manipulated object's classname, and optionally objects' IDs |
| [`ObjectNameCriterion`](object_name_criterion.md) | Manipulated object's name, in whole or in part              |
| [`UserCriterion`](user_criterion.md)              | User performing the action                                  |

## Logical Criterion

- `LogicalNot`: Logical NOT criterion that matches if the provided Criteria doesn't match.
- `LogicalAnd`: Logical AND criterion that matches if all the provided Criteria match.
- `LogicalOr`: Logical OR criterion that matches if at least one of the provided Criteria matches.
