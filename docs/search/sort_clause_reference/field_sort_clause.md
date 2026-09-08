---
description: Field Sort Clause
---

# Field Sort Clause

The `Field` Sort Clause sorts search results by the value of one of the content items' fields.

Search results of the provided content type are sorted in field value order.
Results of the query that don't belong to the content type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the field belongs
- `fieldIdentifier` - string representing the identifier of the field to sort by [[= include_file('docs/snippets/sort_direction.md') =]]
