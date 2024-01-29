---
description: Activity Log Search
page_type: reference
---

# Activity Log Search reference

Activity Log Search Criteria and Sort Clauses are used to build `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query` for `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface::find`.

Criteria and Sort Clauses are applied to log entry groups. For example, with the criteria `ActionCriterion`, you will obtain log entry groups having an entry with this action, containing all their entries with eventually various actions.

## Activity Log Search Criteria reference

Criteria are found in the `Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion\` namespace.

### Value Criterion

| Search Criterion    | Search based on                                             |
|---------------------|-------------------------------------------------------------|
| `ActionCriterion`   | Performed action name(s)                                    |
| `LoggedAtCriterion` | Before, after or at a given date and time                   |
| `ObjectCriterion`   | Manipulated object's classname, and optionally objects' IDs |
| `UserCriterion`     | User performing the action                                  |

### Logical Criterion

- `LogicalNot`: Logical NOT criterion that matches if the provided Criteria doesn't match.
- `LogicalAnd`: Logical AND criterion that matches if all the provided Criteria match.
- `LogicalOr`: Logical OR criterion that matches if at least one of the provided Criteria matches.

## Activity Log Search Sort Clauses reference

Sort Clauses are found in the `Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause\` namespace.

- LoggedAtSortClause: Sort Activity Log entries by their date and time, descending or ascending.
