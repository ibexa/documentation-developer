---
description: Control access to parts of the system by fine-tuning permissions with the use of Limitations.
page_type: reference
---

# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permission_overview.md).
While a Policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment.
Currently, this covers [Subtree of Location](limitation_reference.md#subtree-limitation), [Section](limitation_reference.md#section-limitation) and [Personalization access](limitation_reference.md#personalization-access-limitation) Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see [`Ibexa\Contracts\Core\Limitation`](https://github.com/ibexa/core/blob/main/src/contracts/Limitation/Type.php) interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual Limitations.
