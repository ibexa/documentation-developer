---
description: Control access to parts of the system by fine-tuning permissions with the use of Limitations.
page_type: reference
---

# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [policies](permission_overview.md).
While a policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain limitations also serve as role limitations, which means they can be used to limit the rights of a role assignment.
Currently, this covers [subtree of location](limitation_reference.md#subtree-limitation) and [Section](limitation_reference.md#section-limitation).

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual limitations.
