---
description: Activity Log Search Criteria
page_type: reference
---

# Activity Log Search Criteria reference

Activity Log Search Criteria are found in the `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion` namespace.

Those Criteria are to be used with `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query` for `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface::find`.

They're applied to log entry groups.
For example, with the criterion `ActionCriterion`, you get log entry groups that have at least one entry with this action (and possibly other actions as well).

See [Searching in the Activity Log groups](recent_activity.md#searching-in-the-activity-log-groups) for how to use a query, and an example combining several criteria.

## Value-based criteria

| Search Criterion                                  | Search based on                                             |
|---------------------------------------------------|-------------------------------------------------------------|
| [`ActionCriterion`](action_criterion.md)          | Performed action name(s)                                    |
| [`LoggedAtCriterion`](logged_at_criterion.md)     | Before, after or at a given date and time                   |
| [`ObjectCriterion`](object_criterion.md)          | Manipulated object's classname, and optionally objects' IDs |
| [`ObjectNameCriterion`](object_name_criterion.md) | Manipulated object's name, in whole or in part              |
| [`UserCriterion`](user_criterion.md)              | User performing the action                                  |

## Logical criteria

| Search Criterion                                  | Description                                             |
|---------------------------------------------------|-------------------------------------------------------------|
| `LogicalNot`          | Logical NOT criterion that matches if the provided Criteria don't match.                           |
| `LogicalAnd`          | Logical AND criterion that matches if all the provided Criteria match.                          |
| `LogicalOr`           | Logical OR criterion that matches if at least one of the provided Criteria matches.      |
