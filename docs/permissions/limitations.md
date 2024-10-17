---
description: Control access to parts of the system by fine-tuning permissions with the use of Limitations.
page_type: reference
---

# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permission_overview.md).
While a policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain limitations also serve as role limitations, which means they can be used to limit the rights of a role assignment.
Currently, this covers [Subtree of Location](limitation_reference.md#subtree-limitation), [Section](limitation_reference.md#section-limitation) and [Personalization access](limitation_reference.md#personalization-access-limitation) limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regard to permission logic (see [`Ibexa\Contracts\Core\Limitation`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Limitation-Type.html) interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to Search Criteria for filtering search based on permissions. |

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual limitations.
